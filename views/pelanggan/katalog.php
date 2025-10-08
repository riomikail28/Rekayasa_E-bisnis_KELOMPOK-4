<?php
session_start();
require_once '../../config/koneksi.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_users'];

// Ambil kategori unik
$kategori = [];
$kategori_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk");
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategori[] = $row['kategori'];
}

// Filter produk jika ada kategori
$filter_kategori = $_GET['kategori'] ?? null;

if ($filter_kategori) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE kategori = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, "s", $filter_kategori);
} else {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk ORDER BY id DESC");
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
    .sidebar-wrapper {
      transition: all 0.3s ease;
    }
    .sidebar {
      height: 100vh;
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
      padding-top: 30px;
      position: fixed;
      left: 0;
      top: 0;
      width: 250px;
      z-index: 1000;
      overflow-y: auto;
    }
    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: #333;
      text-decoration: none;
      border-radius: 6px;
      margin-bottom: 8px;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #e9ecef;
      font-weight: bold;
    }
    .sidebar-toggle {
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1100;
      background-color: #ff6ec4;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 18px;
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
      height: 180px;
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
    .produk-deskripsi {
      font-size: 0.9rem;
      color: #555;
      min-height: 60px;
    }
    .content-area {
      margin-left: 250px;
      transition: margin-left 0.3s ease;
    }
    .sidebar-hidden .sidebar {
      left: -250px;
    }
    .sidebar-hidden .content-area {
      margin-left: 0;
    }
  </style>
</head>
<body>

<!-- ✅ Tombol Toggle Sidebar -->
<button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar-wrapper">
  <!-- ✅ Sidebar Kiri -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <h4 class="fw-bold text-primary">Buketminiku</h4>
    </div>
    <a href="katalog.php" class="<?= !$filter_kategori ? 'active' : '' ?>">🏠 Semua Produk</a>
    <?php foreach ($kategori as $kat): ?>
      <a href="katalog.php?kategori=<?= urlencode($kat) ?>" class="<?= ($filter_kategori === $kat) ? 'active' : '' ?>">
        <?= htmlspecialchars(ucwords($kat)) ?>
      </a>
    <?php endforeach; ?>
    <hr>
    <a href="keranjang.php">🛒 Keranjang</a>
    <a href="riwayat.php">📦 Riwayat</a>
    <a href="home_login.php">🏠 Home</a>
    <a href="../../auth/logout.php" class="text-danger" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
  </div>
</div>

<!-- ✅ Konten Produk -->
<div class="content-area py-4 px-4">
  <h3 class="fw-bold text-center mb-4">🌸 Wishlist Buketminiku</h3>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <div class="row">
    <?php while ($p = mysqli_fetch_assoc($result)): ?>
      <?php
        $gambar = $p['gambar'] ?? '';
        $gambarPath = $gambar ? "../../uploads/$gambar" : "../../assets/default.png";
      ?>
      <div class="col-md-4 mb-4">
        <div class="card produk-card h-100">
          <img src="<?= $gambarPath ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" class="produk-img">
          <div class="card-body">
            <h5 class="card-title text-center"><?= htmlspecialchars($p['nama_produk']) ?></h5>
            <p class="produk-deskripsi"><?= htmlspecialchars($p['deskripsi']) ?></p>
            <p class="fw-semibold text-muted text-center">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
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

<script>
  function toggleSidebar() {
    document.body.classList.toggle('sidebar-hidden');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
