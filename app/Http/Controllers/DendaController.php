<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $search = request('search');
        $status = request('status');

        $data['denda'] = Denda::with('Transaksi.Anggota', 'Transaksi.Buku')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('id', 'like', "%{$search}%")
                        ->orWhere('jumlah_denda', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT('PJM-', LPAD(transaksi_id, 4, '0')) like ?", ["%{$search}%"])
                        ->orWhereHas('Transaksi.Anggota', function ($anggota) use ($search) {
                            $anggota->where('nama', 'like', "%{$search}%")
                                ->orWhere('kode_anggota', 'like', "%{$search}%");
                        })
                        ->orWhereHas('Transaksi.Buku', function ($buku) use ($search) {
                            $buku->where('judul_buku', 'like', "%{$search}%")
                                ->orWhere('kode_buku', 'like', "%{$search}%");
                        });
                    });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->paginate(5)
            ->withQueryString();
        $data['judul'] = 'Tabel Data Denda';
        $data['search'] = $search;
        $data['status_filter'] = $status;
        return view('denda_index', $data);
    }

    public function create()
    {
        return redirect('/denda')->with('pesan', 'Denda dibuat otomatis dari menu pengembalian jika buku terlambat.');
    }

    public function store(Request $request)
    {
        return redirect('/denda')->with('pesan', 'Denda dibuat otomatis dari menu pengembalian jika buku terlambat.');
    }

    public function edit(string $id)
    {
        $data['denda'] = Denda::findOrFail($id);
        $data['list_transaksi'] = Transaksi::with(['Anggota', 'Buku'])
            ->get()
            ->mapWithKeys(function ($transaksi) {
                return [
                    $transaksi->id => $transaksi->kode_pinjam . ' - ' . $transaksi->anggota->nama . ' - ' . $transaksi->buku->judul_buku,
                ];
            });

        $data['status'] = ['Belum Dibayar', 'Dibayar'];
        $data['judul'] = 'Edit Data Denda';
        return view('denda_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'jumlah_denda' => 'required|integer|min:0',
            'keterangan' => 'required|string',
            'status' => 'required',
        ], [
            'transaksi_id.required' => 'Harap isi kolom ini.',
            'transaksi_id.exists' => 'Transaksi yang dipilih tidak tersedia.',
            'jumlah_denda.required' => 'Harap isi kolom ini.',
            'jumlah_denda.integer' => 'Jumlah denda harus berupa angka.',
            'jumlah_denda.min' => 'Jumlah denda tidak boleh kurang dari 0.',
            'keterangan.required' => 'Harap isi kolom ini.',
            'status.required' => 'Harap isi kolom ini.',
        ]);

        $denda = Denda::findOrFail($id);
        $denda->update($request->only('transaksi_id', 'jumlah_denda', 'keterangan', 'status'));

        return redirect('/denda')->with('pesan', 'Data denda berhasil diupdate');
    }

    public function destroy(string $id)
    {
        Denda::findOrFail($id)->delete();
        return back()->with('pesan', 'Data denda berhasil dihapus');
    }

    public function laporan()
    {
        $periode = $this->resolveReportPeriod(request());

        $data['denda'] = Denda::with('Transaksi.Anggota', 'Transaksi.Buku')
            ->whereYear('created_at', $periode['tahun'])
            ->whereMonth('created_at', $periode['bulan'])
            ->orderBy('created_at')
            ->get();
        $data['judul'] = 'Laporan Data Denda';
        $data['periode'] = $periode['periode'];
        return view('denda_laporan', $data);
    }
}
