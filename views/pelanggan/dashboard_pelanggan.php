<?php
session_start();
require_once '../../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pelanggan') {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_users'];
$username = $_SESSION['username'];

// Ambil total pesanan
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_pesanan = mysqli_fetch_assoc($result)['total'] ?? 0;
mysqli_stmt_close($stmt);

// Ambil status terakhir
$stmt = mysqli_prepare($conn, "SELECT status FROM transaksi WHERE id_user = ? ORDER BY tgl_transaksi DESC LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$status_terakhir = mysqli_fetch_assoc($result)['status'] ?? 'Belum ada';
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pelanggan | BuketMinku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body class="bg-light">

<?php include '../partials/navbar_customer.php'; ?>

<!-- Greeting -->
<div class="container mb-4">
  <h3 class="fw-bold text-pink">Halo, <?= htmlspecialchars($username); ?> 👋</h3>
  <p>Selamat datang kembali di BuketMinku. Yuk, cek pesanan dan promo terbaru!</p>
</div>

<!-- Summary Cards -->
<div class="container mb-5">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card card-summary shadow-sm p-3">
        <h5 class="mb-2">🧾 Total Pesanan</h5>
        <p class="fs-4 fw-bold"><?= $total_pesanan ?></p>
        <a href="riwayat.php" class="btn btn-pink btn-sm">Lihat Riwayat</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-summary shadow-sm p-3">
        <h5 class="mb-2">📦 Status Terakhir</h5>
        <p class="fs-5">
          <span class="badge bg-<?= $status_terakhir === 'dibayar' ? 'success' : ($status_terakhir === 'dikirim' ? 'primary' : 'warning') ?> badge-status">
            <?= ucfirst($status_terakhir) ?>
          </span>
        </p>
        <a href="riwayat.php" class="btn btn-pink btn-sm">Detail</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-summary shadow-sm p-3">
        <h5 class="mb-2">💖 Wishlist</h5>
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

