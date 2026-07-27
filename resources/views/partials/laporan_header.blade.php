@php
  $bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
  ];
  $periodeLaporan = $periode ?? $bulan[now()->month] . ' ' . now()->year;
@endphp

<div class="report-actions">
  <button type="button" class="report-btn print" onclick="window.print()">
    <i class="bi bi-printer"></i>
    Cetak
  </button>
  <a href="{{ url('/home') }}" class="report-btn back">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Menu Utama
  </a>
</div>

<div class="report-paper">
  <div class="report-kop">
    <img src="{{ asset('templateperpus/img/logo_sepucuk_jambi_transparent.png') }}" alt="Logo Sepucuk Jambi" class="report-logo report-logo-left">
    <div class="report-school">
      <h1>SMA Negeri 9 Kota Jambi</h1>
      <p class="report-school-subtitle">Perpustakaan Sekolah</p>
      <p class="report-school-address">Jl. Berdikari, RT 28, Kelurahan Payo Selincah, Kecamatan Paal Merah</p>
      <p class="report-school-contact">Kota Jambi, Provinsi Jambi 36148 | Telp. (0741) 573211</p>
    </div>
    <img src="{{ asset('templateperpus/img/logo_ungu_smanes_transparent.png') }}" alt="Logo SMA Negeri 9 Kota Jambi" class="report-logo report-logo-right">
  </div>

  <div class="report-title">
    <h2>{{ $reportTitle }}</h2>
    <p>Periode {{ $periodeLaporan }}</p>
  </div>
