@extends('layouts.perpus')

@section('content')
@php
    $searchValue = $search ?? request('search');
    $selectedKategori = $selectedKategori ?? request('kategori');
    $kategoriList = $kategoriList ?? collect();
    $selectedKategoriLabel = $selectedKategoriLabel ?? ($selectedKategori ? $kategoriList->firstWhere('id', (int) $selectedKategori)?->nama_kategori : null);
    $resultCount = $buku->count();
    $totalCount = $buku->total();
@endphp

<style>
  .catalog-page {
    padding: 24px 24px 28px;
    font-family: "Poppins", "Roboto", sans-serif;
  }

  .catalog-shell {
    display: grid;
    gap: 14px;
  }

  .catalog-hero {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    padding: 18px 20px;
    border-radius: 20px;
    background:
      radial-gradient(circle at 92% 12%, rgba(255, 255, 255, 0.12) 0, transparent 18%),
      linear-gradient(135deg, #0f172a 0%, #1d4ed8 48%, #0f766e 100%);
    color: #fff;
    box-shadow: 0 20px 42px rgba(31, 75, 112, 0.18);
  }

  .catalog-copy {
    flex: 1 1 auto;
    min-width: 0;
  }

  .catalog-kicker {
    display: inline-flex;
    align-items: center;
    min-height: 26px;
    padding: 0 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    color: rgba(255, 255, 255, 0.92);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .catalog-copy h2 {
    margin: 10px 0 0;
    color: #fff;
    font-family: "Raleway", "Poppins", sans-serif;
    font-size: clamp(1.5rem, 2.5vw, 2.3rem);
    line-height: 1.12;
    font-weight: 900;
    letter-spacing: -0.05em;
  }

  .catalog-copy p {
    max-width: 62ch;
    margin: 10px 0 0;
    color: rgba(255, 255, 255, 0.84);
    font-size: 14px;
    line-height: 1.65;
  }

  .catalog-search {
    display: flex;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 16px;
  }

  .catalog-search input,
  .catalog-search select {
    flex: 1 1 220px;
    min-height: 46px;
    padding: 0 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.96);
    color: #17324d;
    font-size: 15px;
    outline: none;
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
  }

  .catalog-search .searchable-select {
    flex: 1 1 220px;
    min-width: 0;
  }

  /* Samakan dropdown kategori dengan form Tambah Data Buku. */
  .catalog-search .searchable-select-input {
    min-height: 44px !important;
    padding: 9px 13px !important;
    border: 1px solid #cbd9e8 !important;
    border-radius: 9px !important;
    background-color: #fff !important;
    color: #26384d !important;
    box-shadow: none !important;
  }

  .catalog-search .searchable-select-input:focus {
    border-color: #54a9e8 !important;
    box-shadow: 0 0 0 3px rgba(84, 169, 232, .16) !important;
  }

  .catalog-search select {
    appearance: none;
    background-image: linear-gradient(45deg, transparent 50%, #94a3b8 50%), linear-gradient(135deg, #94a3b8 50%, transparent 50%);
    background-position: calc(100% - 18px) calc(50% - 3px), calc(100% - 12px) calc(50% - 3px);
    background-size: 6px 6px, 6px 6px;
    background-repeat: no-repeat;
    padding-right: 38px;
  }

  .catalog-search input:focus,
  .catalog-search select:focus {
    border-color: rgba(255, 255, 255, 0.7);
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.12);
  }

  .catalog-search button,
  .catalog-search .reset-link {
    min-height: 46px;
    padding: 0 18px;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
  }

  .catalog-search button {
    border: 0;
    background: linear-gradient(135deg, #ffb347 0%, #ff8c1a 55%, #e86c00 100%) !important;
    color: #fff !important;
    box-shadow: 0 16px 26px rgba(232, 108, 0, 0.32) !important;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.12);
  }

  .catalog-search button:hover {
    transform: translateY(-1px);
    filter: brightness(1.06);
  }

  .catalog-search .reset-link {
    border: 1px solid rgba(255, 255, 255, 0.22);
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(8px);
  }

  .catalog-search .reset-link:hover {
    border-color: rgba(255, 255, 255, 0.34);
    color: #fff;
  }

  .catalog-summary {
    flex: 0 0 190px;
    padding: 14px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.16);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
  }

  .catalog-summary span {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .catalog-summary strong {
    display: block;
    margin-top: 6px;
    color: #fff;
    font-family: "Raleway", "Poppins", sans-serif;
    font-size: 30px;
    font-weight: 900;
    line-height: 1;
  }

  .catalog-summary p {
    margin: 8px 0 0;
    color: rgba(255, 255, 255, 0.84);
    font-size: 12px;
    line-height: 1.5;
  }

  .catalog-panel {
    position: relative;
    z-index: 1;
    background: #fff;
    border: 1px solid #d8e4f2;
    border-radius: 22px;
    box-shadow: 0 16px 36px rgba(31, 75, 112, 0.08);
    padding: 0;
    overflow: hidden;
  }

  .catalog-panel-head {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 18px;
    min-height: 72px;
    padding: 14px 18px;
    border-bottom: 1px solid #e8eef5;
    background: linear-gradient(180deg, #fbfdff, #f7fbff);
    position: relative;
  }

  .catalog-panel-title {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    pointer-events: none;
  }

  .catalog-panel-title h3 {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 8px 18px;
    border-radius: 999px;
    color: #1d3b86;
    font-family: "Raleway", "Poppins", sans-serif;
    font-size: 16px;
    font-weight: 900;
    line-height: 1;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    -webkit-text-stroke: 0.25px #1d3b86;
    text-shadow: 0 0 0.35px #1d3b86;
    background: linear-gradient(180deg, #ffffff, #eef5ff);
    border: 1px solid #d8e6fb;
    box-shadow: 0 10px 22px rgba(31, 75, 112, 0.08);
  }

  .catalog-panel-meta {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 8px;
    align-items: flex-start;
  }

  .catalog-meta-chip {
    display: inline-flex;
    align-items: center;
    min-height: 34px;
    padding: 0 12px;
    border-radius: 999px;
    background: #eff6ff;
    border: 1px solid #cfe0ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 800;
    white-space: nowrap;
  }

  .catalog-toolbar {
    padding: 14px 20px 18px;
    border-bottom: 1px solid #edf2f7;
    background: linear-gradient(180deg, #ffffff, #f9fbff);
  }

  .catalog-filter-form {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 12px;
  }

  .catalog-filter-field {
    flex: 1 1 280px;
    display: grid;
    gap: 6px;
  }

  .catalog-filter-field label {
    color: #17324d;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .catalog-filter-field select {
    min-height: 48px;
    padding: 0 14px;
    border: 1px solid #d9e3ef;
    border-radius: 14px;
    background: #fff;
    color: #17324d;
    font-size: 14px;
    outline: none;
  }

  .catalog-filter-field select:focus {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.08);
  }

  .catalog-clear {
    min-height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 14px;
    border-radius: 14px;
    border: 1px solid #d9e3ef;
    background: #fff;
    color: #334155;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
  }

  .catalog-clear:hover {
    background: #f8fbff;
  }

  .catalog-filter-note {
    margin-top: 10px;
    color: rgba(255, 255, 255, 0.72);
    font-size: 12px;
    line-height: 1.6;
  }

  .catalog-table-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: visible;
    overscroll-behavior-x: contain;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: auto;
    scrollbar-color: #7da7d8 #eaf2fb;
  }

  .catalog-table-wrap::-webkit-scrollbar {
    height: 14px;
  }

  .catalog-table-wrap::-webkit-scrollbar-track {
    background: #eaf2fb;
    border-top: 1px solid #d5e4f4;
  }

  .catalog-table-wrap::-webkit-scrollbar-thumb {
    border: 3px solid #eaf2fb;
    border-radius: 999px;
    background: #7da7d8;
  }

  .catalog-table {
    width: 100%;
    min-width: 1240px;
    margin: 0;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
  }

  .catalog-col-title { width: 24%; }
  .catalog-col-author { width: 15%; }
  .catalog-col-publisher { width: 15%; }
  .catalog-col-year { width: 12%; }
  .catalog-col-synopsis { width: 34%; }

  .catalog-table thead th {
    padding: 14px 14px;
    background: linear-gradient(180deg, #edf6ff, #dcecff);
    color: #17324d;
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 2px solid #a8c8ea;
    border-right: 1px solid #d7e7f7;
    text-align: center;
  }

  .catalog-table tbody td {
    padding: 15px 14px;
    vertical-align: middle;
    border-bottom: 1px solid #e6eef6;
    border-right: 1px solid #dce9f6;
    color: #26384d;
    font-size: 13.5px;
    line-height: 1.6;
    text-align: center;
    overflow-wrap: anywhere;
    word-break: normal;
  }

  .catalog-table tbody tr:nth-child(even) {
    background: #f8fbff;
  }

  .catalog-table tbody tr:hover {
    background: #eef6ff;
  }

  .catalog-table thead th:last-child,
  .catalog-table tbody td:last-child {
    border-right: none;
  }

  .catalog-table tbody td:first-child {
    padding-left: 14px;
    padding-right: 14px;
    text-align: left;
  }

  .book-info-cell {
    width: 100%;
    min-height: 104px;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 18px;
  }

  .book-cover-box {
    width: 76px;
    height: 104px;
    flex: 0 0 76px;
    margin: 0;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(148, 163, 184, 0.18);
    box-shadow: 0 10px 18px rgba(31, 75, 112, 0.1);
    background: linear-gradient(135deg, #dbeafe, #ede9fe);
  }

  .book-cover-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .book-cover-fallback {
    width: 100%;
    height: 100%;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, #1d4ed8, #7c3aed);
    color: #fff;
    font-size: 24px;
    font-weight: 900;
  }

  .book-title-cell {
    display: grid;
    gap: 4px;
    min-width: 0;
    flex: 1 1 auto;
    justify-items: start;
    text-align: left;
  }

  .book-title-cell strong {
    color: #13263a;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.4;
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: normal;
  }

  .book-title-cell span {
    color: #64748b;
    font-size: 12px;
  }

  .year-pill {
    display: inline-flex;
    align-items: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    background: rgba(37, 99, 235, 0.1);
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 800;
  }

  .synopsis-text {
    color: #4b5b6d;
    line-height: 1.65;
    text-align: justify;
    text-justify: inter-word;
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: normal;
  }

  .catalog-empty {
    padding: 28px 20px;
    text-align: center;
    color: #334155;
    font-weight: 700;
  }

  .pagination-wrap {
    margin-top: 18px;
  }

  @media (max-width: 992px) {
    .catalog-hero {
      flex-direction: column;
    }

    .catalog-summary {
      width: 100%;
      flex-basis: auto;
    }
  }

  @media (max-width: 768px) {
    .catalog-page {
      padding: 20px;
    }

    .catalog-hero {
      padding: 18px;
      border-radius: 18px;
    }

    .catalog-search input,
    .catalog-search select,
    .catalog-search .searchable-select,
    .catalog-search button,
    .catalog-search .reset-link {
      width: 100%;
    }

    .catalog-panel-head {
      min-height: auto;
      padding: 16px;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .catalog-panel-title {
      position: static;
      transform: none;
      width: 100%;
    }

    .catalog-panel-title h3 {
      font-size: 15px;
      padding: 8px 16px;
    }

    .catalog-panel-meta {
      justify-content: center;
      width: 100%;
    }
  }
</style>

<div class="catalog-page">
  <div class="catalog-shell">
    <section class="catalog-hero">
      <div class="catalog-copy">
        <span class="catalog-kicker">Informasi Buku</span>
        <h2> Koleksi perpustakaan untuk siswa</h2>
        <p>
         Jelajahi koleksi buku dan temukan dengan cepat melalui pencarian berdasarkan judul, pengarang, penerbit, atau sinopsis.
        </p>

        <form action="{{ route('informasi.buku') }}" method="GET" class="catalog-search">
          <input
            type="text"
            name="search"
            value="{{ $searchValue }}"
            placeholder="Cari judul, pengarang, penerbit, atau sinopsis..."
          >
          <select name="kategori" class="form-select" data-searchable-portal aria-label="Filter kategori buku">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $kategori)
              <option value="{{ $kategori->id }}" {{ (string) $selectedKategori === (string) $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
              </option>
            @endforeach
          </select>
          <button type="submit">Cari</button>
          @if($searchValue || $selectedKategoriLabel)
            <a href="{{ route('informasi.buku') }}" class="reset-link">Atur Ulang</a>
          @endif
        </form>

      </div>

      <aside class="catalog-summary">
        <span>Total Koleksi</span>
        <strong>{{ $totalCount }}</strong>
        <p>{{ $resultCount }} buku tampil pada halaman ini.</p>
      </aside>
    </section>

  <section class="catalog-panel">
      <div class="catalog-panel-head">
        <div class="catalog-panel-title">
          <h3>Daftar Buku</h3>
        </div>
        @if($searchValue || $selectedKategoriLabel)
          <div class="catalog-panel-meta">
            @if($searchValue)
              <span class="catalog-meta-chip">Pencarian: "{{ $searchValue }}"</span>
            @endif
            @if($selectedKategoriLabel)
              <span class="catalog-meta-chip">Kategori: {{ $selectedKategoriLabel }}</span>
            @endif
          </div>
        @endif
      </div>

      <div class="catalog-table-wrap">
        <table class="catalog-table">
          <colgroup>
            <col class="catalog-col-title">
            <col class="catalog-col-author">
            <col class="catalog-col-publisher">
            <col class="catalog-col-year">
            <col class="catalog-col-synopsis">
          </colgroup>
          <thead>
            <tr>
              <th>Judul Buku</th>
              <th>Pengarang</th>
              <th>Penerbit</th>
              <th>Tahun Terbit</th>
              <th>Sinopsis</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($buku as $item)
              @php
                $coverPath = filled($item->cover_buku) && file_exists(public_path($item->cover_buku))
                    ? asset($item->cover_buku)
                    : null;
                $bookInitial = strtoupper(substr($item->judul_buku ?? 'B', 0, 1));
              @endphp
              <tr>
                <td>
                  <div class="book-info-cell">
                    <div class="book-cover-box">
                      @if($coverPath)
                        <img src="{{ $coverPath }}" alt="Sampul {{ $item->judul_buku }}">
                      @else
                        <div class="book-cover-fallback">{{ $bookInitial }}</div>
                      @endif
                    </div>
                    <div class="book-title-cell">
                      <strong>{{ $item->judul_buku ?? '-' }}</strong>
                    </div>
                  </div>
                </td>
                <td>{{ $item->pengarang ?? $item->nama_penulis ?? '-' }}</td>
                <td>{{ $item->penerbit ?? '-' }}</td>
                <td><span class="year-pill">{{ $item->tahun_terbit ?? '-' }}</span></td>
                <td>
                  <div class="synopsis-text">
                    {{ filled($item->sinopsis) ? $item->sinopsis : 'Sinopsis belum tersedia.' }}
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="catalog-empty">Tidak ada data buku yang cocok dengan pencarian saat ini.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <div class="pagination-wrap">
      {{ $buku->links() }}
    </div>
  </div>
</div>

@endsection
