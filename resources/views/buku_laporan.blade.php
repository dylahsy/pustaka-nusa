@extends('layouts.perpus')

@include('partials.laporan_style')

@section('content')
<div class="report-shell">
  @include('partials.laporan_header', ['reportTitle' => 'Laporan Data Buku'])

  <table class="report-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Buku</th>
        <th>Judul Buku</th>
        <th>Kategori Buku</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($buku as $no => $a)
        <tr>
          <td class="text-center">{{ $no + 1 }}</td>
          <td>{{ $a->kode_buku ?? '-' }}</td>
          <td>{{ $a->judul_buku }}</td>
          <td>{{ $a->kategori->nama_kategori ?? $a->kategori_buku ?? '-' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center">Tidak ada data buku</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('partials.laporan_footer')
</div>
@endsection
