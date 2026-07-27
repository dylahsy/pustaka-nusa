@extends('layouts.perpus')

@section('content')

<div class="admin-page">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Data Buku</h2>
            <p>Kelola koleksi buku perpustakaan, nomor panggil, pengarang, penerbit, tahun, dan kategori DDC.</p>
        </div>
        <a href="{{ url('buku/create') }}" class="btn-add-admin">
            <i class="bi bi-plus-lg"></i>
            Tambah Buku
        </a>
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('buku') }}" method="GET" class="simpus-search-form">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari kode, judul, pengarang, penerbit, kategori...">
        <button type="submit"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ url('buku') }}"><i class="bi bi-x-lg"></i> Atur Ulang</a>
        @endif
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Buku</th>
                    <th>Nomor Panggil</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $key => $item)
                    <tr>
                        <td>{{ $buku->firstItem() + $key }}</td>
                        <td>{{ $item->kode_buku ?? '-' }}</td>
                        <td>{{ $item->nomor_panggil ?? '-' }}</td>
                        <td>{{ $item->judul_buku }}</td>
                        <td>{{ $item->pengarang ?? $item->nama_penulis }}</td>
                        <td>{{ $item->penerbit ?? '-' }}</td>
                        <td>{{ $item->tahun_terbit }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? $item->kategori_buku ?? '-' }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ url('buku/'.$item->id.'/edit') }}" class="action-btn" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ url('buku/'.$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data buku?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-row">Tidak ada data buku</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $buku->links() }}
    </div>
</div>

@endsection
