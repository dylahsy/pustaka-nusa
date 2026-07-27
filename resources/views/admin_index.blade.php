@extends('layouts.perpus')

@section('content')

<div class="admin-page">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Data Admin</h2>
            <p>Kelola administrator sistem perpustakaan, akses akun, dan data pengguna. Mode edit, tambah, dan hapus hanya untuk Kepala Perpustakaan.</p>
        </div>
        @if($canManageAdmin)
            <a href="{{ url('admin/create') }}" class="btn-add-admin">
                <i class="bi bi-plus-lg"></i>
                Tambah Admin
            </a>
        @endif
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('admin') }}" method="GET" class="simpus-search-form">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari nama, email, no.hp...">
        <button type="submit"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ url('admin') }}"><i class="bi bi-x-lg"></i> Atur Ulang</a>
        @endif
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Admin</th>
                    <th>Nama Admin</th>
                    <th>Email</th>
                    <th>No.HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admin as $key => $item)
                    <tr class="{{ auth()->id() == $item->id ? 'current-admin-row' : '' }}">
                        <td>{{ $admin->firstItem() + $key }}</td>
                        <td>ADM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            {{ $item->name }}
                            @if(auth()->id() == $item->id)
                                <span class="current-badge">Anda</span>
                            @endif
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td>
                            @if($canManageAdmin && $item->role === 'Admin')
                                <div class="action-group">
                                    <a href="{{ url('admin/'.$item->id.'/edit') }}" class="action-btn" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if(auth()->id() == $item->id)
                                        <button type="button" class="action-btn disabled" title="Akun yang sedang digunakan tidak bisa dihapus" disabled>
                                            <i class="bi bi-shield-lock"></i>
                                        </button>
                                    @else
                                        <form action="{{ url('admin/'.$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data admin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted fw-semibold">
                                    {{ $item->role === 'Kepala Perpustakaan' ? 'Akun sistem' : 'Lihat saja' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">Tidak ada data admin</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $admin->links() }}
    </div>
</div>

@endsection
