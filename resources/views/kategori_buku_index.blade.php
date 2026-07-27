@extends('layouts.perpus')

@section('content')

<div class="admin-page">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Data Kategori Buku</h2>
            <p>Kelola kode kategori, klasifikasi, nama kategori, dan keterangan koleksi buku perpustakaan SMA.</p>
        </div>
        <a href="{{ url('kategori-buku/create') }}" class="btn-add-admin">
            <i class="bi bi-plus-lg"></i>
            Tambah Kategori
        </a>
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('kategori-buku') }}" method="GET" class="simpus-search-form">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari kode, klasifikasi, nama kategori...">
        <button type="submit"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ url('kategori-buku') }}"><i class="bi bi-x-lg"></i> Atur Ulang</a>
        @endif
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Kategori</th>
                    <th>Kode Klasifikasi</th>
                    <th>Nama Kategori</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori_buku as $key => $item)
                    <tr>
                        <td>{{ $kategori_buku->firstItem() + $key }}</td>
                        <td>{{ $item->kode_kategori ?? '-' }}</td>
                        <td>{{ $item->kode_klasifikasi ?? '-' }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>{{ $item->keterangan ?? $item->deskripsi ?? '-' }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ url('kategori-buku/'.$item->id.'/edit') }}" class="action-btn" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ url('kategori-buku/'.$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data kategori buku?')">
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
                        <td colspan="6" class="empty-row">Tidak ada data kategori buku</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $kategori_buku->links() }}
    </div>
</div>

@endsection
