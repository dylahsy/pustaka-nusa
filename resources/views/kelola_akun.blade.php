@extends('layouts.perpus')

@section('content')
@php
    $nomorAnggota = filled($user->nis_nip) ? trim((string) $user->nis_nip) : '-';
    $profilePhoto = filled($user->profile_photo_path) && file_exists(public_path($user->profile_photo_path))
        ? asset($user->profile_photo_path)
        : null;
    $profileInitial = strtoupper(substr($user->name ?: 'U', 0, 1));
    $profileJenis = $user->jenis_anggota ?? $user->role ?? '-';
    $profileKelas = data_get($user, 'kelas');
    $profileGender = data_get($user, 'jenis_kelamin');
    $profileAlamat = data_get($user, 'alamat');
    $selectedGender = old('jenis_kelamin', $user->jenis_kelamin);
    $genderOptions = ['Laki-laki', 'Perempuan'];
    $profileCardRows = [
        ['label' => 'NIS/NIP', 'value' => $nomorAnggota],
        ['label' => 'Nama', 'value' => $user->name ?: '-'],
        ['label' => 'Jenis', 'value' => $profileJenis ?: '-'],
    ];

    if ($profileJenis === 'Siswa' || filled($profileKelas)) {
        $profileCardRows[] = ['label' => 'Kelas', 'value' => $profileKelas ?: '-'];
    }

    $profileCardRows[] = ['label' => 'Jenis Kelamin', 'value' => $profileGender ?: '-'];
    $profileCardRows[] = ['label' => 'No. HP', 'value' => $user->no_hp ?: '-'];
    $profileCardRows[] = ['label' => 'Alamat', 'value' => $profileAlamat ?: '-', 'class' => 'address-value'];

    $anggotaCard = [
        'title_top' => 'Kartu Tanda Anggota Perpustakaan',
        'title_bottom' => 'SMA Negeri 9 Kota Jambi',
        'rows' => $profileCardRows,
        'photo' => $profilePhoto,
        'photo_alt' => 'Foto profil ' . ($user->name ?: 'pengguna'),
        'initial' => $profileInitial,
        'note' => 'Kartu ini dapat digunakan untuk administrasi perpustakaan dan wajib dibawa saat peminjaman.',
        'photo_slot_id' => 'profile-card-photo-slot',
    ];

    $currentRole = $user->role ?? 'Pengguna';
    $canUseAnggotaCard = $currentRole === 'Anggota';
    $isStaff = in_array($currentRole, ['Admin', 'Kepala Perpustakaan'], true);
    $profileInfoRows = $isStaff ? [
        ['label' => 'Nama Lengkap', 'value' => $user->name ?: '-'],
        ['label' => 'Jabatan', 'value' => $currentRole],
        ['label' => 'NIP', 'value' => $nomorAnggota],
        ['label' => 'Email', 'value' => $user->email ?: '-'],
        ['label' => 'No. HP', 'value' => $user->no_hp ?: '-'],
        ['label' => 'Alamat', 'value' => $profileAlamat ?: '-'],
        ['label' => 'Tanggal Bergabung', 'value' => optional($user->created_at)->format('d/m/Y') ?? '-'],
    ] : [
        ['label' => 'Nama Lengkap', 'value' => $user->name ?: '-'],
        ['label' => 'NIS/NIP', 'value' => $nomorAnggota],
        ['label' => 'Email', 'value' => $user->email ?: '-'],
        ['label' => 'No. HP', 'value' => $user->no_hp ?: '-'],
        ['label' => 'Alamat', 'value' => $profileAlamat ?: '-'],
        ['label' => 'Tanggal Bergabung', 'value' => optional($user->created_at)->format('d/m/Y') ?? '-'],
    ];
    $profileCardReady = $profileCardComplete ?? false;
    $missingProfileCard = $profileCardMissing ?? [];
@endphp

@include('partials.anggota_card_styles')

