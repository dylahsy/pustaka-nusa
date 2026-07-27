@extends('layouts.perpus')

@include('partials.laporan_style')

@section('content')
<div class="report-shell">
  @include('partials.laporan_header', ['reportTitle' => 'Laporan Data Anggota'])

  <table class="report-table">
    <thead>
      <tr>
        <th>No</th>
        <th>ID Anggota</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>No. Telepon</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($anggota as $i => $a)
        <tr>
          <td class="text-center">{{ $i + 1 }}</td>
          <td>{{ $a->kode_anggota }}</td>
          <td>{{ $a->nis ?? '-' }}</td>
          <td>{{ $a->nama }}</td>
          <td>{{ $a->kelas ?? '-' }}</td>
          <td>{{ $a->alamat ?? '-' }}</td>
          <td>{{ $a->no_hp ?? '-' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center">Tidak ada data anggota</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('partials.laporan_footer')
</div>
@endsection
