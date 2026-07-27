<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $search = request('search');

        $data['transaksi'] = Transaksi::with(['Anggota', 'Buku'])
            ->where('status', 'dipinjam')
            ->whereHas('Anggota')
            ->whereHas('Buku')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('id', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT('PJM-', LPAD(id, 4, '0')) like ?", ["%{$search}%"])
                        ->orWhere('tanggal_pinjam', 'like', "%{$search}%")
                        ->orWhereRaw("DATE_FORMAT(tanggal_pinjam, '%d-%m-%Y') like ?", ["%{$search}%"])
                        ->orWhereHas('Anggota', function ($anggota) use ($search) {
                            $anggota->where('nama', 'like', "%{$search}%")
                                ->orWhere('kode_anggota', 'like', "%{$search}%");
                        })
                        ->orWhereHas('Buku', function ($buku) use ($search) {
                            $buku->where('judul_buku', 'like', "%{$search}%")
                                ->orWhere('kode_buku', 'like', "%{$search}%");
                        });
                    });
            })
            ->paginate(5)
            ->withQueryString();
        $data['judul'] = 'Data Pengembalian Buku';
        $data['search'] = $search;
        return view('pengembalian_index', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date_format:d-m-Y',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->tanggal_kembali = Carbon::createFromFormat('d-m-Y', $request->tanggal_kembali)->format('Y-m-d');
        $transaksi->status = 'dikembalikan';
        $transaksi->save();

        if ($transaksi->hari_terlambat > 0) {
            $denda = Denda::firstOrNew([
                'transaksi_id' => $transaksi->id,
            ]);

            $denda->jumlah_denda = $transaksi->nominal_denda;
            $denda->keterangan = 'Denda otomatis untuk keterlambatan ' . $transaksi->hari_terlambat . ' hari.';

            if (! $denda->exists) {
                $denda->status = 'Belum Dibayar';
            }

            $denda->save();
        } else {
            Denda::where('transaksi_id', $transaksi->id)->delete();
        }

        return back()->with('pesan', 'Buku berhasil dikembalikan');
    }

    public function laporan()
    {
        $periode = $this->resolveReportPeriod(request());

        $data['transaksi'] = Transaksi::with(['Anggota', 'Buku'])
            ->where('status', 'dikembalikan')
            ->whereHas('Anggota')
            ->whereHas('Buku')
            ->whereNotNull('tanggal_kembali')
            ->whereYear('tanggal_kembali', $periode['tahun'])
            ->whereMonth('tanggal_kembali', $periode['bulan'])
            ->orderBy('tanggal_kembali')
            ->get();
        $data['judul'] = 'Laporan Data Pengembalian';
        $data['periode'] = $periode['periode'];
        return view('pengembalian_laporan', $data);
    }
}
