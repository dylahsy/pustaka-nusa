@extends('layouts.perpus')

@section('content')

<style>
body {
    background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
    url('{{ asset('templateperpus/img/latar1.png') }}') no-repeat center center fixed;
    background-size: cover;
    padding-top: 40px;
}

.card {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.card-header {
    background-color: #90b6e0;
    color: rgb(0, 0, 0);
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #679fd6;
    border-color: #5c97cb;
}

.tanggal-pinjam-field { position: relative; }
.tanggal-pinjam-field input[type="text"] { padding-right: 42px; }
.tanggal-pinjam-icon { position: absolute; top: 50%; right: 12px; transform: translateY(-50%); border: 0; background: transparent; color: #64748b; cursor: pointer; }
.tanggal-pinjam-picker { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
</style>


<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Tambah Data Transaksi
                </div>
                <div class="card-body">
                    <form action="{{ url('transaksi') }}" method="post">
                        @csrf

                        <!-- Tanggal Pinjam -->
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                            <div class="tanggal-pinjam-field">
                                <input id="tanggal_pinjam" class="form-control" type="text" name="tanggal_pinjam"
                                    value="{{ old('tanggal_pinjam', now()->format('d-m-Y')) }}" placeholder="dd-mm-yyyy" inputmode="numeric" maxlength="10" required>
                                <button type="button" class="tanggal-pinjam-icon" aria-label="Pilih tanggal pinjam"><i class="bi bi-calendar3" aria-hidden="true"></i></button>
                                <input type="date" class="tanggal-pinjam-picker" tabindex="-1" aria-hidden="true">
                            </div>
                            <span class="text-danger">{{ $errors->first('tanggal_pinjam') }}</span>
                        </div>

                        <!-- Anggota -->
                        <div class="form-group">
                            <label for="anggota_id">Anggota</label>
                            <select id="anggota_id" class="form-control" name="anggota_id" required>
                                <option value="">Pilih Anggota</option>
                                @foreach ($list_anggota as $id => $nama)
                                <option value="{{ $id }}" @selected($id==old('anggota_id'))>
                                    {{ $nama }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('anggota_id') }}</span>
                        </div>

                        <!-- Buku -->
                        <div class="form-group">
                            <label for="buku_id">Buku</label>
                            <select id="buku_id" class="form-control" name="buku_id" required>
                                <option value="">Pilih Buku</option>
                                @foreach ($list_buku as $id => $judul)
                                <option value="{{ $id }}" @selected($id==old('buku_id'))>
                                    {{ $judul }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('buku_id') }}</span>
                        </div>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ url('transaksi') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.tanggal-pinjam-field').forEach((field) => {
    const textInput = field.querySelector('input[name="tanggal_pinjam"]');
    const datePicker = field.querySelector('.tanggal-pinjam-picker');
    field.querySelector('.tanggal-pinjam-icon').addEventListener('click', () => {
        if (typeof datePicker.showPicker === 'function') datePicker.showPicker(); else datePicker.click();
    });
    datePicker.addEventListener('change', () => {
        if (!datePicker.value) return;
        const [year, month, day] = datePicker.value.split('-');
        textInput.value = `${day}-${month}-${year}`;
    });
});
</script>

@endsection
