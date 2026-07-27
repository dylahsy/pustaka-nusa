@extends('layouts.perpus')

@section('content')
@php
    $bulanTerpilih = $selectedBulan ?? now()->month;
    $tahunTerpilih = $selectedTahun ?? now()->year;
    $periodeQuery = http_build_query([
        'bulan' => $bulanTerpilih,
        'tahun' => $tahunTerpilih,
    ]);
@endphp
<div class="simpus-page">
    <div class="simpus-header">
        <div class="simpus-title">
            <h2>{{ $judul }}</h2>
            <p>Pilih bulan dan tahun laporan yang ingin dibuka. Setiap bulan tetap tersedia meski datanya belum ada.</p>
        </div>
    </div>

    <div class="simpus-card p-4 mb-4">
        <form action="{{ url('/laporan') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="bulan" class="form-label fw-semibold">Bulan</label>
                <select name="bulan" id="bulan" class="form-select">
                    @foreach($bulanOptions as $value => $label)
                        <option value="{{ $value }}" {{ (int) $bulanTerpilih === (int) $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="tahun" class="form-label fw-semibold">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    @foreach($tahunOptions as $tahun)
                        <option value="{{ $tahun }}" {{ (int) $tahunTerpilih === (int) $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan Periode</button>
            </div>
        </form>
        <div class="alert alert-info mt-3 mb-0 py-2 px-3">
            Periode aktif: <strong>{{ $periode }}</strong>
        </div>
    </div>

    <div class="simpus-card p-4">
        <div class="report-grid">
            <a href="{{ url('buku/laporan/cetak') }}?{{ $periodeQuery }}" class="laporan-link">
                <i class="bi bi-book"></i>
                Laporan Data Buku
            </a>
            <a href="{{ url('kategori-buku/laporan/cetak') }}?{{ $periodeQuery }}" class="laporan-link">
                <i class="bi bi-tags"></i>
                Laporan Data Kategori Buku
            </a>
            <a href="{{ url('anggota/laporan/cetak') }}?{{ $periodeQuery }}" class="laporan-link">
                <i class="bi bi-people"></i>
                Laporan Data Anggota
            </a>
            <a href="{{ url('transaksi/laporan/cetak') }}?{{ $periodeQuery }}" class="laporan-link">
                <i class="bi bi-arrow-left-right"></i>
                Laporan Peminjaman
            </a>
            <a href="{{ url('pengembalian/laporan/cetak') }}?{{ $periodeQuery }}" class="laporan-link">
                <i class="bi bi-box-arrow-in-left"></i>
                Laporan Pengembalian
            </a>
            <a href="{{ url('denda/laporan/cetak') }}?{{ $periodeQuery }}" class="laporan-link">
                <i class="bi bi-cash-coin"></i>
                Laporan Data Denda
            </a>
        </div>
    </div>
</div>

@endsection
