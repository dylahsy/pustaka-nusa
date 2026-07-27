<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SIMPUS SMANES</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('templateperpus') }}/img/favicon.png" rel="icon">
    <link href="{{ asset('templateperpus') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Poppins&family=Raleway&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('templateperpus') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('templateperpus') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('templateperpus') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('templateperpus') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('templateperpus') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('templateperpus') }}/css/main.css" rel="stylesheet">

    <!-- Inline CSS untuk animasi -->
    <style>
    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .floating-image {
        width: 100%;
        animation: floating 3s ease-in-out infinite;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-placeholder {
        width: 104px;
        height: 104px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #35c2ff, #7c5cff);
        color: #fff;
        font-size: 38px;
        font-weight: 700;
        border: 5px solid rgba(255, 255, 255, 0.16);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22);
    }

    .profile-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding: 7px 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ffcf5c, #ff8a5c);
        color: #fff;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s;
    }

    .profile-action:hover {
        background: linear-gradient(135deg, #ffd86f, #ff6f61);
        color: #fff;
        transform: translateY(-2px);
    }

    #header {
        background: linear-gradient(180deg, rgba(20, 115, 160, 0.96) 0%, rgba(16, 58, 115, 0.98) 48%, rgba(50, 38, 105, 0.98) 100%),
        url('{{ asset('templateperpus/img/latar2.png') }}') center / cover;
        box-shadow: 10px 0 30px rgba(20, 80, 130, 0.16);
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, .38) transparent;
    }

    #header::-webkit-scrollbar {
        width: 7px;
    }

    #header::-webkit-scrollbar-track {
        background: transparent;
    }

    #header::-webkit-scrollbar-thumb {
        border-radius: 999px;
        background: rgba(255, 255, 255, .38);
    }

    #header::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, .58);
    }

    #header .profile-img {
        padding-top: 22px;
    }

    #header .profile-img img {
        width: 104px;
        height: 104px;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.16);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22);
    }

    #header .logo {
        color: #fff;
        text-decoration: none;
        margin-top: 14px;
        padding: 0 16px;
    }

    #header .sitename {
        font-size: 18px;
        line-height: 1.25;
        color: #fff;
        margin-bottom: 0;
    }

    .navmenu {
        padding: 8px 14px 24px;
    }

    .navmenu ul {
        gap: 6px;
    }

    .navmenu a,
    .navmenu a:focus {
        min-height: 44px;
        padding: 11px 14px;
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 14px;
        transition: 0.25s;
    }

    .navmenu a .navicon,
    .navmenu a:focus .navicon {
        width: 22px;
        color: rgba(255, 255, 255, 0.64);
        font-size: 17px;
        transition: 0.25s;
    }

    .navmenu a:hover,
    .navmenu .active,
    .navmenu .active:focus {
        background: rgba(255, 255, 255, 0.16);
        color: #fff;
    }

    .navmenu a:hover .navicon,
    .navmenu .active .navicon,
    .navmenu .active:focus .navicon {
        color: #67c8ff;
    }

    .navmenu .active {
        box-shadow: inset 3px 0 0 #ffcf5c;
    }

    .navmenu .dropdown>a {
        cursor: pointer;
    }

    .navmenu .dropdown>a .toggle-dropdown {
        margin-left: auto;
        padding: 8px;
        border-radius: 999px;
        background: rgba(0, 0, 0, .08);
    }

    .navmenu .dropdown ul {
        margin: 6px 0 8px 10px;
        padding: 6px;
        background: rgba(255, 255, 255, 0.09);
        border-left: 1px solid rgba(255, 207, 92, 0.48);
        border-radius: 12px;
    }

    .navmenu .dropdown ul a {
        min-height: 38px;
        padding: 9px 12px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.72);
    }

    .navmenu .dropdown ul a:hover {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
    }

    .logout-form {
        margin: 0;
    }

    .logout-link {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 11px 14px;
        border: 0;
        border-radius: 12px;
        background: transparent;
        color: rgba(255, 255, 255, 0.78);
        font: inherit;
        font-size: 14px;
        text-align: left;
        text-decoration: none;
        transition: 0.25s;
        cursor: pointer;
    }

    .logout-link:hover {
        background: rgba(255, 255, 255, 0.16);
        color: #fff;
    }

    .logout-link .navicon {
        width: 22px;
        color: rgba(255, 255, 255, 0.64);
        font-size: 17px;
        transition: 0.25s;
    }

    .logout-link:hover .navicon {
        color: #67c8ff;
    }

    body {
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(241, 248, 255, 0.94), rgba(232, 245, 239, 0.9) 46%, rgba(255, 248, 226, 0.88)),
        url('{{ asset('templateperpus/img/latar1.png') }}') center / cover fixed !important;
        color: #1f2937;
        font-family: "Poppins", "Roboto", sans-serif;
    }

    .main {
        min-height: 100vh;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.55), rgba(245, 250, 255, 0.78));
    }

    .page-zoom-toolbar {
        position: fixed;
        right: 18px;
        bottom: 72px;
        z-index: 90;
    }

    .page-zoom-controls {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: center;
    }

    .page-zoom-btn {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #d9e3ef;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.96);
        color: #17324d;
        font-size: 18px;
        font-weight: 700;
        box-shadow: 0 10px 22px rgba(31, 75, 112, 0.14);
        backdrop-filter: blur(8px);
        transition: 0.2s ease;
    }

    .page-zoom-btn:hover {
        background: #edf4fb;
        transform: translateY(-1px);
    }

    .page-zoom-surface {
        width: 100%;
        min-width: 0;
        transform-origin: top left;
    }

    @media print {
        .page-zoom-toolbar {
            display: none !important;
        }

        .page-zoom-surface {
            transform: none !important;
            width: 100% !important;
        }
    }

    .admin-page,
    .data-page,
    .simpus-page {
        padding: 34px !important;
    }

    .admin-header,
    .data-header,
    .simpus-header {
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 16px !important;
        margin-bottom: 22px !important;
    }

    .admin-title h2,
    .data-title h2,
    .simpus-title h2 {
        margin: 0 !important;
        color: #17324d !important;
        font-size: 28px !important;
        font-weight: 800 !important;
    }

    .admin-title p,
    .data-title p,
    .simpus-title p {
        margin: 7px 0 0 !important;
        color: #5e7188 !important;
        font-size: 14px !important;
    }

    .btn-add-admin,
    .btn-add,
    .simpus-btn-primary {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        min-height: 34px !important;
        padding: 7px 12px !important;
        border: 0 !important;
        border-radius: 7px !important;
        background: linear-gradient(135deg, #0ea5e9, #2563eb) !important;
        color: #fff !important;
        text-decoration: none !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        white-space: nowrap !important;
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.18) !important;
        transition: 0.25s !important;
    }

    .btn-add-admin:hover,
    .btn-add:hover,
    .simpus-btn-primary:hover {
        color: #fff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 9px 18px rgba(37, 99, 235, 0.24) !important;
    }

    .admin-table-wrap,
    .table-wrap,
    .simpus-table-wrap {
        width: 100% !important;
        overflow-x: auto !important;
        background: rgba(255, 255, 255, 0.96) !important;
        border: 1px solid rgba(154, 184, 215, 0.7) !important;
        border-radius: 8px !important;
        box-shadow: 0 18px 42px rgba(31, 75, 112, 0.13) !important;
    }

    .admin-table,
    .data-table,
    .simpus-table {
        width: 100% !important;
        min-width: 1080px;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .admin-table thead th,
    .data-table thead th,
    .simpus-table thead th {
        padding: 17px 18px !important;
        background: linear-gradient(180deg, #eaf6ff, #dbeafe) !important;
        color: #17324d !important;
        font-size: 13px !important;
        font-weight: 800 !important;
        text-align: center !important;
        border-bottom: 2px solid #9fc1e6 !important;
        border-right: 1px solid #cbdff3 !important;
        letter-spacing: 0 !important;
    }

    .admin-table tbody td,
    .data-table tbody td,
    .simpus-table tbody td {
        padding: 17px 18px !important;
        color: #26384d !important;
        font-size: 14px !important;
        text-align: center !important;
        vertical-align: middle !important;
        line-height: 1.55 !important;
        border-bottom: 1px solid #dce9f6 !important;
        border-right: 1px solid #dce9f6 !important;
    }

    .admin-table tbody tr:nth-child(odd),
    .data-table tbody tr:nth-child(odd),
    .simpus-table tbody tr:nth-child(odd) {
        background: #ffffff !important;
    }

    .admin-table tbody tr:nth-child(even),
    .data-table tbody tr:nth-child(even),
    .simpus-table tbody tr:nth-child(even) {
        background: #f3f9ff !important;
    }

    .admin-table tbody tr:hover,
    .data-table tbody tr:hover,
    .simpus-table tbody tr:hover {
        background: #e4f3ff !important;
    }

    .action-group {
        display: inline-flex !important;
        gap: 6px !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .action-btn {
        width: 34px !important;
        height: 34px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        border: 1px solid #cbdff3 !important;
        background: #fff !important;
        color: #2563eb !important;
        transition: 0.2s !important;
    }

    .action-btn:hover {
        background: #eff6ff !important;
        color: #1d4ed8 !important;
    }

    .action-btn.delete {
        color: #dc2626 !important;
    }

    .action-btn.delete:hover {
        background: #fee2e2 !important;
        border-color: #fecaca !important;
    }

    .action-btn.disabled {
        cursor: not-allowed !important;
        opacity: 0.45 !important;
        color: #94a3b8 !important;
        background: #f8fafc !important;
    }

    .current-admin-row {
        box-shadow: inset 4px 0 0 #f59e0b !important;
    }

    .current-badge {
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        margin-left: 6px !important;
        padding: 4px 8px !important;
        border-radius: 999px !important;
        background: #fef3c7 !important;
        color: #92400e !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        vertical-align: middle !important;
    }

    .status-badge {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 82px !important;
        padding: 5px 10px !important;
        border-radius: 999px !important;
        font-size: 12px !important;
        font-weight: 800 !important;
    }

    .status-active {
        background: #dcfce7 !important;
        color: #166534 !important;
    }

    .status-inactive {
        background: #fee2e2 !important;
        color: #991b1b !important;
    }

    .status-warning {
        background: #fef3c7 !important;
        color: #92400e !important;
    }

    .empty-row {
        padding: 28px !important;
        color: #6b7280 !important;
        text-align: center !important;
    }

    .pagination-wrap {
        margin-top: 18px !important;
    }

    .simpus-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(154, 184, 215, 0.72);
        border-radius: 8px;
        box-shadow: 0 18px 42px rgba(31, 75, 112, 0.13);
    }

    .report-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .laporan-link {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        min-height: 74px !important;
        padding: 18px !important;
        border: 1px solid #cbdff3 !important;
        border-radius: 8px !important;
        background: linear-gradient(135deg, #ffffff, #eff8ff) !important;
        color: #17324d !important;
        text-decoration: none !important;
        font-weight: 800 !important;
        transition: 0.25s !important;
    }

    .laporan-link:hover {
        background: linear-gradient(135deg, #dff3ff, #fff7dc) !important;
        color: #17324d !important;
        transform: translateY(-1px) !important;
    }

    .simpus-search-form {
        display: flex;
        gap: 7px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .simpus-search-form input {
        width: min(420px, 100%);
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        padding: 7px 10px;
        font-size: 13px;
    }

    .simpus-search-form select {
        min-width: 190px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        padding: 7px 10px;
        font-size: 13px;
        background: #fff;
        color: #1f2937;
    }

    .simpus-search-form.simpus-search-form-inline {
        align-items: center;
        flex-wrap: nowrap;
    }

    .simpus-search-form.simpus-search-form-inline input {
        flex: 1 1 360px;
        width: auto;
        max-width: none;
    }

    .simpus-search-form.simpus-search-form-inline select.simpus-select-arrow {
        flex: 0 0 190px;
        min-width: 190px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 30px;
        background-image:
            linear-gradient(45deg, transparent 50%, #56708a 50%),
            linear-gradient(135deg, #56708a 50%, transparent 50%);
        background-position:
            calc(100% - 15px) 54%,
            calc(100% - 9px) 54%;
        background-size: 6px 6px, 6px 6px;
        background-repeat: no-repeat;
    }

    .simpus-search-form.simpus-search-form-inline button,
    .simpus-search-form.simpus-search-form-inline a {
        white-space: nowrap;
    }

    .simpus-search-form button,
    .simpus-search-form a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 0;
        border-radius: 7px;
        padding: 7px 11px;
        min-height: 34px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .simpus-search-form button {
        background: #2563eb;
        color: #fff;
    }

    .simpus-search-form a {
        background: #e5e7eb;
        color: #374151;
    }

    /* Shared create/edit form surface ----------------------------------- */
    body {
        padding-top: 0 !important;
    }

    .page-zoom-surface>.container {
        width: 100%;
        max-width: 1180px;
        padding: 34px 24px 46px;
    }

    .page-zoom-surface>.container>.row {
        margin-right: 0;
        margin-left: 0;
    }

    .page-zoom-surface>.container>.row>[class*="col-"] {
        width: 100%;
        max-width: 1060px;
        flex: 0 0 100%;
        padding-right: 0;
        padding-left: 0;
    }

    .page-zoom-surface>.container>.row>[class*="col-"]>.card,
    .page-zoom-surface>.container>.row>[class*="col-"]>.form-card {
        overflow: hidden;
        margin-top: 0 !important;
        background: rgba(255, 255, 255, 0.97) !important;
        border: 1px solid rgba(154, 184, 215, 0.72) !important;
        border-radius: 16px !important;
        box-shadow: 0 18px 42px rgba(31, 75, 112, 0.14) !important;
    }

    .page-zoom-surface .card-header,
    .page-zoom-surface .form-card .card-header {
        min-height: 58px;
        display: flex;
        align-items: center;
        padding: 15px 20px !important;
        background: linear-gradient(135deg, #eaf6ff, #dbeafe) !important;
        color: #17324d !important;
        border-bottom: 1px solid #b8d2ed !important;
        font-size: 20px;
        font-weight: 800 !important;
    }

    .page-zoom-surface .card-body {
        padding: 26px 20px !important;
        background: rgba(255, 255, 255, 0.97) !important;
    }

    .page-zoom-surface .card-body .row {
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0.5rem;
    }

    .page-zoom-surface .form-group {
        margin-bottom: 20px !important;
    }

    .page-zoom-surface .card-body>.form-group:last-child,
    .page-zoom-surface .card-body .row:last-child>[class*="col-"]:last-child .form-group {
        margin-bottom: 0 !important;
    }

    .page-zoom-surface .form-label {
        margin-bottom: 7px;
        color: #26384d;
        font-size: 15px;
        font-weight: 600;
    }

    .page-zoom-surface .form-control,
    .page-zoom-surface .form-select,
    .page-zoom-surface .photo-file-control {
        min-height: 44px;
        border: 1px solid #cbd9e8;
        border-radius: 9px;
        background-color: #fff;
        color: #26384d;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .page-zoom-surface .form-control,
    .page-zoom-surface .form-select {
        padding: 9px 13px;
    }

    .page-zoom-surface .form-control:focus,
    .page-zoom-surface .form-select:focus,
    .page-zoom-surface .photo-file-control:focus-within {
        border-color: #54a9e8;
        box-shadow: 0 0 0 3px rgba(84, 169, 232, .16);
    }

    .page-zoom-surface .form-control:disabled,
    .page-zoom-surface .form-control[readonly],
    .page-zoom-surface .bg-light {
        background-color: #f3f7fb !important;
        color: #64748b;
    }

    /* Dropdown yang dapat dicari --------------------------------------- */
    .searchable-select {
        position: relative;
    }

    .searchable-select-native {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        margin: -1px !important;
        padding: 0 !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important;
    }

    .searchable-select-input {
        width: 100%;
        padding-right: 42px !important;
        background-image:
            linear-gradient(45deg, transparent 50%, #56708a 50%),
            linear-gradient(135deg, #56708a 50%, transparent 50%) !important;
        background-position:
            calc(100% - 18px) 54%,
            calc(100% - 12px) 54% !important;
        background-size: 6px 6px, 6px 6px !important;
        background-repeat: no-repeat !important;
    }

    .searchable-select-menu {
        position: absolute;
        z-index: 1050;
        top: calc(100% + 4px);
        right: 0;
        left: 0;
        display: none;
        max-height: 240px;
        overflow-y: auto;
        padding: 5px;
        border: 1px solid #b8d2ed;
        border-radius: 9px;
        background: #fff;
        box-shadow: 0 12px 24px rgba(31, 75, 112, .18);
    }

    .searchable-select.open .searchable-select-menu {
        display: block;
    }

    .searchable-select-option,
    .searchable-select-empty {
        width: 100%;
        display: block;
        padding: 9px 11px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #26384d;
        font: inherit;
        font-size: 14px;
        text-align: left;
    }

    .searchable-select-option {
        cursor: pointer;
    }

    .searchable-select-option:hover,
    .searchable-select-option.is-active {
        background: #eaf6ff;
    }

    .searchable-select-option.is-selected {
        color: #1d4ed8;
        font-weight: 700;
    }

    .searchable-select-empty {
        color: #64748b;
        cursor: default;
    }

    .page-zoom-surface .form-note,
    .page-zoom-surface .text-muted {
        color: #64748b !important;
        font-size: 12px;
    }

    .page-zoom-surface .card-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 20px !important;
        background: #f8fbff !important;
        border-top: 1px solid #d8e5f2 !important;
    }

    .page-zoom-surface .card-footer .btn {
        min-height: 42px;
        padding: 9px 16px;
        border: 0;
        border-radius: 9px;
        font-weight: 700;
    }

    .page-zoom-surface .card-footer .btn-secondary {
        background: #64748b;
        color: #fff;
    }

    .page-zoom-surface .card-footer .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #fff;
        box-shadow: 0 6px 14px rgba(37, 99, 235, .18);
    }

    .page-zoom-surface .card-footer .btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.04);
    }

    @media (max-width: 768px) {

        .admin-page,
        .data-page,
        .simpus-page {
            padding: 22px 16px !important;
        }

        .admin-header,
        .data-header,
        .simpus-header {
            flex-direction: column !important;
        }

        .btn-add-admin,
        .btn-add,
        .simpus-btn-primary {
            width: 100% !important;
        }

        .simpus-search-form.simpus-search-form-inline {
            flex-direction: column;
            align-items: stretch;
        }

        .simpus-search-form.simpus-search-form-inline input,
        .simpus-search-form.simpus-search-form-inline select,
        .simpus-search-form.simpus-search-form-inline button,
        .simpus-search-form.simpus-search-form-inline a {
            width: 100%;
            flex: 1 1 auto;
            min-width: 0;
        }

        .report-grid {
            grid-template-columns: 1fr;
        }

        .page-zoom-surface>.container {
            padding: 22px 16px 34px;
        }

        .page-zoom-surface .card-body,
        .page-zoom-surface .card-footer {
            padding-left: 16px !important;
            padding-right: 16px !important;
        }
    }
    </style>
</head>

<body>
    @php
    $currentRole = auth()->user()?->role;
    $isOperator = in_array($currentRole, ['Admin', 'Kepala Perpustakaan'], true);
    $isReportPage = request()->is('laporan') || request()->is('*/laporan/cetak');
    $dataMenuOpen = ! $isReportPage && (request()->is('admin*') || request()->is('anggota*') || request()->is('buku*')
    || request()->is('kategori-buku*'));
    $transactionMenuOpen = ! $isReportPage && (request()->is('transaksi*') || request()->is('pengembalian*') ||
    request()->is('denda*'));
    $pageZoomKey = request()->route()?->getName() ?: request()->path();
    @endphp

    <!-- Header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <i class="header-toggle d-xl-none bi bi-list"></i>

        <div class="profile-img text-center">
            @auth
            @if(Auth::user()->profile_photo_path)
            <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Foto profil {{ Auth::user()->name }}"
                class="img-fluid rounded-circle">
            @else
            <div class="profile-placeholder">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            @endif

            @else
            <div class="profile-placeholder">?</div>
            @endauth
        </div>

        <div class="logo d-flex align-items-center justify-content-center">
            <div class="text-center mt-7">
                <h1 class="sitename">
                    @auth

                    <strong>{{ Auth::user()->name }} </strong>
                    @else
                    @endauth
                </h1>
                @auth
                @if(auth()->check())
                <a href="{{ route('profile.edit') }}" class="profile-action">
                    <i class="bi bi-person-circle"></i>
                    Profil Saya
                </a>
                @endif
                @endauth
            </div>
        </div>
        <br>
        <!-- Nav -->
        <nav id="navmenu" class="navmenu">
            <ul>
                @if($isOperator)
                <li><a href="{{ url('/home') }}" class="{{ request()->is('home') ? 'active' : '' }}"><i
                            class="bi bi-house navicon"></i> Dashboard</a></li>
                <li><a href="{{ route('informasi.buku') }}"
                        class="{{ request()->is('informasi-buku') ? 'active' : '' }}"><i
                            class="bi bi-journal-bookmark navicon"></i> Informasi Buku</a></li>
                <li class="dropdown">
                    <a href="#"
                        class="{{ ! $isReportPage && (request()->is('admin') || request()->is('anggota*') || request()->is('buku*') || request()->is('kategori-buku*')) ? 'active' : '' }}">
                        <i class="bi bi-folder navicon"></i> <span>Data</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul class="{{ $dataMenuOpen ? 'dropdown-active' : '' }}">
                        <li><a href="{{ url('/admin') }}" class="{{ request()->is('admin') ? 'active' : '' }}">Data
                                Admin</a></li>
                        <li><a href="{{ url('/anggota') }}" class="{{ request()->is('anggota*') ? 'active' : '' }}">Data
                                Anggota</a></li>
                        <li><a href="{{ url('/buku') }}" class="{{ request()->is('buku*') ? 'active' : '' }}">Data
                                Buku</a></li>
                        <li><a href="{{ url('/kategori-buku') }}"
                                class="{{ request()->is('kategori-buku*') ? 'active' : '' }}">Data Kategori Buku</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#"
                        class="{{ ! $isReportPage && (request()->is('transaksi*') || request()->is('pengembalian*') || request()->is('denda*')) ? 'active' : '' }}">
                        <i class="bi bi-arrow-left-right navicon"></i> <span>Transaksi</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul class="{{ $transactionMenuOpen ? 'dropdown-active' : '' }}">
                        <li><a href="{{ url('/transaksi') }}"
                                class="{{ request()->is('transaksi*') ? 'active' : '' }}">Peminjaman Buku</a></li>
                        <li><a href="{{ url('/pengembalian') }}"
                                class="{{ request()->is('pengembalian*') ? 'active' : '' }}">Pengembalian Buku</a></li>
                        <li><a href="{{ url('/denda') }}"
                                class="{{ request()->is('denda*') ? 'active' : '' }}">Denda</a></li>
                    </ul>
                </li>

                <li><a href="{{ url('/laporan') }}" class="{{ $isReportPage ? 'active' : '' }}"><i
                            class="bi bi-file-earmark-text navicon"></i> Laporan</a></li>
                @else
                <li><a href="{{ route('informasi.buku') }}"
                        class="{{ request()->is('informasi-buku') ? 'active' : '' }}"><i
                            class="bi bi-journal-bookmark navicon"></i> Informasi Buku</a></li>
                @endif

                <li>
                    <a href="{{ route('logout.get') }}" class="logout-link">
                        <i class="bi bi-box-arrow-right navicon"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <!-- End Header -->

    <!-- Content -->
    <main class="main">
        <div class="page-zoom-toolbar">
            <div class="page-zoom-controls" data-page-zoom-controls data-zoom-key="{{ $pageZoomKey }}">
                <button type="button" class="page-zoom-btn" data-zoom-out aria-label="Perkecil tampilan">
                    <i class="bi bi-zoom-out"></i>
                </button>
                <button type="button" class="page-zoom-btn" data-zoom-in aria-label="Perbesar tampilan">
                    <i class="bi bi-zoom-in"></i>
                </button>
            </div>
        </div>

        <div class="page-zoom-surface" id="page-zoom-surface">
            @yield('content')
        </div>
    </main>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('templateperpus') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/typed.js/typed.umd.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('templateperpus') }}/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('templateperpus') }}/js/main.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const surface = document.getElementById('page-zoom-surface');
        const controls = document.querySelector('[data-page-zoom-controls]');

        if (!surface || !controls) {
            return;
        }

        const zoomOutButton = controls.querySelector('[data-zoom-out]');
        const zoomInButton = controls.querySelector('[data-zoom-in]');
        const storageKey = 'simpus-page-zoom:' + (controls.dataset.zoomKey || 'default');
        const minZoom = 0.8;
        const maxZoom = 1.4;
        const step = 0.1;
        let currentZoom = 1;

        const clampZoom = (value) => {
            const rounded = Math.round(value * 100) / 100;
            return Math.min(maxZoom, Math.max(minZoom, rounded));
        };

        const readStoredZoom = () => {
            try {
                const storedValue = window.localStorage.getItem(storageKey);
                if (!storedValue) {
                    return 1;
                }

                const parsedValue = parseFloat(storedValue);
                return Number.isFinite(parsedValue) ? parsedValue : 1;
            } catch (error) {
                return 1;
            }
        };

        const applyZoom = (value, persist = true) => {
            currentZoom = clampZoom(value);
            surface.style.transform = 'scale(' + currentZoom + ')';
            surface.style.width = (100 / currentZoom).toFixed(4).replace(/\.?0+$/, '') + '%';

            if (persist) {
                try {
                    window.localStorage.setItem(storageKey, String(currentZoom));
                } catch (error) {
                    // Local storage may be unavailable in some browser modes.
                }
            }
        };

        applyZoom(readStoredZoom(), false);

        if (zoomOutButton) {
            zoomOutButton.addEventListener('click', function() {
                applyZoom(currentZoom - step);
            });
        }

        if (zoomInButton) {
            zoomInButton.addEventListener('click', function() {
                applyZoom(currentZoom + step);
            });
        }

        window.addEventListener('beforeprint', function() {
            surface.style.transform = 'none';
            surface.style.width = '100%';
        });

        window.addEventListener('afterprint', function() {
            applyZoom(readStoredZoom(), false);
        });
    });
    </script>

    <script>
    // Samakan pesan validasi browser untuk semua kolom wajib pada formulir SIMPUS.
    document.addEventListener('invalid', function(event) {
        const field = event.target;
        if (field.matches('input[required], select[required], textarea[required]') && field.validity
            .valueMissing) {
        field.setCustomValidity('Harap isi kolom ini.');
        }
    }, true);

    document.addEventListener('input', function(event) {
        if (event.target.matches('input[required], textarea[required]')) {
            event.target.setCustomValidity('');
        }
    });

    document.addEventListener('change', function(event) {
        if (event.target.matches('select[required], input[type="file"][required]')) {
            event.target.setCustomValidity('');
        }
    });
    </script>

    <script>
    // Jadikan seluruh dropdown biasa dapat dicari dengan mengetikkan kata kunci.
    document.addEventListener('DOMContentLoaded', function() {
        const normalise = function(value) {
            return value.toLocaleLowerCase('id-ID').trim();
        };

        document.querySelectorAll('select:not([multiple]):not([data-searchable-ready])').forEach(function(
            select) {
            if (select.disabled || select.size > 1) return;

            const wrapper = document.createElement('div');
            wrapper.className = 'searchable-select';
            select.parentNode.insertBefore(wrapper, select);
            wrapper.appendChild(select);
            select.dataset.searchableReady = 'true';
            select.classList.add('searchable-select-native');

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control searchable-select-input';
            input.autocomplete = 'off';
            input.placeholder = select.options[0] && !select.options[0].value ? select.options[0].text
                .trim() : ' - Pilih Kategori -';
            input.setAttribute('role', 'combobox');

            input.setAttribute('aria-autocomplete', 'list');
            input.setAttribute('aria-expanded', 'false');

            if (select.required) {
                input.required = true;
                select.required = false;
            }

            if (select.classList.contains('form-select')) input.classList.add('form-select');
            if (select.classList.contains('form-control')) input.classList.add('form-control');

            const menu = document.createElement('div');
            menu.className = 'searchable-select-menu';
            menu.setAttribute('role', 'listbox');
            wrapper.append(input, menu);

            const usePortalMenu = select.hasAttribute('data-searchable-portal');

            let activeIndex = -1;
            const options = Array.from(select.options).filter(function(option) {
                return !option.disabled && option.value !== '';
            });

            const selectedOption = function() {
                return options.find(function(option) {
                    return option.selected;
                });
            };

            const render = function() {
                const selected = selectedOption();
                const query = document.activeElement === input && selected && input.value ===
                    selected.text.trim() ?
                    '' :
                    normalise(input.value);
                const visibleOptions = options.filter(function(option) {
                    return normalise(option.text).includes(query);
                });
                menu.innerHTML = '';
                activeIndex = -1;

                if (!visibleOptions.length) {
                    const empty = document.createElement('div');
                    empty.className = 'searchable-select-empty';
                    empty.textContent = 'Pilihan tidak ditemukan.';
                    menu.appendChild(empty);
                    return visibleOptions;
                }

                visibleOptions.forEach(function(option) {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'searchable-select-option' + (option.selected ?
                        ' is-selected' : '');
                    item.textContent = option.text.trim();
                    item.dataset.value = option.value;
                    item.addEventListener('mousedown', function(event) {
                        event.preventDefault();
                        choose(option);
                    });
                    menu.appendChild(item);
                });
                return visibleOptions;
            };

            const placePortalMenu = function() {
                if (!usePortalMenu) return;

                const inputBounds = input.getBoundingClientRect();
                document.body.appendChild(menu);
                Object.assign(menu.style, {
                    position: 'fixed',
                    top: (inputBounds.bottom + 4) + 'px',
                    right: 'auto',
                    left: inputBounds.left + 'px',
                    width: inputBounds.width + 'px',
                    zIndex: '9999',
                    display: 'block',
                });
            };

            const restorePortalMenu = function() {
                if (!usePortalMenu || menu.parentNode === wrapper) return;

                wrapper.appendChild(menu);
                menu.style.position = '';
                menu.style.top = '';
                menu.style.right = '';
                menu.style.left = '';
                menu.style.width = '';
                menu.style.zIndex = '';
                menu.style.display = '';
            };

            const setOpen = function(open) {
                wrapper.classList.toggle('open', open);
                input.setAttribute('aria-expanded', String(open));
                if (open) {
                    placePortalMenu();
                    render();
                } else {
                    restorePortalMenu();
                }
            };

            const choose = function(option) {
                select.value = option.value;
                input.value = option.text.trim();
                input.setCustomValidity('');
                setOpen(false);
                select.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            };

            const syncFromSelect = function() {
                const option = selectedOption();
                input.value = option ? option.text.trim() : '';
                input.setCustomValidity('');
            };

            syncFromSelect();
            select.addEventListener('change', syncFromSelect);

            input.addEventListener('focus', function() {
                setOpen(true);
            });
            input.addEventListener('click', function() {
                setOpen(true);
            });
            input.addEventListener('input', function() {
                select.value = '';
                input.setCustomValidity(input.value ?
                    'Pilih salah satu pilihan yang tersedia.' : '');
                setOpen(true);
            });
            input.addEventListener('keydown', function(event) {
                const visibleOptions = Array.from(menu.querySelectorAll(
                    '.searchable-select-option'));
                if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                    event.preventDefault();
                    setOpen(true);
                    activeIndex = event.key === 'ArrowDown' ?
                        Math.min(activeIndex + 1, visibleOptions.length - 1) :
                        Math.max(activeIndex - 1, 0);
                    visibleOptions.forEach(function(item, index) {
                        item.classList.toggle('is-active', index === activeIndex);
                    });
                    visibleOptions[activeIndex]?.scrollIntoView({
                        block: 'nearest'
                    });
                }
                if (event.key === 'Enter' && activeIndex >= 0 && visibleOptions[activeIndex]) {
                    event.preventDefault();
                    const option = options.find(function(option) {
                        return option.value === visibleOptions[activeIndex].dataset
                            .value;
                    });
                    if (option) choose(option);
                }
                if (event.key === 'Escape') setOpen(false);
            });

            document.addEventListener('click', function(event) {
                if (!wrapper.contains(event.target) && !menu.contains(event.target)) setOpen(false);
            });

            window.addEventListener('scroll', function(event) {
                // Jangan hitung ulang posisi ketika yang digulir adalah daftar pilihan.
                if (menu.contains(event.target)) return;
                if (usePortalMenu && wrapper.classList.contains('open')) placePortalMenu();
            }, true);
            window.addEventListener('resize', function() {
                if (usePortalMenu && wrapper.classList.contains('open')) placePortalMenu();
            });
        });
    });
    </script>

</body>

</html>
