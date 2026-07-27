@extends('layouts.perpus')

@include('partials.laporan_style')

@section('content')
<div class="report-shell">
  @include('partials.laporan_header', ['reportTitle' => 'Laporan Data Denda'])

  <table class="report-table">
    <thead>
      <tr>
        <th>No</th>
        <th>ID Denda</th>
        <th>Nama Anggota</th>
        <th>Judul Buku</th>
        <th>Hari Terlambat</th>
        <th>Nominal</th>
        <th>Status Bayar</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($denda as $no => $item)
        <tr>
          <td class="text-center">{{ $no + 1 }}</td>
          <td>{{ 'DND-' . str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $item->transaksi->anggota->nama }}</td>
          <td>{{ $item->transaksi->buku->judul_buku }}</td>
          <td>{{ $item->transaksi->hari_terlambat }} hari</td>
          <td>Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}</td>
          <td>{{ $item->status }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center">Tidak ada data denda</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('partials.laporan_footer')
</div>
@endsection
