<!doctype html>
<html lang="id">
<head>
  <title>SIMPUS SMANES - Daftar Akun</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Style -->
  <link rel="stylesheet" href="{{ asset('templatelogin') }}/css/style.css">

  <style>
    body {
      background-image: url('{{ asset('templatelogin') }}/images/bg.jpg');
      background-size: cover;
      background-position: center;
      font-family: 'Lato', sans-serif;
    }

    .navbar-custom {
      background-color: transparent;
      position: absolute;
      top: 0;
      width: 100%;
      z-index: 10;
      padding: 15px 30px;
    }

    .navbar-custom .btn-back {
      color: #fff;
      font-weight: bold;
      border: 2px solid #fff;
      border-radius: 30px;
      padding: 5px 20px;
      transition: 0.3s;
      text-decoration: none;
    }

    .navbar-custom .btn-back:hover {
      background-color: #fff;
      color: #333;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 15px;
      width: 520px;
      max-width: calc(100vw - 32px);
      margin: 0 auto;
      padding:  24px 36px;
      box-shadow: 0 0 25px rgba(0,0,0,0.3);
      color: #fff;
    }

    .form-control {
      border-radius: 30px;
      padding: 7px 18px;
      background-color: rgba(195, 195, 195, 0.9);
      border: none;
      color: #000;
    }

    .form-control::placeholder {
      color: #555;
    }

    .btn-register {
      border-radius: 30px;
      background-color: #0d6efd;
      border: none;
      color: #fff;
      font-weight: bold;
    }

    .btn-register:hover {
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
  </style>
</head>

<body>

  <!-- Navbar Back -->
  <div class="navbar-custom">
    <a href="{{ url('/') }}" class="btn-back">Kembali</a>
  </div>

  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="login-card text-start">
            <h2 class="mb-3 text-white text-center"><b>Daftar Akun</b></h2>

            {{-- Alert Error --}}
            @if(session('error'))
              <div class="alert-custom text-center">
                {{ session('error') }}
              </div>
            @endif

            @if ($errors->any())
              <div class="alert-custom">
                <ul class="mb-0 ps-3 text-start">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="mb-2">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
              </div>

              <div class="mb-2">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required>
              </div>

              <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
              </div>

              <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
              </div>

              <button type="submit" class="btn btn-register w-100 mb-3">DAFTAR</button>

              <div class="text-center">
                <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
