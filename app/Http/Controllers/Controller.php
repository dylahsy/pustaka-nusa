<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function reportMonths(): array
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    protected function reportYears(): array
    {
        $yearSources = [
            ['bukus', 'created_at'],
            ['anggota', 'created_at'],
            ['kategori_buku', 'created_at'],
            ['dendas', 'created_at'],
            ['transaksis', 'tanggal_pinjam'],
            ['transaksis', 'tanggal_kembali'],
        ];

        $years = collect();

        foreach ($yearSources as [$table, $column]) {
            $years = $years->merge(
                DB::table($table)
                    ->whereNotNull($column)
                    ->pluck($column)
                    ->map(fn ($value) => Carbon::parse($value)->year)
            );
        }

        $years = $years->filter()
            ->map(fn ($year) => (int) $year)
            ->unique()
            ->sort()
            ->values();

        if ($years->isEmpty()) {
            return [now()->year];
        }

        $minYear = $years->first();
        $maxYear = max($years->last(), now()->year);

        return range($minYear, $maxYear);
    }

    protected function resolveReportPeriod(?Request $request = null): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $month = (int) ($request?->query('bulan') ?? $currentMonth);
        $year = (int) ($request?->query('tahun') ?? $currentYear);

        if ($month < 1 || $month > 12) {
            $month = $currentMonth;
        }

        if (! in_array($year, $this->reportYears(), true)) {
            $year = $currentYear;
        }

        return [
            'bulan' => $month,
            'tahun' => $year,
            'periode' => $this->reportPeriodLabel($month, $year),
        ];
    }

    protected function reportPeriodLabel(int $month, int $year): string
    {
        $months = $this->reportMonths();

        return ($months[$month] ?? $months[now()->month]) . ' ' . $year;
    }

    protected function filterByReportPeriod($query, string $dateColumn, int $month, int $year)
    {
        return $query->whereMonth($dateColumn, $month)->whereYear($dateColumn, $year);
    }
}
