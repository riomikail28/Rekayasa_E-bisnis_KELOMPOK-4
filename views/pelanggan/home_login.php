<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>BuketMinku | Toko Bunga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hero {
      background: linear-gradient(to right, #f8cdda, #fbc2eb);
      padding: 80px 20px;
      color: white;
      text-align: center;
    }
    .produk-card img {
      height: 200px;
      object-fit: cover;
    }
  </style>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-pink" href="#">BuketMinku</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
          <li class="nav-item"><a class="nav-link" href="keranjang.php">Keranjang</a></li>
          <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard_pelanggan.php">Profil</a></li>

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
<section class="hero">
  <div class="container">
    <h1 class="display-5 fw-bold">Selamat Datang di BuketMinku</h1>
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

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  &copy; 2025 BuketMinku | WhatsApp: 0812-XXXX-XXXX | Instagram: @buketminka.id
</footer>

</body>
</html>
