@extends('layouts.perpus')

@section('content')
<style>
  .profile-password-page {
    min-height: 100vh;
    padding: 34px;
    background: linear-gradient(135deg, #eef6ff, #f7f2ff 55%, #ffffff);
  }

  .profile-password-card {
    max-width: 760px;
    margin: 0 auto;
    overflow: hidden;
    background: rgba(255, 255, 255, .97);
    border: 1px solid #d7e4f5;
    border-radius: 16px;
    box-shadow: 0 18px 42px rgba(31, 75, 112, .14);
  }

  .profile-password-header {
    padding: 22px 26px;
    background: linear-gradient(135deg, #eaf6ff, #dbeafe);
    border-bottom: 1px solid #b8d2ed;
  }

  .profile-password-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 24px;
    font-weight: 800;
  }

  .profile-password-header p {
    margin: 6px 0 0;
    color: #64748b;
    font-size: 13px;
  }

  .profile-password-body {
    padding: 26px;
  }

  .profile-password-body .form-label {
    margin-bottom: 7px;
    color: #334155;
    font-weight: 700;
  }

  .profile-password-body .form-control {
    min-height: 44px;
    border: 1px solid #cbd9e8;
    border-radius: 9px;
  }

  .profile-password-body .form-control:focus {
    border-color: #54a9e8;
    box-shadow: 0 0 0 3px rgba(84, 169, 232, .16);
  }

  .profile-password-footer {
    display: flex;
    justify-content: flex-end;
    gap: 9px;
    padding: 16px 26px;
    background: #f8fbff;
    border-top: 1px solid #d8e5f2;
  }

  .profile-password-footer .btn {
    min-height: 42px;
    padding: 9px 16px;
    border: 0;
    border-radius: 9px;
    font-weight: 700;
  }

  .profile-password-footer .btn-primary {
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
  }

  @media (max-width: 768px) {
    .profile-password-page {
      padding: 22px 16px 34px;
    }

    .profile-password-body,
    .profile-password-footer {
      padding: 20px 16px;
    }

    .profile-password-footer {
      flex-direction: column-reverse;
    }

    .profile-password-footer .btn {
      width: 100%;
    }
  }
</style>

<section class="profile-password-page">
  <div class="profile-password-card">
    <header class="profile-password-header">
      <h2>Ubah Password</h2>
      <p>Perbarui password akun {{ $user->name }} untuk menjaga keamanan akun.</p>
    </header>

    <form action="{{ route('profile.password.update') }}" method="POST">
      @csrf
      <div class="profile-password-body">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="mb-4">
          <label class="form-label">Password Lama</label>
          <input type="password" value="••••••••" class="form-control" disabled>
          <small class="text-muted">Password lama tidak perlu diisi.</small>
        </div>

        <div class="row g-4">
          <div class="col-md-6">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
          </div>

          <div class="col-md-6">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
          </div>
        </div>
      </div>

      <footer class="profile-password-footer">
        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Kembali ke Profil</a>
        <button type="submit" class="btn btn-primary text-white"><i class="bi bi-shield-check"></i> Simpan Password Baru</button>
      </footer>
    </form>
  </div>
</section>
@endsection
