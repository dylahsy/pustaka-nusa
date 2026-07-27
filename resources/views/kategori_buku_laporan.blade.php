@extends('layouts.perpus')

@include('partials.laporan_style')

@section('content')
<div class="report-shell">
  @include('partials.laporan_header', ['reportTitle' => 'Laporan Data Kategori Buku'])

  <table class="report-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Kategori</th>
        <th>Kode Klasifikasi</th>
        <th>Nama Kategori</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($kategori_buku as $no => $item)
        <tr>
          <td class="text-center">{{ $no + 1 }}</td>
          <td>{{ $item->kode_kategori ?? '-' }}</td>
          <td>{{ $item->kode_klasifikasi ?? '-' }}</td>
          <td>{{ $item->nama_kategori }}</td>
          <td>{{ $item->keterangan ?? $item->deskripsi ?? '-' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">Tidak ada data kategori buku</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('partials.laporan_footer')
</div>
@endsection
