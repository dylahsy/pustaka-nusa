@extends('layouts.perpus')

@section('content')
@php
    $role = $user->role ?? 'Pengguna';
    $isStaff = in_array($role, ['Admin', 'Kepala Perpustakaan'], true);
    $identityLabel = $isStaff ? 'NIP' : 'NIS/NIP';
@endphp

<style>
  .profile-data-page {
    min-height: 100vh;
    padding: 34px;
    background: linear-gradient(135deg, #eef6ff, #f7f2ff 55%, #ffffff);
  }

  .profile-data-card {
    max-width: 920px;
    margin: 0 auto;
    overflow: hidden;
    background: rgba(255, 255, 255, .97);
    border: 1px solid #d7e4f5;
    border-radius: 16px;
    box-shadow: 0 18px 42px rgba(31, 75, 112, .14);
  }

  .profile-data-header {
    padding: 22px 26px;
    background: linear-gradient(135deg, #eaf6ff, #dbeafe);
    border-bottom: 1px solid #b8d2ed;
  }

  .profile-data-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 24px;
    font-weight: 800;
  }

  .profile-data-header p {
    margin: 6px 0 0;
    color: #64748b;
    font-size: 13px;
  }

  .profile-data-body {
    padding: 26px;
  }

  .profile-data-section {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
  }

  .profile-data-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: 0;
  }

  .profile-data-section h3 {
    margin: 0 0 4px;
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
  }

  .profile-data-section p {
    margin: 0 0 16px;
    color: #64748b;
    font-size: 13px;
  }

  .profile-data-page .form-label {
    margin-bottom: 7px;
    color: #334155;
    font-weight: 700;
  }

  .profile-data-page .form-control,
  .profile-data-page .form-select {
    min-height: 44px;
    border: 1px solid #cbd9e8;
    border-radius: 9px;
  }

  .profile-data-page .form-control:focus,
  .profile-data-page .form-select:focus {
    border-color: #54a9e8;
    box-shadow: 0 0 0 3px rgba(84, 169, 232, .16);
  }

  .profile-data-page .form-control[readonly] {
    background: #f3f7fb;
    color: #64748b;
  }

  .profile-data-footer {
    display: flex;
    justify-content: flex-end;
    gap: 9px;
    padding: 16px 26px;
    background: #f8fbff;
    border-top: 1px solid #d8e5f2;
  }

  .profile-data-footer .btn {
    min-height: 42px;
    padding: 9px 16px;
    border: 0;
    border-radius: 9px;
    font-weight: 700;
  }

  .profile-data-footer .btn-primary {
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
  }

  @media (max-width: 768px) {
    .profile-data-page {
      padding: 22px 16px 34px;
    }

    .profile-data-body,
    .profile-data-footer {
      padding: 20px 16px;
    }

    .profile-data-footer {
      flex-direction: column-reverse;
    }

    .profile-data-footer .btn {
      width: 100%;
    }
  }
</style>

<section class="profile-data-page">
  <div class="profile-data-card">
    <header class="profile-data-header">
      <h2>Lengkapi Data Profil</h2>
      <p>Lengkapi informasi akun {{ $role }} pada halaman ini.</p>
    </header>

    <form action="{{ route('profile.account.update') }}" method="POST">
      @csrf
      <div class="profile-data-body">
        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="profile-data-section">
          <h3>Informasi Akun</h3>
          <p>Informasi jabatan, identitas, dan kontak akun.</p>

          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label">Jabatan</label>
              <input type="text" class="form-control" value="{{ $role }}" readonly>
            </div>

            <div class="col-md-6">
              <label for="name" class="form-label">Nama Lengkap</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
              <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>

            <div class="col-md-6">
              <label for="nis_nip" class="form-label">{{ $identityLabel }}</label>
              <input type="text" name="nis_nip" id="nis_nip" class="form-control" value="{{ old('nis_nip', $user->nis_nip) }}" placeholder="Masukkan {{ strtolower($identityLabel) }}">
              <small class="text-danger">{{ $errors->first('nis_nip') }}</small>
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" value="{{ $user->email }}" readonly>
              <small class="text-muted">Email dikelola oleh sistem.</small>
            </div>

            <div class="col-md-6">
              <label for="no_hp" class="form-label">No. HP</label>
              <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 0812xxxx">
              <small class="text-danger">{{ $errors->first('no_hp') }}</small>
            </div>

            <div class="col-md-6">
              <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                <option value="">- Pilih Jenis Kelamin -</option>
                @foreach($genderOptions as $gender)
                  <option value="{{ $gender }}" {{ old('jenis_kelamin', $user->jenis_kelamin) === $gender ? 'selected' : '' }}>{{ $gender }}</option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
            </div>

            <div class="col-12">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Tulis alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
              <small class="text-danger">{{ $errors->first('alamat') }}</small>
            </div>
          </div>
        </div>

        <div class="profile-data-section">
          <h3>Tanggal Bergabung</h3>
          <p>Tanggal bergabung dicatat otomatis oleh sistem dan tidak dapat diubah.</p>
          <input type="text" class="form-control" value="{{ optional($user->created_at)->format('d/m/Y') ?? '-' }}" readonly>
        </div>
      </div>

      <footer class="profile-data-footer">
        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary text-white">Simpan Perubahan</button>
      </footer>
    </form>
  </div>
</section>
@endsection
