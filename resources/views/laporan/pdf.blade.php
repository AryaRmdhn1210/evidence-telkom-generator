<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <style>
    /* Ruang kosong di atas (kop) dan bawah (footer) berlaku di SETIAP halaman */
    @page {
      margin: 100px 40px 80px 40px;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
      margin: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      display: table-header-group;
    }

    tr {
      page-break-inside: avoid;
    }

    .boq-table th,
    .boq-table td {
      border: 1px solid #999;
      padding: 4px 6px;
    }

    .boq-table th {
      background: #FFEB3B;
      color: #000;
    }

    /* Sel pembungkus info proyek di thead: tanpa border dan tanpa warna kuning */
    .boq-table th.head-cell,
    .evidence-table td.head-cell {
      background: none;
      border: none;
      padding: 0;
      text-align: left;
      font-weight: normal;
    }

    /* Info proyek: tanpa kotak, rata kiri, titik dua sejajar dan rapat dengan label */
    .info-table td,
    .boq-table .info-table td {
      border: none;
      padding: 2px 4px 2px 0;
      vertical-align: top;
      text-align: left;
    }

    .info-table td.lbl {
      width: 105px;
    }

    .info-table td.sep {
      width: 10px;
    }

    .divider {
      border: none;
      border-top: 2px solid #000;
      height: 0;
      margin: 0;
    }

    .divider-top {
      margin: 0 0 6px;
    }

    .divider-bottom {
      margin: 6px 0 12px;
    }

    .kategori-row td {
      background: #C0392B;
      color: #fff;
      font-weight: bold;
    }

    .signature-table {
      margin-top: 10px;
    }

    .signature-table td {
      width: 50%;
      text-align: center;
      vertical-align: top;
      padding: 20px 10px 0;
    }

    .evidence-table {
      table-layout: fixed;
    }

    .foto-cell {
      width: 33.33%;
      text-align: center;
      padding: 8px;
      vertical-align: top;
      border: 1px solid #333;
    }

    .foto-cell img {
      width: 100%;
      max-height: 150px;
      object-fit: cover;
      border: 1px solid #ccc;
    }

    .foto-kosong {
      height: 110px;
      line-height: 110px;
      text-align: center;
      font-size: 10px;
      font-weight: bold;
      color: #C0392B;
      background: #FDEDEC;
      border: 1px dashed #C0392B;
    }

    .caption-table {
      width: 100%;
      font-size: 9px;
      margin-top: 4px;
    }

    .caption-table td {
      border: 1px solid #999;
      padding: 2px 4px;
    }

    .page-break {
      page-break-before: always;
    }

    h1 {
      font-size: 16px;
      text-align: center;
      margin: 0 0 8px;
    }
  </style>
</head>

<body>

  <h1>BILL OF QUANTITY (BOQ) HASIL UJI TERIMA</h1>

  <table class="boq-table">
    <thead>
      <tr>
        <th colspan="8" class="head-cell">
          @include('laporan.partials.info')
        </th>
      </tr>
      <tr>
        <th>NO</th>
        <th>DESIGNATOR</th>
        <th>URAIAN PEKERJAAN</th>
        <th>SATUAN</th>
        <th>DRM</th>
        <th>AKTUAL</th>
        <th>TAMBAH</th>
        <th>KURANG</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @foreach ($groupedItems as $group)
      <tr class="kategori-row">
        <td colspan="8">{{ $group['label'] }} - {{ $group['nama'] }}</td>
      </tr>
      @foreach ($group['items'] as $item)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $item->katalogItem->kode_designator }}</td>
        <td>{{ $item->katalogItem->uraian_pekerjaan }}</td>
        <td>{{ $item->katalogItem->satuan }}</td>
        <td>{{ $item->qty_drm }}</td>
        <td>{{ $item->qty_rekon_aktual }}</td>
        <td>{{ $item->qty_tambah > 0 ? $item->qty_tambah : '-' }}</td>
        <td>{{ $item->qty_kurang > 0 ? $item->qty_kurang : '-' }}</td>
      </tr>
      @endforeach
      @endforeach
    </tbody>
  </table>

  <p style="text-align: right; margin-top: 20px;">
    {{ strtoupper($proyek->witel) }}, {{ \Carbon\Carbon::parse($tanggalUjiTerima)->translatedFormat('d F Y') }}
  </p>

  <table class="signature-table">
    <tr>
      <td>
        <strong>TIM UJI TERIMA</strong><br>
        PT. TELKOM INFRASTRUKTUR INDONESIA<br><br>
        @if ($proyek->ttd_tim_uji_terima)
        <img src="{{ storage_path('app/public/' . $proyek->ttd_tim_uji_terima) }}" style="height: 60px;"><br>
        @else
        <br><br><br>
        @endif
        {{ $proyek->nama_tim_uji_terima ?: '-' }}<br>
        NIK: {{ $proyek->nik_tim_uji_terima ?: '-' }}
      </td>
      <td>
        <strong>PELAKSANA</strong><br>
        {{ $proyek->pelaksana ?: '-' }}<br><br>
        @if ($proyek->ttd_pelaksana)
        <img src="{{ storage_path('app/public/' . $proyek->ttd_pelaksana) }}" style="height: 60px;"><br>
        @else
        <br><br><br>
        @endif
        {{ $proyek->nama_pelaksana_ttd ?: '-' }}<br>
        NIK: {{ $proyek->nik_pelaksana_ttd ?: '-' }}
      </td>
    </tr>
  </table>

  <div class="page-break"></div>

  <h1>EVIDENCE PEKERJAAN</h1>

  @php
  $chunks = array_chunk($evidenceEntries, 3);
  @endphp

  <table class="evidence-table">
    <thead>
      <tr>
        <td colspan="3" class="head-cell">
          @include('laporan.partials.info')
        </td>
      </tr>
    </thead>
    <tbody>
      @foreach ($chunks as $row)
      <tr>
        @foreach ($row as $entry)
        <td class="foto-cell">
          @if ($entry['foto'])
          <img src="{{ storage_path('app/public/' . $entry['foto']->file_path) }}">
          @else
          <div class="foto-kosong">FOTO BELUM LENGKAP</div>
          @endif
          <table class="caption-table">
            <tr>
              <td>STO</td>
              <td>{{ $proyek->sto }}</td>
            </tr>
            <tr>
              <td>LOKASI</td>
              <td>{{ $proyek->lokasi }}</td>
            </tr>
            <tr>
              <td>ITEM</td>
              <td>{{ $fotoCaption($entry['item'], $entry['nomor']) }}</td>
            </tr>
            <tr>
              <td>MITRA</td>
              <td>{{ $proyek->pelaksana }}</td>
            </tr>
          </table>
        </td>
        @endforeach
        @for ($i = count($row); $i < 3; $i++)
          <td class="foto-cell">
          </td>
          @endfor
      </tr>
      @endforeach
    </tbody>
  </table>

</body>

</html>