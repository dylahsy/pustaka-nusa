@extends('layouts.perpus')

@section('content')

<div class="simpus-page">
    <div class="simpus-header">
        <div class="simpus-title">
            <h2>{{ $judul }}</h2>
            <p>Denda dibuat otomatis dari pengembalian buku yang terlambat. Status pembayaran bisa difilter berdasarkan sudah lunas atau belum.</p>
        </div>
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('denda') }}" method="GET" class="simpus-search-form simpus-search-form-inline">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari ID denda, anggota, buku, nominal...">
        <select name="status" id="status-denda" class="simpus-select-arrow" aria-label="Status Denda">
            <option value="">Semua Status Denda</option>
            <option value="Belum Dibayar" {{ request('status') === 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
            <option value="Dibayar" {{ request('status') === 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
        </select>
        <button type="submit"><i class="bi bi-search"></i> Cari</button>
        @if(request('search') || request('status'))
            <a href="{{ url('denda') }}"><i class="bi bi-x-lg"></i> Atur Ulang</a>
        @endif
    </form>

    <div class="simpus-table-wrap">
        <table class="simpus-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Denda</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Hari Terlambat</th>
                    <th>Total Denda</th>
                    <th>Status Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($denda as $key => $item)
                    <tr>
                        <td>{{ $denda->firstItem() + $key }}</td>
                        <td>{{ 'DND-' . str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $item->transaksi->anggota->nama }}</td>
                        <td>{{ $item->transaksi->buku->judul_buku }}</td>
                        <td>{{ $item->transaksi->hari_terlambat }} hari</td>
                        <td>Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'Dibayar')
                                <span class="status-badge status-active">Dibayar</span>
                            @else
                                <span class="status-badge status-warning">Belum Dibayar</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ url('denda/'.$item->id.'/edit') }}" class="action-btn" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ url('denda/'.$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')">
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
                        <td colspan="8" class="empty-row">Tidak ada data denda</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $denda->links() }}
    </div>
</div>

@endsection
