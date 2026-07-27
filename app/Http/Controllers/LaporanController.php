<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $this->resolveReportPeriod($request);

        $data['judul'] = 'Menu Laporan';
        $data['bulanOptions'] = $this->reportMonths();
        $data['tahunOptions'] = $this->reportYears();
        $data['selectedBulan'] = $periode['bulan'];
        $data['selectedTahun'] = $periode['tahun'];
        $data['periode'] = $periode['periode'];
        return view('laporan_index', $data);
    }
}
