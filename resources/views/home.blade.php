@extends('layouts.perpus')

@section('content')

<style>
body {
    background: #eef3f8;
    font-family: 'Poppins', sans-serif;
}

.dashboard-page {
    padding: 32px;
}

.dashboard-hero {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    flex-wrap: wrap;
    background: linear-gradient(135deg, rgba(47, 128, 237, 0.95), rgba(17, 105, 142, 0.92)),
    url('{{ asset('templateperpus/img/perpus.png') }}') center / cover;
    border-radius: 12px;
    padding: 28px;
    box-shadow: 0 12px 28px rgba(26, 43, 72, 0.16);
    color: #fff;
}

.dashboard-hero-content {
    display: flex;
    align-items: center;
    gap: 18px;
    min-width: 0;
    flex: 1 1 420px;
}

.dashboard-hero-copy {
    min-width: 0;
}

.dashboard-hero-aside {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-left: auto;
    flex: 0 0 auto;
}

.school-logo {
    width: 82px;
    height: 82px;
    object-fit: cover;
    border-radius: 14px;
    border: 3px solid rgba(255, 255, 255, 0.85);
    background: #fff;
}

.dashboard-hero h2 {
    margin: 0;
    color: #fff;
    font-size: 32px;
    font-weight: 700;
}

.dashboard-hero p {
    margin: 6px 0 0;
    color: rgba(255, 255, 255, 0.9);
    font-size: 15px;
}

.dashboard-notification {
    position: relative;
    flex: 0 0 auto;
}

.notification-bell {
    width: 52px;
    height: 52px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
    font-size: 22px;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.14);
    transition: 0.25s;
}

.notification-bell:hover,
.notification-bell:focus {
    background: rgba(255, 255, 255, 0.28);
    color: #fff;
    transform: translateY(-1px);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -4px;
    min-width: 20px;
    height: 20px;
    padding: 0 5px;
    border-radius: 999px;
    background: #ffcf5c;
    color: #17324d;
    font-size: 11px;
    font-weight: 800;
    line-height: 20px;
    text-align: center;
    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.22);
}

.notification-menu {
    width: min(360px, calc(100vw - 40px));
    padding: 0;
    overflow: hidden;
    border: 0;
    border-radius: 18px;
    box-shadow: 0 18px 42px rgba(26, 43, 72, 0.18);
}

.notification-menu-body {
    max-height: min(430px, calc(100vh - 190px));
    overflow-y: auto;
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: #9bb8d8 transparent;
}

.notification-menu-body::-webkit-scrollbar {
    width: 7px;
}

.notification-menu-body::-webkit-scrollbar-thumb {
    border-radius: 999px;
    background: #9bb8d8;
}

.notification-menu-header {
    padding: 16px 18px;
    background: linear-gradient(135deg, #2f80ed, #11698e);
    color: #fff;
}

.notification-menu-title {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
}

.notification-menu-subtitle {
    margin: 4px 0 0;
    color: rgba(255, 255, 255, 0.82);
    font-size: 12px;
}

.notification-menu-section {
    padding: 10px 0;
}

.notification-menu-form {
    margin: 0;
}

.notification-menu-section-title {
    padding: 0 18px 8px;
    color: #64748b;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.notification-menu-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 18px;
    text-decoration: none;
    color: #1f2d3d;
    transition: 0.2s;
}

.notification-menu-item:hover {
    background: #f3f8ff;
    color: #1f2d3d;
}

.notification-menu-button {
    width: 100%;
    border: 0;
    background: transparent;
    cursor: pointer;
    font: inherit;
    text-align: left;
    appearance: none;
}

.notification-item-icon {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: #fff;
    flex: 0 0 auto;
}

.notification-item-text {
    min-width: 0;
}

.notification-item-text strong {
    display: block;
    margin-bottom: 4px;
    color: #17324d;
    font-size: 14px;
    font-weight: 800;
}

.notification-item-text p {
    margin: 0;
    color: #526273;
    font-size: 13px;
    line-height: 1.45;
}

.notification-empty {
    padding: 0 18px 4px;
    color: #667789;
    font-size: 13px;
}

.notification-divider {
    margin: 6px 0;
    border-color: #edf2f7;
}

.stat-card {
    display: block;
    background: #ffffff;
    border-radius: 12px;
    padding: 18px;
    min-height: 120px;
    box-shadow: 0 8px 22px rgba(26, 43, 72, 0.08);
    border: 1px solid #e1eaf4;
    text-decoration: none;
    transition: 0.3s;
    position: relative;
    overflow: hidden;
}

.stat-card::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 86px;
    height: 86px;
    border-radius: 0 12px 0 100%;
    background: var(--accent-soft);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(26, 43, 72, 0.14);
    border-color: #b9d4f2;
}

