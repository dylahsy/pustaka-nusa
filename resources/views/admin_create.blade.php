@extends('layouts.perpus')

@section('content')

<style>
body {
    background: #f5f6f8;
    padding-top: 40px;
}

.card {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.card-header {
    background: #fff;
    color: #000;
    font-weight: bold;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">{{ $judul }}</div>
                <form action="{{ url('admin') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama Admin</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                required>
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                required>
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_hp" class="form-label">No.HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                required>
                            <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ url('admin') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
