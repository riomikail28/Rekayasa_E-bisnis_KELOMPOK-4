<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pelanggan') {
    header("Location: ../../auth/login.php");
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pelanggan | BuketMinku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/style.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold text-pink" href="#">BuketMinku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home_login.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
        <li class="nav-item"><a class="nav-link" href="keranjang.php">Keranjang</a></li>
        <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
        <li class="nav-item"><a class="btn btn-outline-danger ms-2" href="../../controllers/Logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Greeting -->
<div class="container mb-4">
  <h3 class="fw-bold text-pink">Halo, <?= htmlspecialchars($username); ?>!</h3>
  <p>Selamat datang kembali. Yuk, cek pesanan dan promo terbaru!</p>
</div>

<!-- Summary Cards -->
<div class="container mb-5">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card card-summary shadow-sm p-3">
        <h5>Total Pesanan</h5>
        <p class="fs-4 fw-bold">12</p>
        <a href="riwayat.php" class="btn btn-pink btn-sm">Lihat Riwayat</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-summary shadow-sm p-3">
        <h5>Status Terakhir</h5>
        <p class="fs-5">Sedang dikirim</p>
        <a href="riwayat.php" class="btn btn-pink btn-sm">Detail</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-summary shadow-sm p-3">
        <h5>Wishlist</h5>
        <p class="fs-5">3 produk disimpan</p>
        <a href="produk.php" class="btn btn-pink btn-sm">Lihat Wishlist</a>
      </div>
    </div>
  </div>
</div>

<!-- Promo Section -->
<div class="container mb-5">
  <h4 class="mb-3">🎁 Promo Spesial untuk Kamu</h4>
  <div class="row">
    <div class="col-md-3">
      <div class="card shadow-sm">
        <img src="../../uploads/buket1.jpg" class="card-img-top" alt="Promo Buket">
        <div class="card-body">
          <h5 class="card-title">Diskon 20% Buket Mawar</h5>
          <a href="produk.php" class="btn btn-pink w-100">Lihat Produk</a>
        </div>
      </div>
    </div>
    <!-- Tambahkan promo lainnya sesuai kebutuhan -->
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  &copy; 2025 BuketMinku | WhatsApp: 0812-XXXX-XXXX | Instagram: @buketminka.id
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
