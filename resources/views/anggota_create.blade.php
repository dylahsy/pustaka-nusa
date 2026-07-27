@extends('layouts.perpus')

@section('content')

<style>
body {
    background: #f5f7fb;
    padding-top: 32px;
}

.form-card {
    background: #fff;
    border: 1px solid #d7e4f5;
    border-radius: 12px;
    box-shadow: 0 12px 28px rgba(31, 45, 61, .08);
}

.form-card .card-header {
    background: #fff;
    font-weight: 800;
    color: #17324d;
    border-bottom: 2px solid #b8cce6;
}

.form-note {
    color: #64748b;
    font-size: 12px;
}

.photo-file-control {
    position: relative;
    display: flex;
    align-items: stretch;
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: .375rem;
    overflow: hidden;
    background: #fff;
}

.photo-file-control:focus-within {
    border-color: #86b7fe;
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
}

.photo-file-control input {
    position: absolute;
    inset: 0;
    z-index: 2;
    width: 100%;
    opacity: 0;
    cursor: pointer;
}

.photo-file-button {
    display: flex;
    align-items: center;
    padding: .375rem .75rem;
    color: #212529;
    background: #e9ecef;
    border-right: 1px solid #ced4da;
    font-size: .875rem;
    white-space: nowrap;
}

.photo-file-name {
    display: flex;
    align-items: center;
    min-width: 0;
    padding: .375rem .75rem;
    color: #6c757d;
    font-size: .875rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card form-card">
                <div class="card-header">{{ $judul }}</div>

                <form action="{{ url('anggota') }}" method="POST" enctype="multipart/form-data" id="anggota-form">
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID Anggota (otomatis)</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ old('kode_anggota', $kode_anggota) }}" disabled>
                                <small class="form-note">Kode anggota dibuat otomatis oleh sistem dan tidak perlu diisi
                                    manual.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" value="{{ old('nis') }}"
                                    required>
                                <span class="text-danger">{{ $errors->first('nis') }}</span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" id="kelas" class="form-control"
                                    value="{{ old('kelas') }}" required>
                                <span class="text-danger">{{ $errors->first('kelas') }}</span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>- Pilih Jenis
                                        Kelamin -</option>
                                    @foreach($jenis_kelamin as $jk)
                                    <option value="{{ $jk }}" {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>
                                        {{ $jk }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}"
                                    required>
                                <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}"
                                    required>
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto Kartu</label>
                                <div class="photo-file-control">
                                    <input type="file" name="foto_kartu" id="foto_kartu"
                                        accept="image/png,image/jpeg,image/webp" required>
                                    <span class="photo-file-button">Pilih File</span>
                                    <span id="file-name" class="photo-file-name">Belum ada file dipilih</span>
                                </div>
                                <small class="form-note">Wajib diunggah. Format JPG, PNG, atau WEBP.</small>
                                <span class="text-danger">{{ $errors->first('foto_kartu') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end bg-white">
                        <a href="{{ url('anggota') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoKartu = document.getElementById('foto_kartu');
    const fileName = document.getElementById('file-name');
    fotoKartu.addEventListener('change', function() {
        fileName.textContent = this.files.length ? this.files[0].name : 'Belum ada file dipilih';
    });
});
</script>

@endsection
