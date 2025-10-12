<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../../config/koneksi.php';

// Fetch first 4 products for preview
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC LIMIT 4");
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>BuketMiniku | Toko Bunga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-pink" href="#">Buketminiku</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="katalog.php">Katalog</a></li>
          <li class="nav-item"><a class="nav-link" href="keranjang.php">Keranjang</a></li>
          <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard_pelanggan.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
          <?php if (isset($_SESSION['role'])): ?>
            <li class="nav-item">
              <a class="btn btn-outline-danger" href="../../controllers/logout.php">Logout</a>
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
      <?php while ($p = mysqli_fetch_assoc($result)): ?>
        <?php
          $gambar = $p['gambar'] ?? '';
          $gambarPath = $gambar ? "../../uploads/$gambar" : "../../assets/default.png";
        ?>
        <div class="col-md-3">
          <div class="card produk-card shadow-sm">
            <img src="<?= $gambarPath ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nama_produk']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($p['nama_produk']) ?></h5>
              <p class="card-text">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
              <form method="POST" action="../../controllers/transaksiController.php">
                <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
                <input type="number" name="jumlah" value="1" min="1" class="form-control mb-2" style="display:none;">
                <input type="hidden" name="redirect" value="katalog">
                <button type="submit" name="beli" class="btn btn-pink w-100">Beli</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 BuketMiniku | WhatsApp: 0812-XXXX-XXXX | Instagram: @buketminiku.id
</footer>

</body>
</html>
