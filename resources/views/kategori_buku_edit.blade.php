@extends('layouts.perpus')

@section('content')

<style>
body {
    background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)),
    url('{{ asset('templateperpus/img/latar1.png') }}') no-repeat center center fixed;
    background-size: cover;
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
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">{{ $judul }}</div>
                <form action="{{ url('kategori-buku/'.$kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kode_kategori" class="form-label">Kode Kategori</label>
                                    <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" value="{{ old('kode_kategori', $kategori->kode_kategori) }}" required>
                                    <span class="text-danger">{{ $errors->first('kode_kategori') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kode_klasifikasi" class="form-label">Kode Klasifikasi</label>
                                    <input type="text" class="form-control" id="kode_klasifikasi" name="kode_klasifikasi" value="{{ old('kode_klasifikasi', $kategori->kode_klasifikasi) }}" required>
                                    <span class="text-danger">{{ $errors->first('kode_klasifikasi') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                            <span class="text-danger">{{ $errors->first('nama_kategori') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required>{{ old('keterangan', $kategori->keterangan ?? $kategori->deskripsi) }}</textarea>
                            <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ url('kategori-buku') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
