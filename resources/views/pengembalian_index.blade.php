@extends('layouts.perpus')

@section('content')

<style>
    .tanggal-kembali-field {
        position: relative;
        width: 160px;
    }

    .tanggal-kembali-field input {
        width: 100%;
        padding-right: 38px;
    }

    .tanggal-kembali-icon {
        position: absolute;
        top: 50%;
        right: 11px;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 16px;
        border: 0;
        padding: 0;
        background: transparent;
        cursor: pointer;
    }

    .tanggal-kembali-picker {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }
</style>

<div class="simpus-page">
    <div class="simpus-header">
        <div class="simpus-title">
            <h2>{{ $judul }}</h2>
            <p>Proses pengembalian buku yang masih dipinjam. Denda akan masuk otomatis kalau terlambat.</p>
        </div>
    </div>

    @if(session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    <form action="{{ url('pengembalian') }}" method="GET" class="simpus-search-form">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari kode pinjam, anggota, buku, tanggal pinjam...">
        <button type="submit"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ url('pengembalian') }}"><i class="bi bi-x-lg"></i> Atur Ulang</a>
        @endif
    </form>

    <div class="simpus-table-wrap">
        <table class="simpus-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pinjam</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $key => $row)
                    <tr>
                        <td>{{ $transaksi->firstItem() + $key }}</td>
                        <td>{{ $row->kode_pinjam }}</td>
                        <td>{{ $row->anggota->nama }}</td>
                        <td>{{ $row->buku->judul_buku }}</td>
                        <td>{{ $row->jatuh_tempo ? $row->jatuh_tempo->format('d-m-Y') : '-' }}</td>
                        <td>
                            <form action="{{ url('pengembalian/'.$row->id) }}" method="POST" class="d-flex gap-2 justify-content-center align-items-center flex-wrap">
                                @csrf
                                <div class="tanggal-kembali-field">
                                    <input type="text" name="tanggal_kembali" class="form-control form-control-sm" value="{{ old('tanggal_kembali') }}" placeholder="dd-mm-yyyy" inputmode="numeric" maxlength="10" required>
                                    <button type="button" class="tanggal-kembali-icon" aria-label="Pilih tanggal kembali">
                                        <i class="bi bi-calendar3" aria-hidden="true"></i>
                                    </button>
                                    <input type="date" class="tanggal-kembali-picker" tabindex="-1" aria-hidden="true">
                                </div>
                                <button type="submit" class="simpus-btn-primary">Kembalikan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">Tidak ada data pengembalian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $transaksi->links() }}
    </div>
</div>

<script>
    document.querySelectorAll('.tanggal-kembali-field').forEach((field) => {
        const textInput = field.querySelector('input[name="tanggal_kembali"]');
        const datePicker = field.querySelector('.tanggal-kembali-picker');
        const calendarButton = field.querySelector('.tanggal-kembali-icon');

        calendarButton.addEventListener('click', () => {
            if (typeof datePicker.showPicker === 'function') {
                datePicker.showPicker();
            } else {
                datePicker.click();
            }
        });

        datePicker.addEventListener('change', () => {
            if (!datePicker.value) return;
            const [year, month, day] = datePicker.value.split('-');
            textInput.value = `${day}-${month}-${year}`;
        });
    });
</script>

@endsection
