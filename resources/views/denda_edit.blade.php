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
                <form action="{{ url('denda/'.$denda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="transaksi_id" class="form-label">Transaksi</label>
                            <select class="form-select" name="transaksi_id" id="transaksi_id" required>
                                @foreach($list_transaksi as $id => $tampil)
                                    <option value="{{ $id }}" {{ old('transaksi_id', $denda->transaksi_id) == $id ? 'selected' : '' }}>{{ $tampil }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('transaksi_id') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jumlah_denda" class="form-label">Jumlah Denda</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="jumlah_denda" name="jumlah_denda" value="{{ old('jumlah_denda', $denda->jumlah_denda) }}" required>
                            <span class="text-danger">{{ $errors->first('jumlah_denda') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required>{{ old('keterangan', $denda->keterangan) }}</textarea>
                            <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status Bayar</label>
                            <select class="form-select" name="status" id="status" required>
                                @foreach($status as $item)
                                    <option value="{{ $item }}" {{ old('status', $denda->status) == $item ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ url('denda') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
