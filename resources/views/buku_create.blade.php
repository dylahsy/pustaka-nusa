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
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card mt-5">
        <div class="card-header">{{ $judul }}</div>
        <form action="{{ url('buku') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="kode_buku" class="form-label">Kode Buku</label>
                  <input
                    type="text"
                    class="form-control"
                    id="kode_buku"
                    name="kode_buku"
                    value="{{ old('kode_buku', $kode_buku) }}"
                    required
                  >
                  <span class="text-danger">{{ $errors->first('kode_buku') }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="nomor_panggil" class="form-label">Nomor Panggil</label>
                  <input
                    type="text"
                    class="form-control"
                    id="nomor_panggil"
                    name="nomor_panggil"
                    value="{{ old('nomor_panggil', $nomor_panggil) }}"
                    placeholder="Otomatis setelah data disimpan"
                    readonly
                  >
                  <span class="text-danger">{{ $errors->first('nomor_panggil') }}</span>
                </div>
              </div>
            </div>

            <div class="form-group mb-3">
              <label for="judul_buku" class="form-label">Judul Buku</label>
              <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}" required>
              <span class="text-danger">{{ $errors->first('judul_buku') }}</span>
            </div>

            <div class="form-group mb-3">
              <label for="pengarang" class="form-label">Pengarang</label>
              <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ old('pengarang') }}" required>
              <span class="text-danger">{{ $errors->first('pengarang') }}</span>
            </div>

            <div class="form-group mb-3">
              <label for="penerbit" class="form-label">Penerbit</label>
              <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
              <span class="text-danger">{{ $errors->first('penerbit') }}</span>
            </div>

            <div class="form-group mb-3">
              <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
              <input
                type="text"
                inputmode="numeric"
                maxlength="4"
                class="form-control"
                id="tahun_terbit"
                name="tahun_terbit"
                value="{{ old('tahun_terbit') }}"
                required
              >
              <span class="text-danger">{{ $errors->first('tahun_terbit') }}</span>
            </div>

            <div class="form-group mb-3">
              <label for="kategori_buku_id" class="form-label">Kategori</label>
              <select class="form-select" name="kategori_buku_id" id="kategori_buku_id" required>
                <option selected disabled>- Pilih Kategori -</option>
                @foreach($kategori_bk as $a)
                  <option value="{{ $a->id }}" {{ old('kategori_buku_id') == $a->id ? 'selected' : '' }}>
                    {{ $a->nama_kategori }}
                  </option>
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('kategori_buku_id') }}</span>
            </div>

            <div class="form-group mb-3">
              <label for="cover_buku" class="form-label">Upload Cover Buku</label>
              <input type="file" class="form-control" id="cover_buku" name="cover_buku" accept="image/*" required>
              <span class="text-danger d-block">{{ $errors->first('cover_buku') }}</span>
            </div>

            <div class="form-group mb-3">
              <label for="sinopsis" class="form-label">Sinopsis</label>
              <textarea
                class="form-control"
                id="sinopsis"
                name="sinopsis"
                rows="4"
                placeholder="Tulis sinopsis singkat buku..."
                required
              >{{ old('sinopsis') }}</textarea>
              <span class="text-danger d-block">{{ $errors->first('sinopsis') }}</span>
            </div>
          </div>

          <div class="card-footer text-end">
            <a href="{{ url('buku') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
