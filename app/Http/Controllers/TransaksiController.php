<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Denda;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     */
    public function index()
    {
        $search = request('search');

        $data['transaksi'] = Transaksi::with(['Anggota', 'Buku'])
            ->where('status', 'dipinjam')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('id', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT('PJM-', LPAD(id, 4, '0')) like ?", ["%{$search}%"])
                        ->orWhere('tanggal_pinjam', 'like', "%{$search}%")
                        ->orWhereRaw("DATE_FORMAT(tanggal_pinjam, '%d-%m-%Y') like ?", ["%{$search}%"])
                        ->orWhereHas('Anggota', function ($anggota) use ($search) {
                            $anggota->where('kode_anggota', 'like', "%{$search}%")
                                ->orWhere('nama', 'like', "%{$search}%");
                        })
                        ->orWhereHas('Buku', function ($buku) use ($search) {
                            $buku->where('kode_buku', 'like', "%{$search}%")
                                ->orWhere('judul_buku', 'like', "%{$search}%");
                        });
                    });
            })
            ->paginate(5)
            ->withQueryString();
        $data['judul'] = 'Data Transaksi Peminjaman';
        $data['search'] = $search;
        return view('transaksi_index', $data);
    }

    /**
     * Menampilkan form tambah transaksi baru.
     */
    public function create()
    {
        $data['list_anggota'] = Anggota::selectRaw("id, CONCAT(kode_anggota, ' - ', nama) as tampil")
            ->pluck('tampil', 'id');

        $data['list_buku'] = Buku::selectRaw("id, CONCAT(judul_buku, ' - ', nama_penulis) as tampil")
            ->pluck('tampil', 'id');

        return view('transaksi_create', $data);
    }

    /**
     * Simpan data transaksi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date_format:d-m-Y',
        ], $this->transaksiValidationMessages());

        $transaksi = new Transaksi();
        $transaksi->anggota_id = $request->anggota_id;
        $transaksi->buku_id = $request->buku_id;
        $transaksi->tanggal_pinjam = Carbon::createFromFormat('d-m-Y', $request->tanggal_pinjam)->format('Y-m-d');
        $transaksi->tanggal_kembali = null;
        $transaksi->status = 'dipinjam';
        $transaksi->save();

        return redirect('/transaksi')->with('pesan', 'Transaksi berhasil disimpan');
    }

    /**
     * Menampilkan form edit transaksi.
     */
    public function edit(string $id)
    {
        $data['transaksi'] = Transaksi::findOrFail($id);

        $data['list_anggota'] = Anggota::selectRaw("id, CONCAT(kode_anggota, ' - ', nama) as tampil")
            ->pluck('tampil', 'id');

        $data['list_buku'] = Buku::selectRaw("id, CONCAT(judul_buku, ' - ', nama_penulis) as tampil")
            ->pluck('tampil', 'id');
            
        return view('transaksi_edit', $data);
    }

    /**
     * Update data transaksi yang dipilih.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date_format:d-m-Y',
        ], $this->transaksiValidationMessages());

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->anggota_id = $request->anggota_id;
        $transaksi->buku_id = $request->buku_id;
        $transaksi->tanggal_pinjam = Carbon::createFromFormat('d-m-Y', $request->tanggal_pinjam)->format('Y-m-d');
        $transaksi->save();

        return redirect('/transaksi')->with('pesan', 'Transaksi berhasil diupdate');
    }

    /**
     * Hapus transaksi.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        Denda::where('transaksi_id', $transaksi->id)->delete();
        $transaksi->delete();
        return back()->with('pesan', 'Transaksi berhasil dihapus');
    }

    /**
     * Cetak semua data transaksi (laporan).
     */
    public function laporan()
    {
        $periode = $this->resolveReportPeriod(request());

        $data['transaksi'] = Transaksi::with(['Anggota', 'Buku'])
            ->where('status', 'dipinjam')
            ->whereYear('tanggal_pinjam', $periode['tahun'])
            ->whereMonth('tanggal_pinjam', $periode['bulan'])
            ->orderBy('tanggal_pinjam')
            ->get();
        $data['judul'] = 'Laporan Data Peminjaman';
        $data['periode'] = $periode['periode'];
        return view('transaksi_laporan', $data);
    }

    private function transaksiValidationMessages(): array
    {
        return [
            'anggota_id.required' => 'Harap di isi kolom ini.',
            'buku_id.required' => 'Harap di isi kolom ini.',
            'tanggal_pinjam.required' => 'Harap di isi kolom ini.',
            'anggota_id.exists' => 'Anggota yang dipilih tidak tersedia.',
            'buku_id.exists' => 'Buku yang dipilih tidak tersedia.',
            'tanggal_pinjam.date_format' => 'Format tanggal harus dd-mm-yyyy.',
        ];
    }
}
