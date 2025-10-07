<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan user login
if (!isset($_SESSION['id_users'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Katalog Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .produk-card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: 0.3s;
    }
    .produk-card:hover {
      transform: scale(1.02);
    }
    .produk-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 12px 12px 0 0;
    }
    .btn-beli {
      background-color: #ff6ec4;
      color: white;
      border: none;
    }
    .btn-beli:hover {
      background-color: #ff4fa8;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="home_login.php">Buketminiku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="home_login.php">🏠 Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="keranjang.php">🛒 Keranjang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="riwayat.php">📦 Riwayat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../../auth/logout.php" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <div class="container py-5">
    <h2 class="text-center fw-bold mb-4">🌸 Wishlist Buketminiku</h2>

    <?php if (isset($_GET['msg'])): ?>
      <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <div class="row">
      <?php while ($p = mysqli_fetch_assoc($result)): ?>
        <?php
          $gambar = $p['gambar'] ?? '';
          $gambarPath = $gambar ? "../../uploads/$gambar" : "../../assets/default.png";
        ?>
        <div class="col-md-3 mb-4">
          <div class="card produk-card h-100">
            <img src="<?= $gambarPath ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" class="produk-img">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($p['nama_produk']) ?></h5>
              <p class="fw-semibold text-muted">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
              <form method="POST" action="../../controllers/transaksiController.php">
                <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
                <input type="number" name="jumlah" value="1" min="1" class="form-control mb-2">
                <input type="hidden" name="redirect" value="katalog">
                <button type="submit" name="beli" class="btn btn-beli w-100">Beli</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