.stat-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: #fff;
    font-size: 20px;
    margin-bottom: 14px;
    position: relative;
    z-index: 1;
}

.stat-card h3 {
    margin: 0;
    color: #1f2d3d;
    font-size: 28px;
    font-weight: 700;
    position: relative;
    z-index: 1;
}

.stat-card p {
    margin: 4px 0 0;
    color: #667789;
    font-size: 14px;
    position: relative;
    z-index: 1;
}

.panel {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 22px rgba(26, 43, 72, 0.08);
    border: 1px solid #e1eaf4;
}

.panel-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e8eef5;
    font-weight: 700;
    color: #1f2d3d;
}

.panel-body {
    padding: 20px;
}

.quick-link-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.quick-link {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px;
    border-radius: 12px;
    background: linear-gradient(135deg, #ffffff, #f3f8ff);
    border: 1px solid #dce9f6;
    text-decoration: none;
    box-shadow: 0 8px 18px rgba(26, 43, 72, 0.08);
    transition: 0.25s;
    color: #1f2d3d;
}

.quick-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 26px rgba(26, 43, 72, 0.12);
    color: #1f2d3d;
}

.quick-link-icon {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    color: #fff;
    font-size: 22px;
    flex: 0 0 auto;
}

.quick-link strong {
    display: block;
    margin-bottom: 3px;
    font-size: 15px;
    font-weight: 800;
    color: #17324d;
}

.quick-link span {
    display: block;
    color: #64748b;
    font-size: 13px;
}

