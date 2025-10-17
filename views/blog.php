<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Blog & Berita - Buketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-pink" href="../index.php">Buketminiku</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Beranda</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Informasi
            </a>
            <ul class="dropdown-menu" aria-labelledby="informasiDropdown">
              <li><a class="dropdown-item" href="tentang_kami.php">Tentang Kami</a></li>
              <li><a class="dropdown-item" href="kontak_kami.php">Kontak Kami</a></li>
              <li><a class="dropdown-item" href="faq.php">FAQ</a></li>
              <li><a class="dropdown-item" href="syarat_ketentuan.php">Syarat & Ketentuan</a></li>
              <li><a class="dropdown-item" href="kebijakan_privasi.php">Kebijakan Privasi</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="promo.php">Promo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="wishlist.php">Wishlist</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="testimoni.php">Testimoni</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Blog</a>
          </li>
          <?php if (isset($_SESSION['role'])): ?>
            <li class="nav-item">
              <a class="btn btn-outline-danger" href="../controllers/logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="btn btn-outline-pink me-2" href="../auth/login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-pink" href="../auth/registrasi.php">Daftar</a>
            </li>
          <?php endif; ?>
        </ul>
    </div>
  </div>
</nav>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Blog & Berita</h1>
    <div class="row">
      <div class="col-md-6">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Tips Memilih Buket Bunga yang Tepat</h5>
            <p class="card-text">Pelajari cara memilih buket bunga berdasarkan acara dan preferensi penerima.</p>
            <small class="text-muted">Diterbitkan: 15 Oktober 2025</small>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Manfaat Bunga untuk Kesehatan Mental</h5>
            <p class="card-text">Bunga tidak hanya indah, tetapi juga bermanfaat untuk meningkatkan suasana hati.</p>
            <small class="text-muted">Diterbitkan: 10 Oktober 2025</small>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Trend Buket Modern 2025</h5>
            <p class="card-text">Jelajahi tren terbaru dalam desain buket bunga untuk tahun ini.</p>
            <small class="text-muted">Diterbitkan: 5 Oktober 2025</small>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Cara Merawat Bunga Agar Tahan Lama</h5>
            <p class="card-text">Panduan praktis untuk menjaga kesegaran bunga di rumah.</p>
            <small class="text-muted">Diterbitkan: 1 Oktober 2025</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 BuketMiniku | WhatsApp: 0812-XXXX-XXXX | Instagram: @Buketminiku
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
