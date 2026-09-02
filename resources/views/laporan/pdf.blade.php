<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-table td {
      padding: 2px 6px;
      vertical-align: top;
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
      border-collapse: collapse;
      margin-bottom: 10px;
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

    .logo-spacer {
      height: 70px;
    }

    .footer-spacer {
      height: 70px;
    }

    .divider {
      border: none;
      border-top: 2px solid #000;
      margin: 8px 0 14px;
    }

    h1 {
      font-size: 16px;
      text-align: center;
      margin: 0 0 10px;
    }
  </style>
</head>

<body>

  <div class="logo-spacer"></div>

  <h1>BILL OF QUANTITY (BOQ) HASIL UJI TERIMA</h1>
  <hr class="divider">

  <table class="info-table">
    <tr>
      <td>PROYEK</td>
      <td>:</td>
      <td>{{ $proyek->nama_proyek }}</td>
    </tr>
    <tr>
      <td>KONTRAK</td>
      <td>:</td>
      <td>{{ $proyek->no_kontrak ?: '-' }}</td>
    </tr>
    <tr>
      <td>SURAT PESANAN</td>
      <td>:</td>
      <td>{{ $proyek->no_surat_pesanan ?: '-' }}</td>
    </tr>
    <tr>
      <td>WITEL</td>
      <td>:</td>
      <td>{{ $proyek->witel ?: '-' }}</td>
    </tr>
    <tr>
      <td>LOKASI</td>
      <td>:</td>
      <td>{{ $proyek->lokasi ?: '-' }}</td>
    </tr>
    <tr>
      <td>PELAKSANA</td>
      <td>:</td>
      <td>{{ $proyek->pelaksana ?: '-' }}</td>
    </tr>
  </table>

  <hr class="divider">

  <table class="boq-table">
    <thead>
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
        <td>{{ $item->itemPekerjaan->kode_designator }}</td>
        <td>{{ $item->itemPekerjaan->uraian_pekerjaan }}</td>
        <td>{{ $item->itemPekerjaan->satuan }}</td>
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

  <div class="footer-spacer"></div>

  <div class="page-break"></div>

  <div class="logo-spacer"></div>

  <h1>EVIDENCE PEKERJAAN</h1>
  <hr class="divider">

  <table class="info-table">
    <tr>
      <td>PROYEK</td>
      <td>:</td>
      <td>{{ $proyek->nama_proyek }}</td>
    </tr>
    <tr>
      <td>KONTRAK</td>
      <td>:</td>
      <td>{{ $proyek->no_kontrak ?: '-' }}</td>
    </tr>
    <tr>
      <td>SURAT PESANAN</td>
      <td>:</td>
      <td>{{ $proyek->no_surat_pesanan ?: '-' }}</td>
    </tr>
    <tr>
      <td>WITEL</td>
      <td>:</td>
      <td>{{ $proyek->witel ?: '-' }}</td>
    </tr>
    <tr>
      <td>LOKASI</td>
      <td>:</td>
      <td>{{ $proyek->lokasi ?: '-' }}</td>
    </tr>
    <tr>
      <td>PELAKSANA</td>
      <td>:</td>
      <td>{{ $proyek->pelaksana ?: '-' }}</td>
    </tr>
  </table>

  <hr class="divider">

  @php
  $allFotos = [];
  foreach ($groupedItems as $group) {
  foreach ($group['items'] as $item) {
  foreach ($item->fotoBukti as $foto) {
  $allFotos[] = ['item' => $item, 'foto' => $foto];
  }
  }
  }
  $chunks = array_chunk($allFotos, 3);
  @endphp

  @foreach ($chunks as $row)
  <table class="evidence-table">
    <tr>
      @foreach ($row as $entry)
      <td class="foto-cell">
        <img src="{{ storage_path('app/public/' . $entry['foto']->file_path) }}">
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
            <td>{{ $fotoCaption($entry['item'], $entry['foto']) }}</td>
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
  </table>
  @endforeach

</body>

</html>