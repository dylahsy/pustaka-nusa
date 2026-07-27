<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home/notifikasi/{notificationKey}/read', [App\Http\Controllers\HomeController::class, 'markNotificationAsRead'])
        ->name('dashboard.notifications.read');

    Route::get('/informasi-buku', function () {
        $search = request('search');
        $selectedKategori = request('kategori');
        $kategoriList = KategoriBuku::orderBy('nama_kategori')->get();
        $selectedKategoriLabel = $kategoriList->firstWhere('id', (int) $selectedKategori)?->nama_kategori;

        $buku = Buku::with('kategori')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($bookQuery) use ($search) {
                    $bookQuery->where('kode_buku', 'like', "%{$search}%")
                        ->orWhere('nomor_panggil', 'like', "%{$search}%")
                        ->orWhere('judul_buku', 'like', "%{$search}%")
                        ->orWhere('pengarang', 'like', "%{$search}%")
                        ->orWhere('nama_penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhere('sinopsis', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($kategori) use ($search) {
                            $kategori->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })
            ->when($selectedKategori, function ($query) use ($selectedKategori) {
                $query->where('kategori_buku_id', $selectedKategori);
            })
            ->orderBy('judul_buku')
            ->paginate(10)
            ->withQueryString();

        return view('informasi_buku', compact('buku', 'search', 'kategoriList', 'selectedKategori', 'selectedKategoriLabel'));
    })->middleware('role:Admin,Kepala Perpustakaan,Anggota')->name('informasi.buku');

    Route::middleware('role:Admin,Kepala Perpustakaan,Anggota')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile/data', [ProfileController::class, 'editData'])->name('profile.data.edit');
        Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::get('/profile/kartu', [ProfileController::class, 'printCard'])->name('profile.card.print');
        Route::post('/profile/account', [ProfileController::class, 'updateAccount'])->name('profile.account.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    });

    Route::middleware('role:Admin,Kepala Perpustakaan')->group(function () {
        Route::resource('buku',BukuController::class)->except(['show']);
        Route::resource('transaksi',TransaksiController::class)->except(['show']);
        Route::get('anggota/{anggota}/kartu', [AnggotaController::class, 'kartu'])->name('anggota.kartu');
        Route::resource('anggota', AnggotaController::class)->except(['show']);
        Route::resource('kategori-buku', KategoriBukuController::class)->except(['show']);
        Route::resource('denda', DendaController::class)->except(['show']);
        Route::resource('admin', AdminController::class)->except(['show']);
        Route::get('/pengembalian', [PengembalianController::class, 'index']);
        Route::post('/pengembalian/{id}', [PengembalianController::class, 'update']);
        Route::get('/laporan', [LaporanController::class, 'index']);

        Route::get('buku/laporan/cetak', [BukuController::class, 'laporan']);
        Route::get('kategori-buku/laporan/cetak', [KategoriBukuController::class, 'laporan']);
        Route::get('transaksi/laporan/cetak', [TransaksiController::class, 'laporan']);
        Route::get('pengembalian/laporan/cetak', [PengembalianController::class, 'laporan']);
        Route::get('anggota/laporan/cetak', [AnggotaController::class, 'laporan']);
        Route::get('denda/laporan/cetak', [DendaController::class, 'laporan']);
    });
});



Route::get('/contact', function () {
    return view('contact');
});

// Fallback logout untuk tombol navigasi agar tidak gagal ketika token sesi
// pada halaman lama sudah kedaluwarsa.
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth')->name('logout.get');
