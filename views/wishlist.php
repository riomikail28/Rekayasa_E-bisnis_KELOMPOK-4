<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../helpers/auth.php';

if (!isUser()) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Wishlist - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Wishlist Saya</h1>
    <div class="row">
      <!-- Placeholder produk wishlist -->
      <div class="col-md-4">
        <div class="card produk-card shadow-sm">
          <img src="../uploads/produk_1759672209.jpg" class="card-img-top" alt="Produk">
          <div class="card-body">
            <h5 class="card-title">Buket Mawar Merah</h5>
            <p class="card-text">Rp 99.000</p>
            <a href="#" class="btn btn-pink w-100">Beli Sekarang</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card produk-card shadow-sm">
          <img src="../uploads/produk_1759673854.jpg" class="card-img-top" alt="Produk">
          <div class="card-body">
            <h5 class="card-title">Buket Snack</h5>
            <p class="card-text">Rp 85.000</p>
            <a href="#" class="btn btn-pink w-100">Beli Sekarang</a>
          </div>
        </div>
      </div>
      <!-- Tambahkan lebih banyak jika ada -->
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 Bucketminiku | WhatsApp: 0812-XXXX-XXXX | Instagram: @bucketminiku
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