<style>
  .account-page {
    min-height: 100vh;
    padding: 32px;
    background: linear-gradient(135deg, #eef6ff, #f7f2ff 55%, #ffffff);
  }

  .account-shell {
    max-width: 1180px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 250px minmax(0, 1fr);
    gap: 18px;
  }

  .account-nav,
  .account-panel {
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid #d7e4f5;
    border-radius: 12px;
    box-shadow: 0 16px 34px rgba(31, 75, 112, 0.12);
  }

  .account-nav {
    position: sticky;
    top: 18px;
    align-self: start;
    padding: 18px;
  }

  .account-avatar {
    width: 86px;
    height: 86px;
    border-radius: 50%;
    overflow: hidden;
    display: grid;
    place-items: center;
    margin: 0 auto 10px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: #fff;
    font-size: 32px;
    font-weight: 800;
    border: 4px solid #fff;
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
  }

  .account-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .account-nav h2 {
    margin: 0;
    font-size: 18px;
    font-weight: 800;
    color: #17324d;
    text-align: center;
  }

  .account-nav p {
    margin: 4px 0 16px;
    font-size: 12px;
    color: #64748b;
    text-align: center;
    overflow-wrap: anywhere;
  }

  .account-menu {
    display: grid;
    gap: 7px;
  }

  .account-menu a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 10px;
    border-radius: 7px;
    color: #334155;
    text-decoration: none;
    font-size: 13px;
    font-weight: 800;
  }

  .account-menu a:hover {
    background: #eff6ff;
    color: #1d4ed8;
  }

  .account-menu form {
    margin: 0;
  }

  .account-menu button {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 10px;
    border: 0;
    border-radius: 7px;
    background: transparent;
    color: #334155;
    font: inherit;
    font-size: 13px;
    font-weight: 800;
    text-align: left;
    cursor: pointer;
  }

  .account-menu button:hover {
    background: #eff6ff;
    color: #1d4ed8;
  }

  .account-content {
    display: grid;
    gap: 18px;
  }

  .account-panel {
    padding: 22px;
    scroll-margin-top: 24px;
  }

  .panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #dce9f6;
  }

  .panel-head h3 {
    margin: 0;
    color: #17324d;
    font-size: 20px;
    font-weight: 900;
  }

  .panel-head span {
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
  }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 18px;
  }

  .info-item {
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    padding: 10px 12px;
    background: #f8fafc;
  }

  .info-item label {
    display: block;
    color: #64748b;
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 3px;
  }

  .info-item strong {
    color: #111827;
    font-size: 14px;
    font-weight: 900;
    overflow-wrap: anywhere;
  }

  .profile-summary {
    margin-bottom: 18px;
    border: 1px solid #dce9f6;
    border-radius: 14px;
    background:
      radial-gradient(circle at 92% 10%, rgba(124, 58, 237, 0.08) 0, transparent 20%),
      radial-gradient(circle at 6% 88%, rgba(37, 99, 235, 0.08) 0, transparent 18%),
      linear-gradient(135deg, rgba(255,255,255,0.98), rgba(239,246,255,0.94));
    overflow: hidden;
  }

  .profile-summary > summary {
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 14px 16px;
    cursor: pointer;
    user-select: none;
  }

  .profile-summary > summary::-webkit-details-marker {
    display: none;
  }

  .profile-summary-title {
    display: grid;
    gap: 2px;
  }

  .profile-summary-title strong {
    color: #17324d;
    font-size: 16px;
    font-weight: 900;
  }

  .profile-summary-title span {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
  }

  .profile-summary > summary::after {
    content: "\f282";
    font-family: "bootstrap-icons";
    color: #1d4ed8;
    font-size: 18px;
    transition: transform 0.2s ease;
  }

  .profile-summary[open] > summary::after {
    transform: rotate(180deg);
  }

  .profile-summary-body {
    padding: 0 16px 16px;
  }

  .profile-summary-body .info-grid {
    margin-bottom: 0;
  }

  .profile-edit-grid {
    margin-top: 8px;
    padding: 16px;
    border: 1px solid #dce9f6;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(255,255,255,0.96), rgba(239,246,255,0.92));
  }

  .profile-edit-head {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #ddeaf8;
  }

  .profile-edit-head strong {
    color: #17324d;
    font-size: 15px;
    font-weight: 900;
  }

  .profile-edit-head span {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
  }

  .profile-edit-grid .form-label {
    color: #17324d;
    font-weight: 800;
  }

  .profile-edit-grid .form-control {
    border-color: #cfe0f3;
    background: #fff;
    box-shadow: none;
  }

  .profile-edit-grid .form-select {
    border-color: #cfe0f3;
    background-color: #fff;
    box-shadow: none;
  }

  .profile-edit-grid .form-select:focus {
    border-color: rgba(37, 99, 235, 0.45);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
  }

  .profile-edit-grid .form-control:focus {
    border-color: rgba(37, 99, 235, 0.45);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
  }

  .profile-edit-grid textarea.form-control {
    min-height: 92px;
    resize: vertical;
  }

  .profile-edit-note {
    margin-top: 10px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
  }

  .form-actions,
  .card-actions-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .account-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 34px;
    padding: 7px 12px;
    border: 0;
    border-radius: 7px;
    background: #2563eb;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 800;
  }

  .account-btn:hover {
    color: #fff;
    background: #1d4ed8;
  }

  .account-btn.secondary {
    background: #e5e7eb;
    color: #334155;
  }

  .account-btn.secondary:hover {
    background: #d1d5db;
    color: #111827;
  }

  .account-btn.danger {
    background: #dc2626;
  }

  .account-btn.danger:hover {
    background: #b91c1c;
  }

  .account-btn:disabled {
    background: #cbd5e1;
    color: #64748b;
    cursor: not-allowed;
  }

  .profile-photo-box {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 18px;
    padding: 16px;
    border: 1px solid #dce9f6;
    border-radius: 10px;
    background: #f8fafc;
  }

  .profile-photo-preview {
    width: 92px;
    height: 92px;
    border-radius: 50%;
    overflow: hidden;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: #fff;
    font-size: 30px;
    font-weight: 900;
    border: 4px solid #fff;
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
    flex: 0 0 auto;
  }

  .profile-photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .profile-photo-copy {
    flex: 1;
    min-width: 260px;
  }

  .profile-photo-copy h4 {
    margin: 0 0 6px;
    color: #17324d;
    font-size: 16px;
    font-weight: 900;
  }

  .profile-photo-copy p {
    margin: 0 0 12px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
  }

  .readonly-note {
    margin-top: 8px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
  }

  .profile-photo-status {
    margin-top: 10px;
  }

  .cropper-shell {
    margin-top: 14px;
    padding: 14px;
    border: 1px solid #dce9f6;
    border-radius: 10px;
    background: #fff;
  }

  .cropper-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 220px;
    gap: 14px;
    align-items: start;
  }

  .cropper-stage {
    padding: 12px;
    border: 1px solid #dce9f6;
    border-radius: 12px;
    background: linear-gradient(135deg, #0f172a, #1e293b);
  }

  .cropper-stage canvas {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 10px;
    background: #0f172a;
    touch-action: none;
  }

  .cropper-controls {
    display: grid;
    gap: 10px;
  }

  .cropper-controls label {
    color: #17324d;
    font-weight: 800;
    font-size: 13px;
  }

  .cropper-controls input[type="range"] {
    width: 100%;
  }

  .cropper-help {
    margin: 0;
    color: #64748b;
    font-size: 12px;
    line-height: 1.45;
  }

  .anggota-card-preview-wrap {
    margin-bottom: 16px;
  }

  .readonly-password {
    background: #e9ecef;
    cursor: not-allowed;
    pointer-events: none;
  }

  /* Saat print, sembunyikan panel lain supaya hasil cetak fokus ke kartu. */
  @media print {
    @page {
      size: A4 landscape;
      margin: 12mm 14mm;
    }

    body {
      background: #fff !important;
    }

    #header,
    .header,
    .account-nav,
    .account-content > .alert,
    .account-panel:not(#kartu-anggota),
    #kartu-anggota .alert,
    .card-actions-row,
    .scroll-top,
    #preloader {
      display: none !important;
    }

    .main,
    .account-page,
    .account-shell,
    .account-content,
    #kartu-anggota {
      margin: 0 !important;
      padding: 0 !important;
      display: block !important;
      box-shadow: none !important;
      border: 0 !important;
      background: #fff !important;
    }

  .anggota-card-preview-wrap .library-card {
      width: 85.6mm;
    }
  }

  @media (max-width: 980px) {
    .account-shell {
      grid-template-columns: 1fr;
    }

    .account-nav {
      position: static;
    }

    .cropper-layout {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .account-page {
      padding: 22px 16px;
    }

    .info-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<section class="account-page">
  <div class="account-shell">
    <aside class="account-nav">
      <div class="account-avatar" id="sidebar-avatar-preview">
        @if($profilePhoto)
          <img src="{{ $profilePhoto }}" alt="Foto profil {{ $user->name }}">
        @else
          {{ $profileInitial }}
        @endif
      </div>

      <h2>Profil Saya</h2>
      <p>{{ $user->email }}</p>

      <nav class="account-menu">
        <a href="#profil-saya"><i class="bi bi-person"></i> Profil Saya</a>
        <a href="{{ route('profile.data.edit') }}"><i class="bi bi-pencil-square"></i> Lengkapi Data</a>
        <a href="#foto-profil"><i class="bi bi-image"></i> Foto Profil Akun</a>
        @if($canUseAnggotaCard)
          <a href="#kartu-anggota"><i class="bi bi-person-vcard"></i> Kartu Anggota</a>
        @endif
        <a href="{{ route('profile.password.edit') }}"><i class="bi bi-shield-lock"></i> Ubah Password</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
      </nav>
    </aside>

    <div class="account-content">
      @if(session('success'))
        <div class="alert alert-success mb-0">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger mb-0">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <section id="profil-saya" class="account-panel">
        <div class="panel-head">
          <div>
            <h3>Profil Saya</h3>
            <span>Ringkasan informasi akun {{ $currentRole }}.</span>
          </div>
        </div>

        <details class="profile-summary" open>
          <summary>
            <div class="profile-summary-title">
              <strong>Profil Saya</strong>
              <span>Lihat dan kelola informasi profil pengguna.</span>
            </div>
          </summary>

          <div class="profile-summary-body">
            <div class="info-grid">
              @foreach($profileInfoRows as $info)
                <div class="info-item">
                  <label>{{ $info['label'] }}</label>
                  <strong>{{ $info['value'] }}</strong>
                </div>
              @endforeach
            </div>
          </div>
        </details>

        <div class="profile-photo-box" id="foto-profil">
          <div class="profile-photo-preview" id="profile-photo-preview">
            @if($profilePhoto)
              <img src="{{ $profilePhoto }}" alt="Foto profil {{ $user->name }}">
            @else
              {{ $profileInitial }}
            @endif
          </div>

          <div class="profile-photo-copy">
            <h4>Foto Profil Akun</h4>
            <p>Gunakan foto yang jelas agar identitas akun mudah dikenali. Unggah JPG, PNG, atau WEBP maksimal 5 MB, lalu atur posisinya sebelum menyimpan.</p>

            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" id="profile-photo-form">
              @csrf
              <input type="file" name="profile_photo" id="profile_photo_input" accept="image/png,image/jpeg,image/webp" hidden>

              <div class="form-actions">
                <button type="button" class="account-btn" id="choose-profile-photo"><i class="bi bi-image"></i> Pilih Foto</button>
                <button type="button" class="account-btn secondary" id="reset-profile-photo" disabled><i class="bi bi-arrow-counterclockwise"></i> Bersihkan</button>
              </div>

              <p id="profile-photo-status" class="readonly-note profile-photo-status">Belum ada file baru dipilih.</p>

              <div id="profile-photo-cropper" class="cropper-shell" hidden>
                <div class="cropper-layout">
                  <div class="cropper-stage">
                    <canvas id="profile-photo-canvas" width="480" height="480"></canvas>
                  </div>

                  <div class="cropper-controls">
                    <label for="profile-photo-zoom">Zoom</label>
                    <input type="range" id="profile-photo-zoom" min="0.6" max="2.5" step="0.01" value="0.85">
                    <p class="cropper-help">Seret gambar untuk mengatur posisi. Geser zoom ke kiri jika wajah terlalu dekat.</p>

                    <div class="form-actions">
                      <button type="button" class="account-btn" id="apply-profile-crop"><i class="bi bi-check2-circle"></i> Terapkan Crop</button>
                      <button type="button" class="account-btn secondary" id="cancel-profile-crop"><i class="bi bi-x-lg"></i> Batal</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions mt-3">
                <button type="submit" class="account-btn" id="save-profile-photo" disabled><i class="bi bi-save"></i> Simpan Foto Profil</button>
              </div>
            </form>

            @if($profilePhoto)
              <form action="{{ route('profile.photo.delete') }}" method="POST" class="form-actions mt-2" onsubmit="return confirm('Hapus foto profil ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="account-btn danger"><i class="bi bi-trash"></i> Hapus Foto Profil</button>
              </form>
            @endif
          </div>
        </div>

      </section>

      @if($canUseAnggotaCard)
      <section id="kartu-anggota" class="account-panel">
        <div class="panel-head">
          <div>
            <h3>Kartu Anggota</h3>
            <span>Unduh atau cetak kartu anggota perpustakaan.</span>
          </div>
        </div>

        @if(! empty($missingProfileCard))
          <div class="alert alert-warning d-flex flex-wrap align-items-center gap-2">
            <div>
              Kartu belum bisa dicetak sebelum data ini lengkap: <strong>{{ implode(', ', $missingProfileCard) }}</strong>.
              Foto untuk kartu diambil dari bagian <strong>Foto Profil untuk Kartu</strong> di atas.
            </div>
            <a href="#foto-profil" class="btn btn-sm btn-outline-primary ms-auto">Ke Foto Profil</a>
          </div>
        @else
          <div class="alert alert-success">
            Semua data kartu sudah lengkap. Silakan cetak kartu.
          </div>
        @endif

        <div class="anggota-card-preview-wrap">
          @include('partials.anggota_card_pair', ['anggotaCard' => $anggotaCard])
        </div>

        <div class="card-actions-row">
          <button type="button" class="account-btn" id="profile-card-print-btn">
            <i class="bi bi-printer"></i> {{ $profileCardReady ? 'Cetak Depan Belakang' : 'Lengkapi Dulu Sebelum Cetak' }}
          </button>
        </div>
      </section>
      @endif

    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const profileName = @json($user->name ?: 'Pengguna');
    const savedPhotoUrl = @json($profilePhoto);
    const savedInitial = @json($profileInitial);
    const profileCardComplete = @json($profileCardReady);
    const profileCardMissing = @json($missingProfileCard);
    const sidebarAvatar = document.getElementById('sidebar-avatar-preview');
    const profilePhotoPreview = document.getElementById('profile-photo-preview');
    const cardPhotoSlot = document.getElementById('profile-card-photo-slot');
    const profileCardPrintBtn = document.getElementById('profile-card-print-btn');
    const chooseBtn = document.getElementById('choose-profile-photo');
    const resetBtn = document.getElementById('reset-profile-photo');
    const saveBtn = document.getElementById('save-profile-photo');
    const status = document.getElementById('profile-photo-status');
    const input = document.getElementById('profile_photo_input');
    const cropper = document.getElementById('profile-photo-cropper');
    const canvas = document.getElementById('profile-photo-canvas');
    const ctx = canvas.getContext('2d');
    const exportCanvas = document.createElement('canvas');
    const exportCtx = exportCanvas.getContext('2d');
    const zoom = document.getElementById('profile-photo-zoom');
    const applyBtn = document.getElementById('apply-profile-crop');
    const cancelBtn = document.getElementById('cancel-profile-crop');
    const maxFileSize = 5 * 1024 * 1024;
    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

    const state = {
      image: null,
      file: null,
      scale: 1,
      baseScale: 1,
      x: 0,
      y: 0,
      dragging: false,
      dragStartX: 0,
      dragStartY: 0,
      originX: 0,
      originY: 0,
    };

    function renderAvatar(url) {
      if (! sidebarAvatar || ! profilePhotoPreview) {
        return;
      }

      const avatarMarkup = url
        ? `<img src="${url}" alt="Foto profil ${profileName}">`
        : savedPhotoUrl
          ? `<img src="${savedPhotoUrl}" alt="Foto profil ${profileName}">`
          : savedInitial;

      const profileMarkup = url
        ? `<img src="${url}" alt="Foto profil ${profileName}">`
        : savedPhotoUrl
          ? `<img src="${savedPhotoUrl}" alt="Foto profil ${profileName}">`
          : savedInitial;

      sidebarAvatar.innerHTML = avatarMarkup;
      profilePhotoPreview.innerHTML = profileMarkup;

      if (cardPhotoSlot) {
        cardPhotoSlot.innerHTML = url
          ? `<img src="${url}" alt="Foto profil ${profileName}" class="anggota-photo">`
          : savedPhotoUrl
            ? `<img src="${savedPhotoUrl}" alt="Foto profil ${profileName}" class="anggota-photo">`
            : `<div class="anggota-photo-placeholder">${savedInitial}</div>`;
      }
    }

    if (profileCardPrintBtn) {
      profileCardPrintBtn.addEventListener('click', () => {
        if (profileCardComplete) {
          window.print();
          return;
        }

        const message = profileCardMissing.length
          ? `Lengkapi dulu ${profileCardMissing.join(', ')} sebelum mencetak kartu.`
          : 'Lengkapi profil dulu sebelum mencetak kartu.';

        alert(message);

        const targetId = profileCardMissing.includes('Foto Profil') ? 'foto-profil' : 'profil-saya';
        const target = document.getElementById(targetId);

        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    }

    function setStatus(message, isError = false) {
      if (! status) {
        return;
      }

      status.textContent = message;
      status.style.color = isError ? '#b91c1c' : '#64748b';
    }

    function getPointerPosition(event) {
      const rect = canvas.getBoundingClientRect();
      return {
        x: ((event.clientX - rect.left) / rect.width) * canvas.width,
        y: ((event.clientY - rect.top) / rect.height) * canvas.height,
      };
    }

    function clampPosition() {
      if (! state.image) {
        return;
      }

      const scaledWidth = state.image.naturalWidth * state.scale;
      const scaledHeight = state.image.naturalHeight * state.scale;

      if (scaledWidth <= canvas.width) {
        state.x = (canvas.width - scaledWidth) / 2;
      } else {
        state.x = Math.min(0, Math.max(canvas.width - scaledWidth, state.x));
      }

      if (scaledHeight <= canvas.height) {
        state.y = (canvas.height - scaledHeight) / 2;
      } else {
        state.y = Math.min(0, Math.max(canvas.height - scaledHeight, state.y));
      }
    }

    function drawCropper() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = '#0f172a';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      if (! state.image) {
        ctx.fillStyle = '#94a3b8';
        ctx.font = '600 18px Poppins, Arial, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('Pilih foto untuk mulai crop', canvas.width / 2, canvas.height / 2);
        return;
      }

      ctx.drawImage(
        state.image,
        state.x,
        state.y,
        state.image.naturalWidth * state.scale,
        state.image.naturalHeight * state.scale
      );

      ctx.strokeStyle = 'rgba(255,255,255,0.35)';
      ctx.lineWidth = 2;
      ctx.strokeRect(8, 8, canvas.width - 16, canvas.height - 16);
    }

    function loadImageFromFile(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => {
          const image = new Image();
          image.onload = () => resolve(image);
          image.onerror = () => reject(new Error('Gambar tidak dapat dimuat.'));
          image.src = reader.result;
        };
        reader.onerror = () => reject(new Error('File tidak dapat dibaca.'));
        reader.readAsDataURL(file);
      });
    }

    function applyImageToState(image, file) {
      state.image = image;
      state.file = file;
      state.baseScale = Math.max(canvas.width / image.naturalWidth, canvas.height / image.naturalHeight);
      state.scale = state.baseScale * 0.85;
      state.x = (canvas.width - (image.naturalWidth * state.scale)) / 2;
      state.y = (canvas.height - (image.naturalHeight * state.scale)) / 2;
      zoom.value = 0.85;
      clampPosition();
      drawCropper();
      cropper.hidden = false;
      resetBtn.disabled = false;
      saveBtn.disabled = true;
      setStatus('Foto siap dipotong. Atur posisi di area crop lalu klik Terapkan Crop.');
    }

    chooseBtn.addEventListener('click', () => input.click());

    resetBtn.addEventListener('click', () => {
      state.image = null;
      state.file = null;
      state.scale = 1;
      state.baseScale = 1;
      state.x = 0;
      state.y = 0;
      zoom.value = 0.85;
      input.value = '';
      cropper.hidden = true;
      saveBtn.disabled = true;
      resetBtn.disabled = true;
      setStatus('Belum ada file baru dipilih.');
      renderAvatar(null);
      drawCropper();
    });

    input.addEventListener('change', async () => {
      const file = input.files && input.files[0];

      if (! file) {
        return;
      }

      if (! allowedTypes.includes(file.type)) {
        input.value = '';
        setStatus('Format foto harus JPG, PNG, atau WEBP.', true);
        return;
      }

      if (file.size > maxFileSize) {
        input.value = '';
        setStatus('Ukuran foto maksimal 5 MB.', true);
        return;
      }

      try {
        const image = await loadImageFromFile(file);
        applyImageToState(image, file);
      } catch (error) {
        input.value = '';
        setStatus(error.message || 'Foto gagal dimuat.', true);
      }
    });

    zoom.addEventListener('input', () => {
      if (! state.image) {
        return;
      }

      const previousScale = state.scale;
      const nextScale = state.baseScale * parseFloat(zoom.value);
      const centerX = state.x + ((state.image.naturalWidth * previousScale) / 2);
      const centerY = state.y + ((state.image.naturalHeight * previousScale) / 2);

      state.scale = nextScale;
      state.x = centerX - ((state.image.naturalWidth * nextScale) / 2);
      state.y = centerY - ((state.image.naturalHeight * nextScale) / 2);
      clampPosition();
      drawCropper();
    });

    canvas.addEventListener('pointerdown', (event) => {
      if (! state.image) {
        return;
      }

      state.dragging = true;
      const pointer = getPointerPosition(event);
      state.dragStartX = pointer.x;
      state.dragStartY = pointer.y;
      state.originX = state.x;
      state.originY = state.y;
      canvas.setPointerCapture(event.pointerId);
    });

    canvas.addEventListener('pointermove', (event) => {
      if (! state.dragging || ! state.image) {
        return;
      }

      const pointer = getPointerPosition(event);
      state.x = state.originX + (pointer.x - state.dragStartX);
      state.y = state.originY + (pointer.y - state.dragStartY);
      clampPosition();
      drawCropper();
    });

    canvas.addEventListener('pointerup', (event) => {
      state.dragging = false;
      try {
        canvas.releasePointerCapture(event.pointerId);
      } catch (error) {
        // Ignore release errors.
      }
    });

    canvas.addEventListener('pointercancel', () => {
      state.dragging = false;
    });

    applyBtn.addEventListener('click', () => {
      if (! state.image || ! state.file) {
        return;
      }

      exportCanvas.width = canvas.width;
      exportCanvas.height = canvas.height;

      if (! exportCtx) {
        setStatus('Crop gagal dibuat. Silakan coba lagi.', true);
        return;
      }

      exportCtx.fillStyle = '#ffffff';
      exportCtx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);
      exportCtx.drawImage(
        state.image,
        state.x,
        state.y,
        state.image.naturalWidth * state.scale,
        state.image.naturalHeight * state.scale
      );

      exportCanvas.toBlob((blob) => {
        if (! blob) {
          setStatus('Crop gagal dibuat. Silakan coba lagi.', true);
          return;
        }

        const croppedFile = new File(
          [blob],
          (state.file.name || 'profile-photo').replace(/\.[^.]+$/, '') + '-crop.jpg',
          { type: 'image/jpeg' }
        );

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(croppedFile);
        input.files = dataTransfer.files;
        saveBtn.disabled = false;
        renderAvatar(URL.createObjectURL(croppedFile));
        cropper.hidden = true;
        setStatus('Crop sudah diterapkan. Klik Simpan Foto Profil untuk menyimpan perubahan.');
      }, 'image/jpeg', 0.92);
    });

    cancelBtn.addEventListener('click', () => {
      state.image = null;
      state.file = null;
      state.scale = 1;
      state.baseScale = 1;
      state.x = 0;
      state.y = 0;
      zoom.value = 0.85;
      input.value = '';
      cropper.hidden = true;
      saveBtn.disabled = true;
      resetBtn.disabled = true;
      drawCropper();
      renderAvatar(null);
      setStatus('Pemilihan foto dibatalkan. Foto profil lama tetap digunakan.');
    });

    document.getElementById('profile-photo-form').addEventListener('submit', (event) => {
      if (! input.files || input.files.length === 0) {
        event.preventDefault();
        setStatus('Pilih foto, lakukan crop, lalu klik Terapkan Crop sebelum menyimpan.', true);
      }
    });

    drawCropper();
    renderAvatar(null);
  });

</script>
@endsection
