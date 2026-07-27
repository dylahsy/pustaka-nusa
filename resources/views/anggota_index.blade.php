@extends('layouts.perpus')

@section('content')

<div class="data-page">
    <div class="data-header">
        <div class="data-title">
            <h2>Data Anggota</h2>
            <p>Kelola data siswa yang terdaftar sebagai anggota perpustakaan.</p>
        </div>
        <div class="header-actions">
            <a href="{{ url('anggota/create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i>
                Tambah Anggota
            </a>
        </div>
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('anggota') }}" method="GET" class="simpus-search-form">
        <input type="text" name="search" class="form-control" value="{{ $search ?? request('search') }}" placeholder="Cari ID, NIS, nama, kelas, no. HP...">
        <button type="submit">
            <i class="bi bi-search"></i>
            Cari
        </button>
        @if(request('search'))
            <a href="{{ url('anggota') }}">
                <i class="bi bi-x-lg"></i>
                Atur Ulang
            </a>
        @endif
    </form>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Anggota</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $key => $item)
                    <tr>
                        <td>{{ $anggota->firstItem() + $key }}</td>
                        <td>{{ $item->kode_anggota }}</td>
                        <td>{{ $item->nis ?? '-' }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kelas ?? '-' }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ url('anggota/'.$item->id.'/kartu') }}" class="action-btn" title="Cetak Kartu">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                                <a href="{{ url('anggota/'.$item->id.'/edit') }}" class="action-btn" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ url('anggota/'.$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data anggota?')">
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
                        <td colspan="8">Tidak ada data anggota</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $anggota->links() }}</div>
</div>

@endsection