@media (max-width: 768px) {
    .dashboard-page {
        padding: 20px;
    }

    .dashboard-hero {
        gap: 14px;
        padding: 22px;
    }

    .dashboard-hero-content {
        gap: 14px;
        flex-basis: 100%;
    }

    .dashboard-hero-aside {
        width: 100%;
        margin-left: 0;
        justify-content: flex-end;
    }

    .school-logo {
        width: 68px;
        height: 68px;
    }

    .dashboard-hero h2 {
        font-size: 24px;
    }

    .dashboard-hero p {
        font-size: 13px;
    }

    .notification-bell {
        width: 46px;
        height: 46px;
        font-size: 19px;
    }

    .notification-menu {
        width: min(300px, calc(100vw - 24px));
    }

    .quick-link-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@php
$dashboardNotifications = $dashboard_notifications ?? ['warnings' => [], 'books' => []];
$urgentNotificationCount = $dashboard_notification_count ?? 0;
@endphp

<div class="dashboard-page">
    <div class="dashboard-hero mb-4">
        <div class="dashboard-hero-content">
            <img src="{{ asset('templateperpus/img/logo_smanes.jpg') }}" alt="Logo SMA Negeri 9 Kota Jambi"
                class="school-logo">
            <div class="dashboard-hero-copy">
                <h2>SIMPUS SMANES</h2>
                <p>Sistem Informasi Perpustakaan SMA Negeri 9 Kota Jambi</p>
                <p>Selamat datang, {{ Auth::user()->name }}. Kelola data perpustakaan dengan mudah dan rapi.</p>
            </div>
        </div>

        <div class="dashboard-hero-aside">
            <div class="dropdown dashboard-notification">
                <button type="button" class="notification-bell" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="Lihat notifikasi dashboard">
                    <i class="bi bi-bell-fill"></i>
                    @if($urgentNotificationCount > 0)
                    <span
                        class="notification-badge">{{ $urgentNotificationCount > 99 ? '99+' : $urgentNotificationCount }}</span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-end notification-menu">
                    <div class="notification-menu-header">
                        <p class="notification-menu-title">Notifikasi Dashboard</p>
                    </div>

                    <div class="notification-menu-body">

                        @if(!empty($dashboardNotifications['warnings']))
                        <div class="notification-menu-section">
                            <div class="notification-menu-section-title">Peringatan</div>

                            @foreach($dashboardNotifications['warnings'] as $notification)
                            <form method="POST"
                                action="{{ route('dashboard.notifications.read', $notification['key']) }}"
                                class="notification-menu-form">
                                @csrf
                                <button type="submit" class="notification-menu-item notification-menu-button">
                                    <span class="notification-item-icon"
                                        style="background:{{ $notification['color'] }};"><i
                                            class="{{ $notification['icon'] }}"></i></span>
                                    <div class="notification-item-text">
                                        <strong>{{ $notification['title'] }}</strong>
                                        <p>{{ $notification['message'] }}</p>
                                    </div>
                                </button>
                            </form>
                            @endforeach
                        </div>
                        @endif

                        @if(!empty($dashboardNotifications['warnings']) && !empty($dashboardNotifications['books']))
                        <hr class="notification-divider">
                        @endif

                        @if(!empty($dashboardNotifications['books']))
                        <div class="notification-menu-section">
                            <div class="notification-menu-section-title">Buku Terbaru</div>

                            @foreach($dashboardNotifications['books'] as $notification)
                            <form method="POST"
                                action="{{ route('dashboard.notifications.read', $notification['key']) }}"
                                class="notification-menu-form">
                                @csrf
                                <button type="submit" class="notification-menu-item notification-menu-button">
                                    <span class="notification-item-icon"
                                        style="background:{{ $notification['color'] }};"><i
                                            class="{{ $notification['icon'] }}"></i></span>
                                    <div class="notification-item-text">
                                        <strong>{{ $notification['title'] }}</strong>
                                        <p>{{ $notification['message'] }}</p>
                                    </div>
                                </button>
                            </form>
                            @endforeach
                        </div>
                        @endif

                        @if(empty($dashboardNotifications['warnings']) && empty($dashboardNotifications['books']))
                        <div class="notification-empty">Tidak ada notifikasi baru saat ini.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/buku') }}" class="stat-card" style="--accent-soft: rgba(47, 128, 237, 0.12);">
                <div class="stat-icon" style="background:#2f80ed;"><i class="bi bi-book"></i></div>
                <h3>{{ $total_buku }}</h3>
                <p>Total Buku</p>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/anggota') }}" class="stat-card" style="--accent-soft: rgba(39, 174, 96, 0.12);">
                <div class="stat-icon" style="background:#27ae60;"><i class="bi bi-people"></i></div>
                <h3>{{ $total_anggota }}</h3>
                <p>Total Anggota</p>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/kategori-buku') }}" class="stat-card" style="--accent-soft: rgba(155, 81, 224, 0.12);">
                <div class="stat-icon" style="background:#9b51e0;"><i class="bi bi-tags"></i></div>
                <h3>{{ $total_kategori }}</h3>
                <p>Total Kategori Buku</p>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/transaksi') }}" class="stat-card" style="--accent-soft: rgba(242, 153, 74, 0.14);">
                <div class="stat-icon" style="background:#f2994a;"><i class="bi bi-journal-arrow-up"></i></div>
                <h3>{{ $peminjaman_aktif }}</h3>
                <p>Peminjaman Aktif</p>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/pengembalian') }}" class="stat-card" style="--accent-soft: rgba(0, 166, 166, 0.12);">
                <div class="stat-icon" style="background:#00a6a6;"><i class="bi bi-journal-check"></i></div>
                <h3>{{ $pengembalian_buku }}</h3>
                <p>Pengembalian Buku</p>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/denda') }}" class="stat-card" style="--accent-soft: rgba(235, 87, 87, 0.12);">
                <div class="stat-icon" style="background:#eb5757;"><i class="bi bi-cash-coin"></i></div>
                <h3>Rp {{ number_format($total_denda, 0, ',', '.') }}</h3>
                <p>Total Denda</p>
            </a>
        </div>
    </div>

</div>

@endsection