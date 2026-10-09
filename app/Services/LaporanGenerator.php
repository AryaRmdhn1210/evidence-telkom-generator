<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\Proyek;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Table;

class LaporanGenerator
{
  public function generate(Proyek $proyek, string $tanggalUjiTerima, int $userId): Laporan
  {
    $proyek->load([
      'itemProyek.katalogItem',
      'itemProyek.fotoBukti' => fn($q) => $q->orderBy('nomor_urut'),
    ]);

    $groupedItems = $this->groupItemsByKategori($proyek->itemProyek);
    $evidenceEntries = $this->buildEvidenceEntries($groupedItems);

    $folder = 'laporan/' . $proyek->id;
    Storage::disk('public')->makeDirectory($folder);

    $filenameBase = 'BAUT_' . str($proyek->nama_proyek)->slug() . '_' . now()->format('YmdHis');
    $pdfPath = $folder . '/' . $filenameBase . '.pdf';
    $wordPath = $folder . '/' . $filenameBase . '.docx';

    $this->renderPdf($proyek, $groupedItems, $evidenceEntries, $tanggalUjiTerima, $pdfPath);
    $this->renderWord($proyek, $groupedItems, $evidenceEntries, $tanggalUjiTerima, $wordPath);

    return Laporan::create([
      'proyek_id' => $proyek->id,
      'dibuat_oleh' => $userId,
      'tanggal_uji_terima' => $tanggalUjiTerima,
      'file_pdf' => $pdfPath,
      'file_word' => $wordPath,
    ]);
  }

  protected function groupItemsByKategori($itemProyekCollection): array
  {
    $groups = [];
    $letters = range('A', 'Z');
    $index = 0;

    foreach ($itemProyekCollection->sortBy('urutan_item') as $item) {
      $kategori = $item->katalogItem->kategori_pekerjaan ?: 'LAIN-LAIN';

      if (!isset($groups[$kategori])) {
        $groups[$kategori] = [
          'label' => $letters[$index] ?? ('#' . ($index + 1)),
          'nama' => $kategori,
          'items' => [],
        ];
        $index++;
      }

      $groups[$kategori]['items'][] = $item;
    }

    return array_values($groups);
  }

  /**
   * Susun daftar entri halaman evidence: foto yang ada, lalu slot kosong
   * untuk foto yang masih kurang (foto = null) supaya ditandai di laporan.
   *
   * @return array<int, array{item: mixed, foto: mixed, nomor: int}>
   */
  protected function buildEvidenceEntries(array $groupedItems): array
  {
    $entries = [];

    foreach ($groupedItems as $group) {
      foreach ($group['items'] as $item) {
        foreach ($item->fotoBukti as $foto) {
          $entries[] = ['item' => $item, 'foto' => $foto, 'nomor' => (int) $foto->nomor_urut];
        }

        $kurang = $item->jumlah_foto_wajib - $item->fotoBukti->count();
        $nomor = (int) ($item->fotoBukti->max('nomor_urut') ?? 0);

        for ($i = 0; $i < $kurang; $i++) {
          $nomor++;
          $entries[] = ['item' => $item, 'foto' => null, 'nomor' => $nomor];
        }
      }
    }

    return $entries;
  }

  protected function fotoCaption($item, int $nomor): string
  {
    $kode = $item->katalogItem->kode_designator;

    if ($item->kategori_foto === 'representatif') {
      return $kode;
    }

    return $kode . ' (' . $nomor . ')';
  }

  protected function renderPdf(Proyek $proyek, array $groupedItems, array $evidenceEntries, string $tanggal, string $path): void
  {
    $pdf = Pdf::loadView('laporan.pdf', [
      'proyek' => $proyek,
      'groupedItems' => $groupedItems,
      'evidenceEntries' => $evidenceEntries,
      'tanggalUjiTerima' => $tanggal,
      'fotoCaption' => fn($item, $nomor) => $this->fotoCaption($item, $nomor),
    ])->setPaper('a4', 'portrait');

    Storage::disk('public')->put($path, $pdf->output());
  }

