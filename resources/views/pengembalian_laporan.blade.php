@extends('layouts.perpus')

@include('partials.laporan_style')

@section('content')
<div class="report-shell">
  @include('partials.laporan_header', ['reportTitle' => 'Laporan Pengembalian Buku'])

  <table class="report-table">
    <thead>
      <tr>
        <th>No</th>
        <th>ID Kembali</th>
        <th>Nama Anggota</th>
        <th>Judul Buku</th>
        <th>Tanggal Kembali</th>
        <th>Denda</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($transaksi as $no => $item)
        <tr>
          <td class="text-center">{{ $no + 1 }}</td>
          <td>{{ 'KMB-' . str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $item->anggota->nama ?: 'Anggota tidak ditemukan (ID: '.$item->anggota_id.')' }}</td>
          <td>{{ $item->buku->judul_buku ?: 'Buku tidak ditemukan (ID: '.$item->buku_id.')' }}</td>
          <td>{{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d-m-Y') : '-' }}</td>
          <td>Rp {{ number_format($item->nominal_denda, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">Tidak ada data pengembalian</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('partials.laporan_footer')
</div>
@endsection
