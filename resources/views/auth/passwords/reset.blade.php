<!doctype html>
<html lang="id">
  <head>
    <title>Atur Ulang Password | SIMPUS SMANES</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('templatelogin') }}/css/style.css">

    <style>
      body {
        background-image: url('{{ asset('templatelogin') }}/images/bg.jpg');
        background-size: cover;
        background-position: center;
        font-family: 'Lato', sans-serif;
      }

      .login-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 0 25px rgba(0,0,0,0.3);
        color: #fff;
      }

      .form-control {
        border-radius: 30px;
        padding: 10px 20px;
        background-color: rgba(195, 195, 195, 0.9);
        border: none;
        color: #000;
      }

      .form-control::placeholder {
        color: #555;
      }

      .btn-login {
        border-radius: 30px;
        background-color: #0d6efd;
        border: none;
        color: #fff;
        font-weight: bold;
      }

      .btn-login:hover {
        background-color: #0b5ed7;
      }

      .alert-custom {
        background-color: rgba(255, 0, 0, 0.15);
        color: #800;
        padding: 8px 15px;
        font-size: 14px;
        border-radius: 10px;
        margin-bottom: 15px;
      }

      .back-link {
        color: #fff;
        font-weight: 700;
        text-decoration: underline;
      }

      .back-link:hover {
        color: #dbeafe;
      }
    </style>
  </head>

  <body>
    <div class="d-flex justify-content-center align-items-center vh-100">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 col-lg-5">
            <div class="login-card text-center">
              <h2 class="mb-3 text-white"><b>Atur Ulang Password</b></h2>
              <p class="mb-3">Masukkan password baru untuk akun Anda.</p>

              @if ($errors->any())
                <div class="alert-custom">
                  <ul class="mb-0 ps-3 text-start">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('password.update') }}" class="text-start">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password Baru</label>
                  <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru" required autocomplete="new-password">
                </div>

                <div class="mb-3">
                  <label for="password-confirm" class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Ulangi password baru" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-login w-100 mb-3">Simpan Password Baru</button>
              </form>

              <p class="mt-4 text-white">
                Kembali ke halaman
                <a href="{{ route('login') }}" class="back-link">Login</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