  /**
   * Baris pertama tabel yang berisi info proyek, diapit garis atas dan bawah.
   * Ditandai sebagai baris header tabel, jadi otomatis berulang di setiap halaman
   * tanpa memakai header halaman (header halaman dibiarkan kosong untuk kop/logo).
   */
  protected function addInfoRow($table, array $infoRows, int $totalWidth, int $span): void
  {
    $table->addRow(null, ['tblHeader' => true, 'cantSplit' => true]);

    $cell = $table->addCell($totalWidth, [
      'gridSpan' => $span,
      'borderTopSize' => 12,
      'borderTopColor' => '000000',
      'borderBottomSize' => 12,
      'borderBottomColor' => '000000',
    ]);

    $tight = ['spaceBefore' => 0, 'spaceAfter' => 0];

    // Jarak kecil di atas blok info supaya teks tidak menempel ke garis
    $cell->addText('', ['size' => 4], $tight);

    // Tabel kecil tanpa border: label, titik dua, dan nilai rata kiri dan sejajar
    $info = $cell->addTable(['layout' => Table::LAYOUT_FIXED]);

    foreach ($infoRows as [$label, $value]) {
      $info->addRow();
      $info->addCell(2000)->addText($label, ['size' => 9], $tight);
      $info->addCell(250)->addText(':', ['size' => 9], $tight);
      $info->addCell($totalWidth - 2250 - 200)->addText($value, ['size' => 9], $tight);
    }

    // Jarak kecil di bawah blok info supaya tidak menempel ke garis
    $cell->addText('', ['size' => 4], $tight);
  }

