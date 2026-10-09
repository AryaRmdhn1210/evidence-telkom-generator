<hr class="divider divider-top">
<table class="info-table">
  <tr>
    <td class="lbl">PROYEK</td>
    <td class="sep">:</td>
    <td>{{ $proyek->nama_proyek }}</td>
  </tr>
  <tr>
    <td class="lbl">KONTRAK</td>
    <td class="sep">:</td>
    <td>{{ $proyek->no_kontrak ?: '-' }}</td>
  </tr>
  <tr>
    <td class="lbl">SURAT PESANAN</td>
    <td class="sep">:</td>
    <td>{{ $proyek->no_surat_pesanan ?: '-' }}</td>
  </tr>
  <tr>
    <td class="lbl">WITEL</td>
    <td class="sep">:</td>
    <td>{{ $proyek->witel ?: '-' }}</td>
  </tr>
  <tr>
    <td class="lbl">LOKASI</td>
    <td class="sep">:</td>
    <td>{{ $proyek->lokasi ?: '-' }}</td>
  </tr>
  <tr>
    <td class="lbl">PELAKSANA</td>
    <td class="sep">:</td>
    <td>{{ $proyek->pelaksana ?: '-' }}</td>
  </tr>
</table>
<hr class="divider divider-bottom">