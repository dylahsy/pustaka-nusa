<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $search = request('search');

        $data['kategori_buku'] = KategoriBuku::when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('kode_kategori', 'like', "%{$search}%")
                    ->orWhere('kode_klasifikasi', 'like', "%{$search}%")
                    ->orWhere('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('nama_kategori')
            ->paginate(5)
            ->withQueryString();
        $data['judul'] = 'Tabel Data Kategori Buku';
        $data['search'] = $search;
        return view('kategori_buku_index', $data);
    }

    public function create()
    {
        $data['kode_kategori'] = $this->generateKodeKategori();
        $data['judul'] = 'Tambah Data Kategori Buku';
        return view('kategori_buku_create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori_buku', 'kode_kategori')],
            'kode_klasifikasi' => ['required', 'string', 'max:255'],
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori_buku', 'nama_kategori')],
            'keterangan' => ['required', 'string', 'max:500'],
        ], [
            'kode_kategori.required' => 'Harap di isi kolom ini.',
            'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
            'kode_kategori.string' => 'Kode kategori harus berupa teks.',
            'kode_kategori.max' => 'Kode kategori maksimal 255 karakter.',
            'kode_klasifikasi.required' => 'Harap di isi kolom ini.',
            'kode_klasifikasi.string' => 'Kode klasifikasi harus berupa teks.',
            'kode_klasifikasi.max' => 'Kode klasifikasi maksimal 255 karakter.',
            'nama_kategori.required' => 'Harap di isi kolom ini.',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
            'keterangan.required' => 'Harap di isi kolom ini.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        $keterangan = $request->keterangan;

        KategoriBuku::create([
            'kode_kategori' => $request->kode_kategori,
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $keterangan,
            'deskripsi' => $keterangan,
        ]);

        return redirect('/kategori-buku')->with('pesan', 'Data kategori buku berhasil disimpan');
    }

    public function edit(string $id)
    {
        $data['kategori'] = KategoriBuku::findOrFail($id);
        $data['judul'] = 'Edit Data Kategori Buku';
        return view('kategori_buku_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori_buku', 'kode_kategori')->ignore($id)],
            'kode_klasifikasi' => ['required', 'string', 'max:255'],
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori_buku', 'nama_kategori')->ignore($id)],
            'keterangan' => ['required', 'string', 'max:500'],
        ], [
            'kode_kategori.required' => 'Harap di isi kolom ini.',
            'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
            'kode_kategori.string' => 'Kode kategori harus berupa teks.',
            'kode_kategori.max' => 'Kode kategori maksimal 255 karakter.',
            'kode_klasifikasi.required' => 'Harap di isi kolom ini.',
            'kode_klasifikasi.string' => 'Kode klasifikasi harus berupa teks.',
            'kode_klasifikasi.max' => 'Kode klasifikasi maksimal 255 karakter.',
            'nama_kategori.required' => 'Harap di isi kolom ini.',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
            'keterangan.required' => 'Harap di isi kolom ini.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        $kategori = KategoriBuku::findOrFail($id);
        $kategori->kode_kategori = $request->kode_kategori;
        $kategori->kode_klasifikasi = $request->kode_klasifikasi;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->keterangan = $request->keterangan;
        $kategori->deskripsi = $request->keterangan;
        $kategori->save();

        return redirect('/kategori-buku')->with('pesan', 'Data kategori buku berhasil diupdate');
    }

    public function destroy(string $id)
    {
        KategoriBuku::findOrFail($id)->delete();
        return back()->with('pesan', 'Data kategori buku berhasil dihapus');
    }

    public function laporan()
    {
        $periode = $this->resolveReportPeriod(request());

        // Kategori buku merupakan data master, sehingga laporan menampilkan
        // seluruh kategori yang tersedia, bukan hanya kategori yang dibuat
        // pada bulan tertentu.
        $data['kategori_buku'] = KategoriBuku::query()
            ->orderBy('nama_kategori')
            ->get();
        $data['judul'] = 'Laporan Data Kategori Buku';
        $data['periode'] = 'Semua Data';
        return view('kategori_buku_laporan', $data);
    }

    private function generateKodeKategori(): string
    {
        $lastId = KategoriBuku::max('id') ?? 0;
        return 'KTG' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
    }
}