  protected function renderWord(Proyek $proyek, array $groupedItems, array $evidenceEntries, string $tanggal, string $path): void
  {
    $phpWord = new PhpWord();

    // Header dan footer halaman sengaja dikosongkan: ruang kop untuk logo yang
    // ditambahkan manual oleh karyawan. Info proyek ada di baris header tabel.
    $sectionStyle = [
      'marginLeft' => 720,
      'marginRight' => 720,
      'marginTop' => 1400,
      'marginBottom' => 1100,
      'headerHeight' => 400,
      'footerHeight' => 400,
    ];

    $infoRows = [
      ['PROYEK', $proyek->nama_proyek],
      ['KONTRAK', $proyek->no_kontrak ?: '-'],
      ['SURAT PESANAN', $proyek->no_surat_pesanan ?: '-'],
      ['WITEL', $proyek->witel ?: '-'],
      ['LOKASI', $proyek->lokasi ?: '-'],
      ['PELAKSANA', $proyek->pelaksana ?: '-'],
    ];

    // ===== Section 1: BOQ =====
    $section = $phpWord->addSection($sectionStyle);
    $section->addHeader()->addTextBreak(1);
    $section->addFooter()->addTextBreak(1);

    $section->addText('BILL OF QUANTITY (BOQ) HASIL UJI TERIMA', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);

    $colWidths = [550, 2250, 2450, 1000, 700, 1100, 1100, 1100];
    $totalWidth = array_sum($colWidths);
    $headers = ['NO', 'DESIGNATOR', 'URAIAN PEKERJAAN', 'SATUAN', 'DRM', 'AKTUAL', 'TAMBAH', 'KURANG'];
    $border = ['borderSize' => 6, 'borderColor' => '999999'];

    $boqTable = $section->addTable([
      'layout' => Table::LAYOUT_FIXED,
      'alignment' => Jc::CENTER,
    ]);

    // Baris 1: info proyek (berulang tiap halaman)
    $this->addInfoRow($boqTable, $infoRows, $totalWidth, count($colWidths));

    // Baris 2: judul kolom (berulang tiap halaman)
    $boqTable->addRow(null, ['tblHeader' => true, 'cantSplit' => true]);
    foreach ($headers as $i => $head) {
      $boqTable->addCell($colWidths[$i], $border + ['bgColor' => 'FFEB3B'])
        ->addText($head, ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
    }

    $no = 1;
    foreach ($groupedItems as $group) {
      $boqTable->addRow(null, ['cantSplit' => true]);
      $boqTable->addCell($totalWidth, $border + ['gridSpan' => count($colWidths), 'bgColor' => 'C0392B'])
        ->addText($group['label'] . ' - ' . $group['nama'], ['bold' => true, 'color' => 'FFFFFF']);

      foreach ($group['items'] as $item) {
        $boqTable->addRow(null, ['cantSplit' => true]);
        $values = [
          (string) $no,
          $item->katalogItem->kode_designator,
          $item->katalogItem->uraian_pekerjaan,
          $item->katalogItem->satuan,
          (string) $item->qty_drm,
          (string) $item->qty_rekon_aktual,
          $item->qty_tambah > 0 ? (string) $item->qty_tambah : '-',
          $item->qty_kurang > 0 ? (string) $item->qty_kurang : '-',
        ];
        foreach ($values as $i => $val) {
          $boqTable->addCell($colWidths[$i], $border)->addText($val, ['size' => 9]);
        }
        $no++;
      }
    }

    $section->addTextBreak(1);
    $section->addText(
      strtoupper($proyek->witel) . ', ' . Carbon::parse($tanggal)->translatedFormat('d F Y'),
      ['size' => 11],
      ['alignment' => Jc::END]
    );
    $section->addTextBreak(1);

    $sigTable = $section->addTable(['layout' => Table::LAYOUT_FIXED, 'alignment' => Jc::CENTER]);
    $sigTable->addRow(null, ['cantSplit' => true]);

    $left = $sigTable->addCell(4500);
    $left->addText('TIM UJI TERIMA', ['bold' => true], ['alignment' => Jc::CENTER]);
    $left->addText('PT. TELKOM INFRASTRUKTUR INDONESIA', [], ['alignment' => Jc::CENTER]);
    if ($proyek->ttd_tim_uji_terima && Storage::disk('public')->exists($proyek->ttd_tim_uji_terima)) {
      $left->addImage(
        storage_path('app/public/' . $proyek->ttd_tim_uji_terima),
        ['width' => 90, 'height' => 50, 'alignment' => Jc::CENTER]
      );
    } else {
      $left->addTextBreak(2);
    }
    $left->addText($proyek->nama_tim_uji_terima ?: '-', [], ['alignment' => Jc::CENTER]);
    $left->addText('NIK: ' . ($proyek->nik_tim_uji_terima ?: '-'), [], ['alignment' => Jc::CENTER]);

    $right = $sigTable->addCell(4500);
    $right->addText('PELAKSANA', ['bold' => true], ['alignment' => Jc::CENTER]);
    $right->addText($proyek->pelaksana ?: '-', [], ['alignment' => Jc::CENTER]);
    if ($proyek->ttd_pelaksana && Storage::disk('public')->exists($proyek->ttd_pelaksana)) {
      $right->addImage(
        storage_path('app/public/' . $proyek->ttd_pelaksana),
        ['width' => 90, 'height' => 50, 'alignment' => Jc::CENTER]
      );
    } else {
      $right->addTextBreak(2);
    }
    $right->addText($proyek->nama_pelaksana_ttd ?: '-', [], ['alignment' => Jc::CENTER]);
    $right->addText('NIK: ' . ($proyek->nik_pelaksana_ttd ?: '-'), [], ['alignment' => Jc::CENTER]);

    // ===== Section 2: Evidence (section baru = halaman baru) =====
    $section2 = $phpWord->addSection($sectionStyle);
    $section2->addHeader()->addTextBreak(1);
    $section2->addFooter()->addTextBreak(1);

    $section2->addText('EVIDENCE PEKERJAAN', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);

    $fotoWidth = 3400;
    $fotoBorder = ['borderSize' => 6, 'borderColor' => '333333'];

    $gridTable = $section2->addTable([
      'layout' => Table::LAYOUT_FIXED,
      'alignment' => Jc::CENTER,
    ]);

    // Baris 1: info proyek (berulang tiap halaman)
    $this->addInfoRow($gridTable, $infoRows, $fotoWidth * 3, 3);

    foreach (array_chunk($evidenceEntries, 3) as $row) {
      $gridTable->addRow(null, ['cantSplit' => true]);

      foreach ($row as $entry) {
        $cell = $gridTable->addCell($fotoWidth, $fotoBorder);

        if ($entry['foto'] === null) {
          // Slot foto yang belum diunggah: tandai jelas di laporan
          $cell->addTextBreak(2);
          $cell->addText(
            'FOTO BELUM LENGKAP',
            ['bold' => true, 'color' => 'C0392B', 'size' => 10],
            ['alignment' => Jc::CENTER]
          );
          $cell->addTextBreak(1);
        } else {
          $fullPath = storage_path('app/public/' . $entry['foto']->file_path);

          if (file_exists($fullPath)) {
            $cell->addImage($fullPath, ['width' => 140, 'height' => 100, 'alignment' => Jc::CENTER]);
          }
        }

        $cell->addText('STO: ' . $proyek->sto, ['size' => 8]);
        $cell->addText('LOKASI: ' . $proyek->lokasi, ['size' => 8]);
        $cell->addText('ITEM: ' . $this->fotoCaption($entry['item'], $entry['nomor']), ['size' => 8]);
        $cell->addText('MITRA: ' . $proyek->pelaksana, ['size' => 8]);
      }

      for ($i = count($row); $i < 3; $i++) {
        $gridTable->addCell($fotoWidth, $fotoBorder)->addText('');
      }
    }

    if (empty($evidenceEntries)) {
      $section2->addText('Belum ada foto evidence.', ['italic' => true], ['alignment' => Jc::CENTER]);
    }

    $fullWordPath = Storage::disk('public')->path($path);
    if (!is_dir(dirname($fullWordPath))) {
      mkdir(dirname($fullWordPath), 0777, true);
    }

    IOFactory::createWriter($phpWord, 'Word2007')->save($fullWordPath);
  }
}
