<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Support\Facades\File;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data['buku'] = Buku::with('kategori')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_buku', 'like', "%{$search}%")
                    ->orWhere('nomor_panggil', 'like', "%{$search}%")
                    ->orWhere('judul_buku', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('nama_penulis', 'like', "%{$search}%")
                    ->orWhere('penerbit', 'like', "%{$search}%")
                    ->orWhere('sinopsis', 'like', "%{$search}%")
                    ->orWhere('tahun_terbit', 'like', "%{$search}%")
                    ->orWhere('kategori_buku', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($kategori) use ($search) {
                        $kategori->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->paginate(5)
            ->withQueryString();
        $data['judul'] = 'Data Buku';
        $data['search'] = $search;
        return view('buku_index', $data);
    }

    public function create()
    {
        $data['kategori_bk'] = KategoriBuku::orderBy('nama_kategori')->get();
        $data['kode_buku'] = $this->generateKodeBuku();
        $data['nomor_panggil'] = '';
        $data['judul'] = 'Tambah Data Buku';
        return view('buku_create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'     => 'required|unique:bukus,kode_buku',
            'judul_buku'    => 'required|unique:bukus,judul_buku',
            'pengarang'     => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required|digits:4|integer',
            'kategori_buku_id' => 'required|exists:kategori_buku,id',
            'cover_buku'    => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'sinopsis'      => 'required|string|max:5000',
        ], $this->bukuValidationMessages());

        $kategori = KategoriBuku::findOrFail($request->kategori_buku_id);
        $nomorPanggil = $this->generateUniqueNomorPanggil($kategori, $request->pengarang, $request->judul_buku);

        $data = new Buku();
        $data->nomor_panggil = $nomorPanggil;
        $data->kode_buku = $request->kode_buku;
        $data->judul_buku = $request->judul_buku;
        $data->pengarang = $request->pengarang;
        $data->penerbit = $request->penerbit;
        $data->tahun_terbit = $request->tahun_terbit;
        $data->kategori_buku_id = $kategori->id;
        $data->kategori_buku = $kategori->nama_kategori;
        $data->nama_penulis = $request->pengarang;
        $data->cover_buku = $this->storeCoverBuku($request);
        $data->sinopsis = $request->sinopsis;
        $data->save();

        return redirect('/buku')->with('pesan', 'Data berhasil disimpan');
    }

    public function edit(string $id)
    {
        $data['buku'] = Buku::findOrFail($id);
        $data['kategori_bk'] = KategoriBuku::orderBy('nama_kategori')->get();
        $data['judul'] = 'Edit Data Buku';
        return view('buku_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_buku'     => 'required|unique:bukus,kode_buku,' . $id,
            'judul_buku'    => 'required|unique:bukus,judul_buku,' . $id,
            'pengarang'     => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required|digits:4|integer',
            'kategori_buku_id' => 'required|exists:kategori_buku,id',
            'cover_buku'    => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'sinopsis'      => 'required|string|max:5000',
        ], $this->bukuValidationMessages());

        $kategori = KategoriBuku::findOrFail($request->kategori_buku_id);
        $nomorPanggil = $this->generateUniqueNomorPanggil($kategori, $request->pengarang, $request->judul_buku, $id);

        $buku = Buku::findOrFail($id);
        $oldCoverPath = $buku->cover_buku;
        $buku->nomor_panggil = $nomorPanggil;
        $buku->kode_buku = $request->kode_buku;
        $buku->judul_buku = $request->judul_buku;
        $buku->pengarang = $request->pengarang;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->kategori_buku_id = $kategori->id;
        $buku->kategori_buku = $kategori->nama_kategori;
        $buku->nama_penulis = $request->pengarang;
        $newCoverPath = $this->storeCoverBuku($request);
        if ($newCoverPath) {
            $buku->cover_buku = $newCoverPath;
        }
        $buku->sinopsis = $request->sinopsis;
        $buku->save();

        if ($newCoverPath && $oldCoverPath && $oldCoverPath !== $newCoverPath) {
            $this->deleteCoverBukuPath($oldCoverPath);
        }

        return redirect('/buku')->with('pesan', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        Buku::findOrFail($id)->delete();
        return back()->with('pesan', 'Data berhasil dihapus');
    }

    public function laporan()
    {
        $periode = $this->resolveReportPeriod(request());

        $data['buku'] = Buku::with('kategori')
            ->whereYear('created_at', $periode['tahun'])
            ->whereMonth('created_at', $periode['bulan'])
            ->orderBy('judul_buku')
            ->get();
        $data['judul'] = 'Laporan Data Buku';
        $data['periode'] = $periode['periode'];
        return view('buku_laporan', $data);
    }

    private function generateKodeBuku(): string
    {
        $lastId = Buku::max('id') ?? 0;
        return 'BK-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }

    private function generateNomorPanggil(KategoriBuku $kategori, string $pengarang, string $judul): string
    {
        $kodeKlasifikasi = $kategori->kode_klasifikasi ?: ($kategori->kode_kategori ?: $kategori->id);
        $kodePengarang = strtoupper(substr($this->onlyLettersAndNumbers($pengarang), 0, 3));
        $kodeJudul = strtolower(substr($this->onlyLettersAndNumbers($judul), 0, 1));

        return trim($kodeKlasifikasi . ' ' . $kodePengarang . ' ' . $kodeJudul);
    }

    private function generateUniqueNomorPanggil(KategoriBuku $kategori, string $pengarang, string $judul, ?int $ignoreId = null): string
    {
        $nomorPanggil = $this->generateNomorPanggil($kategori, $pengarang, $judul);
        $uniqueNomorPanggil = $nomorPanggil;
        $counter = 2;

        while (
            Buku::where('nomor_panggil', $uniqueNomorPanggil)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $uniqueNomorPanggil = $nomorPanggil . '-' . $counter;
            $counter++;
        }

        return $uniqueNomorPanggil;
    }

    private function onlyLettersAndNumbers(string $value): string
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $value) ?: '';
    }

    private function storeCoverBuku(Request $request): ?string
    {
        if (! $request->hasFile('cover_buku')) {
            return null;
        }

        $uploadPath = public_path('uploads/book-covers');
        if (! File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }

        $file = $request->file('cover_buku');
        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg');
        $fileName = 'cover-buku-' . uniqid('', true) . '.' . $extension;
        $targetPath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;
        $contents = file_get_contents($file->getRealPath());

        if ($contents === false || File::put($targetPath, $contents) === false) {
            throw new \RuntimeException('Gagal menyimpan cover buku.');
        }

        return 'uploads/book-covers/' . $fileName;
    }

    private function deleteCoverBukuPath(?string $relativePath): void
    {
        if (! $relativePath) {
            return;
        }

        $oldCover = public_path($relativePath);

        if (File::exists($oldCover)) {
            File::delete($oldCover);
        }
    }

    private function bukuValidationMessages(): array
    {
        return [
            'kode_buku.required' => 'Harap di isi kolom ini.',
            'kode_buku.unique' => 'Kode buku sudah digunakan.',
            'judul_buku.required' => 'Harap di isi kolom ini.',
            'judul_buku.unique' => 'Judul buku sudah terdaftar.',
            'pengarang.required' => 'Harap di isi kolom ini.',
            'penerbit.required' => 'Harap di isi kolom ini.',
            'tahun_terbit.required' => 'Harap di isi kolom ini.',
            'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 angka.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'kategori_buku_id.required' => 'Harap di isi kolom ini.',
            'kategori_buku_id.exists' => 'Kategori buku yang dipilih tidak tersedia.',
            'cover_buku.required' => 'Harap di isi kolom ini.',
            'cover_buku.image' => 'Cover buku harus berupa file gambar.',
            'cover_buku.mimes' => 'Cover buku harus berformat JPG, JPEG, PNG, WEBP, atau GIF.',
            'cover_buku.max' => 'Ukuran cover buku maksimal 4 MB.',
            'sinopsis.required' => 'Harap di isi kolom ini.',
            'sinopsis.string' => 'Sinopsis harus berupa teks.',
            'sinopsis.max' => 'Sinopsis maksimal 5.000 karakter.',
        ];
    }
}
