<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SIMPUS SMANES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #ebb5d2, #a1bdda);
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      margin: 0;
      overflow: hidden;
      position: relative;
    }

    canvas {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 0;
      pointer-events: none;
    }

    .landing-container {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100%;
      text-align: center;
      padding: 20px;
      animation: fadeIn 2s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo-image {
      width: 175px;
      height: 175px;
      object-fit: contain;
      margin-bottom: 25px;
      background-color: #fff;
      border-radius: 50%;
      padding: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .logo {
      font-family: 'Fredoka', 'Poppins', sans-serif;
      font-size: 3.2rem;
      font-weight: 700;
      color: transparent;
      background: linear-gradient(135deg, #244b8f, #7b4fd6, #ff6b81);
      -webkit-background-clip: text;
      background-clip: text;
      margin-bottom: 10px;
      text-shadow: 0 8px 18px rgba(44, 62, 80, 0.18);
      -webkit-text-stroke: 1px rgba(255, 255, 255, 0.55);
    }

    .subtitle {
      font-size: 1.2rem;
      color: #4e4e4e;
      margin-bottom: 40px;
      font-weight: 400;
    }

    .action-buttons {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
    }

    .action-buttons .btn {
      padding: 12px 35px;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s ease;
      font-size: 16px;
    }

    .btn-login {
      background-color: #4c89ff;
      color: white;
    }

    .btn-login:hover {
      background-color: #3b72d2;
    }

    .btn-register {
      background-color: #ff6b81;
      color: white;
    }

    .btn-register:hover {
      background-color: #e9556c;
    }

    @media (max-width: 576px) {
      .logo {
        font-size: 2.4rem;
      }

      .subtitle {
        font-size: 1rem;
      }

      .logo-image {
        width: 135px;
        height: 135px;
      }
    }
  </style>
</head>

<body>
  <!-- Canvas untuk efek dekorasi perpustakaan -->
  <canvas id="bubbleCanvas"></canvas>

  <div class="container landing-container">
    <img src= '{{ asset('templateperpus/img/logo_ungu_smanes.jpg') }}'alt="Logo Buku" class="logo-image">

    <h1 class="logo">SIMPUS SMANES</h1>
    <p class="subtitle">Sistem Perpustakaan SMAN 9 Kota Jambi</p>

    <div class="action-buttons">
      <a href="{{ route('login') }}" class="btn btn-login">Login</a>
      <a href="{{ route('register') }}" class="btn btn-register">Register</a>
    </div>
  </div>

<!-- Script efek animasi perpustakaan -->
<script>
  const canvas = document.getElementById('bubbleCanvas');
  const ctx = canvas.getContext('2d');
  let floatingItems = [];

  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }

  window.addEventListener('resize', resizeCanvas);
  resizeCanvas();

  function createFloatingItem() {
    return {
      x: Math.random() * canvas.width,
      y: canvas.height + Math.random() * 100,
      size: Math.random() * 16 + 12,
      speed: Math.random() * 0.8 + 0.35,
      drift: Math.random() * 0.6 - 0.3,
      rotation: Math.random() * Math.PI,
      rotationSpeed: Math.random() * 0.01 - 0.005,
      opacity: Math.random() * 0.35 + 0.25,
      type: Math.random() > 0.45 ? 'book' : 'page'
    };
  }

  function drawBook(item) {
    const width = item.size * 0.9;
    const height = item.size * 1.15;

    ctx.fillStyle = `rgba(76, 137, 255, ${item.opacity})`;
    ctx.fillRect(-width / 2, -height / 2, width, height);

    ctx.fillStyle = `rgba(255, 107, 129, ${item.opacity})`;
    ctx.fillRect(-width / 2, -height / 2, width * 0.22, height);

    ctx.strokeStyle = `rgba(255, 255, 255, ${item.opacity + 0.15})`;
    ctx.lineWidth = 1;
    ctx.beginPath();
    ctx.moveTo(-width * 0.12, -height / 2);
    ctx.lineTo(-width * 0.12, height / 2);
    ctx.stroke();
  }

  function drawPage(item) {
    const width = item.size * 0.85;
    const height = item.size * 1.1;

    ctx.fillStyle = `rgba(255, 255, 255, ${item.opacity})`;
    ctx.fillRect(-width / 2, -height / 2, width, height);

    ctx.strokeStyle = `rgba(44, 62, 80, ${item.opacity * 0.65})`;
    ctx.lineWidth = 1;

    for (let i = -1; i <= 1; i++) {
      ctx.beginPath();
      ctx.moveTo(-width * 0.28, i * height * 0.18);
      ctx.lineTo(width * 0.28, i * height * 0.18);
      ctx.stroke();
    }
  }

  function drawFloatingItem(item) {
    ctx.save();
    ctx.translate(item.x, item.y);
    ctx.rotate(item.rotation);

    if (item.type === 'book') {
      drawBook(item);
    } else {
      drawPage(item);
    }

    ctx.restore();
  }

  function updateFloatingItems() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    floatingItems.forEach((item, i) => {
      item.y -= item.speed;
      item.x += item.drift;
      item.rotation += item.rotationSpeed;

      drawFloatingItem(item);

      if (item.y + item.size < 0 || item.x < -40 || item.x > canvas.width + 40) {
        floatingItems[i] = createFloatingItem();
      }
    });
  }

  function animate() {
    updateFloatingItems();
    requestAnimationFrame(animate);
  }

  for (let i = 0; i < 34; i++) {
    floatingItems.push(createFloatingItem());
  }

  animate();
</script>
</body>
</html>
