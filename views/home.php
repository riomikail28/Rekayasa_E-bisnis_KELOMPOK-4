<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>BuketMiniku | Toko Bunga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="uploads/logo_bucketminiku.jpg" alt="BuketMiniku" style="height: 40px;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Beranda</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Informasi
            </a>
            <ul class="dropdown-menu" aria-labelledby="informasiDropdown">
              <li><a class="dropdown-item" href="views/tentang_kami.php">Tentang Kami</a></li>
              <li><a class="dropdown-item" href="views/faq.php">FAQ</a></li>
              <li><a class="dropdown-item" href="views/syarat_ketentuan.php">Syarat & Ketentuan</a></li>
              <li><a class="dropdown-item" href="views/kebijakan_privasi.php">Kebijakan Privasi</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="views/promo.php">Promo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="views/wishlist.php">Wishlist</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="views/testimoni.php">Testimoni</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="views/blog.php">Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['role'])): ?>
            <li class="nav-item">
              <a class="btn btn-outline-danger" href="controllers/logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="btn btn-outline-pink me-2" href="auth/login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-pink" href="auth/registrasi.php">Daftar</a>
            </li>
          <?php endif; ?>
        </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(to right, #f8cdda, #f06292, #d81b60);">
  <div class="container">
    <h1 class="display-5 fw-bold">Selamat Datang di BuketMiniku</h1>
    <p class="lead">Toko bunga dan hadiah untuk momen spesialmu. Kirim cinta lewat buket yang bermakna.</p>
    <a href="#produk" class="btn btn-light btn-lg mt-3">Lihat Produk</a>
  </div>
</section>

<!-- Produk Preview -->
<section id="produk" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Produk Unggulan</h2>
    <div class="row">
      <!-- Card 1 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket1.jpg" class="card-img-top" alt="Buket Bunga">
          <div class="card-body">
            <h5 class="card-title">Buket Mawar Merah</h5>
            <p class="card-text">Rp 99.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket2.jpg" class="card-img-top" alt="Buket Snack">
          <div class="card-body">
            <h5 class="card-title">Buket Snack & Minuman</h5>
            <p class="card-text">Rp 85.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket3.jpg" class="card-img-top" alt="Buket Boneka">
          <div class="card-body">
            <h5 class="card-title">Buket Boneka & Bunga</h5>
            <p class="card-text">Rp 120.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket4.jpg" class="card-img-top" alt="Buket Uang">
          <div class="card-body">
            <h5 class="card-title">Buket Uang Kreatif</h5>
            <p class="card-text">Rp 150.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Informasi & Layanan -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Informasi & Layanan</h2>
    <div class="row">
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">Tentang Kami</h5>
            <p class="card-text">Pelajari visi dan misi perusahaan kami.</p>
            <a href="views/tentang_kami.php" class="btn btn-pink">Baca Lebih Lanjut</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">FAQ</h5>
            <p class="card-text">Pertanyaan umum tentang layanan kami.</p>
            <a href="views/faq.php" class="btn btn-pink">Lihat FAQ</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">Promo</h5>
            <p class="card-text">Daftar promo dan diskon terbaru.</p>
            <a href="views/promo.php" class="btn btn-pink">Lihat Promo</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h5 class="card-title">Testimoni</h5>
            <p class="card-text">Ulasan dari pelanggan kami.</p>
            <a href="views/testimoni.php" class="btn btn-pink">Baca Testimoni</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 BuketMiniku | WhatsApp: 0812-XXXX-XXXX | Instagram: @buketminiku
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
