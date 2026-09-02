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
      'itemProyek.itemPekerjaan',
      'itemProyek.fotoBukti' => fn($q) => $q->orderBy('nomor_urut'),
    ]);

    $groupedItems = $this->groupItemsByKategori($proyek->itemProyek);

    $folder = 'laporan/' . $proyek->id;
    Storage::disk('public')->makeDirectory($folder);

    $filenameBase = 'BAUT_' . str($proyek->nama_proyek)->slug() . '_' . now()->format('YmdHis');
    $pdfPath = $folder . '/' . $filenameBase . '.pdf';
    $wordPath = $folder . '/' . $filenameBase . '.docx';

    $this->renderPdf($proyek, $groupedItems, $tanggalUjiTerima, $pdfPath);
    $this->renderWord($proyek, $groupedItems, $tanggalUjiTerima, $wordPath);

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
      $kategori = $item->itemPekerjaan->kategori_pekerjaan ?: 'LAIN-LAIN';

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

  protected function fotoCaption($item, $foto): string
  {
    $kode = $item->itemPekerjaan->kode_designator;

    if ($item->kategori_foto === 'representatif') {
      return $kode;
    }

    return $kode . ' (' . $foto->nomor_urut . ')';
  }

  protected function renderPdf(Proyek $proyek, array $groupedItems, string $tanggal, string $path): void
  {
    $pdf = Pdf::loadView('laporan.pdf', [
      'proyek' => $proyek,
      'groupedItems' => $groupedItems,
      'tanggalUjiTerima' => $tanggal,
      'fotoCaption' => fn($item, $foto) => $this->fotoCaption($item, $foto),
    ])->setPaper('a4', 'portrait');

    Storage::disk('public')->put($path, $pdf->output());
  }

  protected function addDivider($section): void
  {
    $section->addLine([
      'weight' => 2,
      'width' => 460,
      'height' => 0,
      'color' => '000000',
    ]);
  }

  protected function renderWord(Proyek $proyek, array $groupedItems, string $tanggal, string $path): void
  {
    $phpWord = new PhpWord();
    $section = $phpWord->addSection([
      'marginLeft' => 720,
      'marginRight' => 720,
      'marginTop' => 600,
      'marginBottom' => 600,
    ]);

    $infoRows = [
      ['PROYEK', $proyek->nama_proyek],
      ['KONTRAK', $proyek->no_kontrak ?: '-'],
      ['SURAT PESANAN', $proyek->no_surat_pesanan ?: '-'],
      ['WITEL', $proyek->witel ?: '-'],
      ['LOKASI', $proyek->lokasi ?: '-'],
      ['PELAKSANA', $proyek->pelaksana ?: '-'],
    ];

    // Ruang kosong di atas untuk logo (dipersempit supaya semua konten muat 1 halaman)
    $section->addTextBreak(2);

    $section->addText('BILL OF QUANTITY (BOQ) HASIL UJI TERIMA', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);
    $this->addDivider($section);

    $infoTable = $section->addTable(['alignment' => Jc::CENTER]);
    foreach ($infoRows as [$label, $value]) {
      $infoTable->addRow();
      $infoTable->addCell(2200)->addText($label);
      $infoTable->addCell(400)->addText(':');
      $infoTable->addCell(6400)->addText($value);
    }

    $this->addDivider($section);

    $colWidths = [600, 1300, 3200, 800, 800, 800, 800, 700];
    $headers = ['NO', 'DESIGNATOR', 'URAIAN PEKERJAAN', 'SATUAN', 'DRM', 'AKTUAL', 'TAMBAH', 'KURANG'];

    $boqTable = $section->addTable([
      'borderSize' => 6,
      'borderColor' => '999999',
      'layout' => Table::LAYOUT_FIXED,
      'alignment' => Jc::CENTER,
    ]);

    $boqTable->addRow();
    foreach ($headers as $i => $head) {
      $boqTable->addCell($colWidths[$i], ['bgColor' => 'FFEB3B'])
        ->addText($head, ['bold' => true], ['alignment' => Jc::CENTER]);
    }

    $no = 1;
    foreach ($groupedItems as $group) {
      $boqTable->addRow();
      $boqTable->addCell(array_sum($colWidths), ['gridSpan' => 8, 'bgColor' => 'C0392B'])
        ->addText($group['label'] . ' - ' . $group['nama'], ['bold' => true, 'color' => 'FFFFFF']);

      foreach ($group['items'] as $item) {
        $boqTable->addRow();
        $values = [
          (string) $no,
          $item->itemPekerjaan->kode_designator,
          $item->itemPekerjaan->uraian_pekerjaan,
          $item->itemPekerjaan->satuan,
          (string) $item->qty_drm,
          (string) $item->qty_rekon_aktual,
          $item->qty_tambah > 0 ? (string) $item->qty_tambah : '-',
          $item->qty_kurang > 0 ? (string) $item->qty_kurang : '-',
        ];
        foreach ($values as $i => $val) {
          $boqTable->addCell($colWidths[$i])->addText($val);
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
    $sigTable->addRow();

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

    // Halaman Evidence
    $section->addPageBreak();
    $section->addTextBreak(2);
    $section->addText('EVIDENCE PEKERJAAN', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);
    $this->addDivider($section);

    $infoTable2 = $section->addTable(['alignment' => Jc::CENTER]);
    foreach ($infoRows as [$label, $value]) {
      $infoTable2->addRow();
      $infoTable2->addCell(2200)->addText($label);
      $infoTable2->addCell(400)->addText(':');
      $infoTable2->addCell(6400)->addText($value);
    }

    $this->addDivider($section);

    $allFotos = [];
    foreach ($groupedItems as $group) {
      foreach ($group['items'] as $item) {
        foreach ($item->fotoBukti as $foto) {
          $allFotos[] = ['item' => $item, 'foto' => $foto];
        }
      }
    }

    foreach (array_chunk($allFotos, 3) as $row) {
      $gridTable = $section->addTable([
        'borderSize' => 6,
        'borderColor' => '333333',
        'layout' => Table::LAYOUT_FIXED,
        'alignment' => Jc::CENTER,
      ]);
      $gridTable->addRow();

      foreach ($row as $entry) {
        $cell = $gridTable->addCell(3000);
        $fullPath = storage_path('app/public/' . $entry['foto']->file_path);

        if (file_exists($fullPath)) {
          $cell->addImage($fullPath, ['width' => 140, 'height' => 100, 'alignment' => Jc::CENTER]);
        }

        $cell->addText('STO: ' . $proyek->sto, ['size' => 8]);
        $cell->addText('LOKASI: ' . $proyek->lokasi, ['size' => 8]);
        $cell->addText('ITEM: ' . $this->fotoCaption($entry['item'], $entry['foto']), ['size' => 8]);
        $cell->addText('MITRA: ' . $proyek->pelaksana, ['size' => 8]);
      }

      for ($i = count($row); $i < 3; $i++) {
        $gridTable->addCell(3000)->addText('');
      }
    }

    $fullWordPath = Storage::disk('public')->path($path);
    if (!is_dir(dirname($fullWordPath))) {
      mkdir(dirname($fullWordPath), 0777, true);
    }

    IOFactory::createWriter($phpWord, 'Word2007')->save($fullWordPath);
  }
}
