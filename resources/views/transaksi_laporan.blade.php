@extends('layouts.perpus')

@include('partials.laporan_style')

@section('content')
<div class="report-shell">
  @include('partials.laporan_header', ['reportTitle' => 'Laporan Peminjaman Buku'])

  <table class="report-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Pinjam</th>
        <th>Nama Anggota</th>
        <th>Judul Buku</th>
        <th>Tanggal Pinjam</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($transaksi as $no => $a)
        <tr>
          <td class="text-center">{{ $no + 1 }}</td>
          <td>{{ $a->kode_pinjam }}</td>
          <td>{{ $a->anggota->nama }}</td>
          <td>{{ $a->buku->judul_buku }}</td>
          <td>{{ $a->tanggal_pinjam ? $a->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">Tidak ada data peminjaman</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('partials.laporan_footer')
</div>
@endsection
