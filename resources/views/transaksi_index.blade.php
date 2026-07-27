@extends('layouts.perpus')

@section('content')

<div class="simpus-page">
    <div class="simpus-header">
        <div class="simpus-title">
            <h2>{{ $judul }}</h2>
            <p>Kelola peminjaman buku yang masih aktif. Pengembalian dicatat di menu pengembalian.</p>
        </div>
        <a href="{{ url('transaksi/create') }}" class="simpus-btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Transaksi
        </a>
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('transaksi') }}" method="GET" class="simpus-search-form">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari kode pinjam, anggota, buku, tanggal...">
        <button type="submit"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ url('transaksi') }}"><i class="bi bi-x-lg"></i> Atur Ulang</a>
        @endif
    </form>

    <div class="simpus-table-wrap">
        <table class="simpus-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>ID Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $key => $row)
                    <tr>
                        <td>{{ $transaksi->firstItem() + $key }}</td>
                        <td>{{ $row->kode_pinjam }}</td>
                        <td>{{ $row->tanggal_pinjam ? $row->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                        <td>{{ $row->jatuh_tempo ? $row->jatuh_tempo->format('d-m-Y') : '-' }}</td>
                        <td>{{ $row->anggota->kode_anggota ?? $row->anggota_id }}</td>
                        <td>{{ $row->anggota->nama }}</td>
                        <td>{{ $row->buku->kode_buku ?? '-' }}</td>
                        <td>{{ $row->buku->judul_buku }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ url('transaksi/'.$row->id.'/edit') }}" class="action-btn" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ url('transaksi/'.$row->id) }}" method="POST" onsubmit="return confirm('Apakah ingin menghapus data ini?')">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="action-btn delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-row">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $transaksi->links() }}
    </div>
</div>
@endsection
