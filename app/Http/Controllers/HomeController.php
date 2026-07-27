<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\KategoriBuku;
use App\Models\Anggota;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()?->role === 'Anggota') {
            return redirect()->route('informasi.buku');
        }

        $data['total_buku'] = Buku::count();
        $data['total_anggota'] = Anggota::count();
        $data['total_kategori'] = KategoriBuku::count();
        $data['peminjaman_aktif'] = Transaksi::where('status', 'dipinjam')->count();
        $data['pengembalian_buku'] = Transaksi::where('status', 'dikembalikan')->count();
        $data['total_denda'] = Denda::sum('jumlah_denda');
        $dashboardNotifications = $this->buildDashboardNotifications();
        $data['dashboard_notifications'] = $dashboardNotifications['items'];
        $data['dashboard_notification_count'] = $dashboardNotifications['count'];

        return view('home', $data);
    }

    public function markNotificationAsRead(Request $request, string $notificationKey)
    {
        if (auth()->user()?->role === 'Anggota') {
            return redirect()->route('informasi.buku');
        }

        $dismissedKeys = $this->getDismissedNotificationKeys();

        if (! in_array($notificationKey, $dismissedKeys, true)) {
            $dismissedKeys[] = $notificationKey;
            $request->session()->put($this->notificationSessionKey(), array_values(array_unique($dismissedKeys)));
        }

        return redirect()->to($this->resolveNotificationTarget($notificationKey));
    }

    private function buildDashboardNotifications(): array
    {
        $dismissedKeys = $this->getDismissedNotificationKeys();
        $warnings = [];
        $books = [];

        $overdueTransactions = Transaksi::with(['Anggota', 'Buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_pinjam', '<', now()->subDays(7))
            ->orderBy('tanggal_pinjam')
            ->get();

        foreach ($overdueTransactions as $transaksi) {
            $key = 'overdue-'.$transaksi->id;

            if (in_array($key, $dismissedKeys, true)) {
                continue;
            }

            $warnings[] = [
                'key' => $key,
                'title' => 'Buku Terlambat',
                'message' => sprintf(
                    '%s dipinjam oleh %s terlambat %d hari.',
                    $transaksi->Buku->judul_buku ?? 'Buku tidak diketahui',
                    $transaksi->Anggota->nama ?? 'anggota tidak diketahui',
                    $transaksi->hari_terlambat
                ),
                'icon' => 'bi bi-exclamation-triangle',
                'color' => '#eb5757',
            ];
        }

        $unpaidFines = Denda::with(['Transaksi.Anggota', 'Transaksi.Buku'])
            ->where('status', 'Belum Dibayar')
            ->orderByDesc('created_at')
            ->get();

        foreach ($unpaidFines as $denda) {
            $key = 'fine-'.$denda->id;

            if (in_array($key, $dismissedKeys, true)) {
                continue;
            }

            $transaksi = $denda->Transaksi;

            $warnings[] = [
                'key' => $key,
                'title' => 'Anggota Memiliki Denda',
                'message' => sprintf(
                    '%s belum melunasi denda Rp %s untuk %s.',
                    $transaksi->Anggota->nama ?? 'anggota tidak diketahui',
                    number_format((int) $denda->jumlah_denda, 0, ',', '.'),
                    $transaksi->Buku->judul_buku ?? 'Buku tidak diketahui'
                ),
                'icon' => 'bi bi-cash',
                'color' => '#f2994a',
            ];
        }

        $latestBooks = Buku::latest('id')->take(3)->get();

        foreach ($latestBooks as $buku) {
            $key = 'book-'.$buku->id;

            if (in_array($key, $dismissedKeys, true)) {
                continue;
            }

            $books[] = [
                'key' => $key,
                'title' => 'Buku Baru Ditambahkan',
                'message' => $buku->judul_buku,
                'icon' => 'bi bi-bookmark-plus',
                'color' => '#2f80ed',
            ];
        }

        return [
            'items' => [
                'warnings' => $warnings,
                'books' => $books,
            ],
            'count' => count($warnings) + count($books),
        ];
    }

    private function getDismissedNotificationKeys(): array
    {
        return session()->get($this->notificationSessionKey(), []);
    }

    private function notificationSessionKey(): string
    {
        return 'dashboard_notifications.dismissed.'.(auth()->id() ?? 'guest');
    }

    private function resolveNotificationTarget(string $notificationKey): string
    {
        if (str_starts_with($notificationKey, 'overdue-')) {
            return url('/transaksi');
        }

        if (str_starts_with($notificationKey, 'fine-')) {
            return url('/denda');
        }

        if (str_starts_with($notificationKey, 'book-')) {
            return url('/buku');
        }

        return url('/home');
    }
}
