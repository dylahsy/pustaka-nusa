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

.current-cover-preview {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 12px;
    padding: 12px;
    border: 1px solid rgba(37, 99, 235, 0.14);
    border-radius: 12px;
    background: #f8fbff;
}

.current-cover-image {
    width: 72px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
    flex: 0 0 auto;
    border: 1px solid rgba(15, 23, 42, 0.08);
    box-shadow: 0 8px 16px rgba(15, 23, 42, 0.08);
}

.current-cover-meta {
    display: grid;
    gap: 4px;
}

.current-cover-label {
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.current-cover-note {
    color: #475569;
    font-size: 13px;
    line-height: 1.5;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">{{ $judul }}</div>
                <form action="{{ url('buku/' . $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kode_buku" class="form-label">Kode Buku</label>
                                    <input type="text" class="form-control" id="kode_buku" name="kode_buku"
                                        value="{{ old('kode_buku', $buku->kode_buku) }}" required>
                                    <span class="text-danger">{{ $errors->first('kode_buku') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nomor_panggil" class="form-label">Nomor Panggil</label>
                                    <input type="text" class="form-control" id="nomor_panggil" name="nomor_panggil"
                                        value="{{ old('nomor_panggil', $buku->nomor_panggil) }}" readonly>
                                    <span class="text-danger">{{ $errors->first('nomor_panggil') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="judul_buku" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul_buku" name="judul_buku"
                                value="{{ old('judul_buku', $buku->judul_buku) }}" required>
                            <span class="text-danger">{{ $errors->first('judul_buku') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pengarang" class="form-label">Pengarang</label>
                            <input type="text" class="form-control" id="pengarang" name="pengarang"
                                value="{{ old('pengarang', $buku->pengarang ?? $buku->nama_penulis) }}" required>
                            <span class="text-danger">{{ $errors->first('pengarang') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit"
                                value="{{ old('penerbit', $buku->penerbit) }}" required>
                            <span class="text-danger">{{ $errors->first('penerbit') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="text" inputmode="numeric" maxlength="4" class="form-control" id="tahun_terbit"
                                name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
                            <span class="text-danger">{{ $errors->first('tahun_terbit') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kategori_buku_id" class="form-label">Kategori</label>
                            <select class="form-select" name="kategori_buku_id" id="kategori_buku_id" required>
                                <option disabled>- Pilih Kategori -</option>
                                @foreach($kategori_bk as $a)
                                <option value="{{ $a->id }}"
                                    {{ old('kategori_buku_id', $buku->kategori_buku_id) == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('kategori_buku_id') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cover_buku" class="form-label">Upload Cover Buku</label>
                            @php
                            $currentCoverPath = filled($buku->cover_buku)
                                ? (filter_var($buku->cover_buku, FILTER_VALIDATE_URL)
                                    ? $buku->cover_buku
                                    : (file_exists(public_path($buku->cover_buku)) ? asset($buku->cover_buku) : null))
                                : null;
                            @endphp

                            @if($currentCoverPath)
                            <div class="current-cover-preview">
                                <img src="{{ $currentCoverPath }}" alt="Cover {{ $buku->judul_buku }}"
                                    class="current-cover-image">
                                <div class="current-cover-meta">
                                    <span class="current-cover-label">Cover saat ini</span>
                                    <div class="current-cover-note">Pilih file baru kalau ingin mengganti cover. Kalau
                                        tidak, cover lama tetap dipakai.</div>
                                </div>
                            </div>
                            @endif

                            <input type="file" class="form-control" id="cover_buku" name="cover_buku" accept="image/*">
                            <span class="text-danger d-block">{{ $errors->first('cover_buku') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sinopsis" class="form-label">Sinopsis</label>
                            <textarea class="form-control" id="sinopsis" name="sinopsis" rows="4"
                                placeholder="Tulis sinopsis singkat buku..."
                                required>{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                            <span class="text-danger d-block">{{ $errors->first('sinopsis') }}</span>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ url('buku') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
