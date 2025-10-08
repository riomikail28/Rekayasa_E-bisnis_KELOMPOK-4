<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit;
}

// Semua halaman admin yang diizinkan
$adminPages = [
    'tambah_produk',
    'tambah_kategori',
    'produk_admin',
    'edit_produk',
    'hapus_produk',
    'laporan_penjualan',
    'daftar_customer',
    'detail_customer',
    'tambah_customer',
    'edit_customer',
    'hapus_customer',
    'blokir_customer',
    'buka_blokir_customer',
    'ganti_password_customer',
    'admin_transaksi',
    'validasi_transaksi',
    'dashboard_analytics',
];

$page = $_GET['page'] ?? 'produk_admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin | BuketMinku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      background-color: #fff;
      border-right: 1px solid #dee2e6;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 20px;
      z-index: 1000;
    }
    .sidebar .nav-link {
      color: #333;
      padding: 10px 20px;
      border-radius: 6px;
      margin-bottom: 6px;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #f06292;
      color: white;
    }
    .content-area {
      margin-left: 250px;
      padding: 30px;
    }
    .text-pink {
      color: #f06292;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        height: auto;
        border-right: none;
      }
      .content-area {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="text-center mb-4">
      <h4 class="text-pink fw-bold">Admin Panel</h4>
    </div>
    <ul class="nav flex-column px-3">
      <li class="nav-item"><a class="nav-link <?= $page === 'produk_admin' ? 'active' : '' ?>" href="dashboard_admin.php?page=produk_admin">📦 Kelola Produk</a></li>
      <li class="nav-item"><a class="nav-link <?= $page === 'tambah_produk' ? 'active' : '' ?>" href="dashboard_admin.php?page=tambah_produk">➕ Tambah Produk</a></li>
      <li class="nav-item"><a class="nav-link <?= $page === 'laporan_penjualan' ? 'active' : '' ?>" href="dashboard_admin.php?page=laporan_penjualan">📊 Laporan Penjualan</a></li>
      <li class="nav-item"><a class="nav-link <?= $page === 'dashboard_analytics' ? 'active' : '' ?>" href="dashboard_admin.php?page=dashboard_analytics">📋 Analitik Dashboard</a></li>
      <li class="nav-item"><a class="nav-link <?= $page === 'daftar_customer' ? 'active' : '' ?>" href="dashboard_admin.php?page=daftar_customer">👥 Daftar Customer</a></li>
      <li class="nav-item"><a class="nav-link <?= $page === 'admin_transaksi' ? 'active' : '' ?>" href="dashboard_admin.php?page=admin_transaksi">📦 Validasi Transaksi</a></li>
      <li class="nav-item"><a class="nav-link text-danger" href="../../controllers/Logout.php">🚪 Logout</a></li>
    </ul>
  </div>

  <div class="content-area">
    <?php
    if (in_array($page, $adminPages)) {
        $filePath = "pages/{$page}.php";
        if (file_exists($filePath)) {
            include $filePath;
        } else {
            echo "<div class='text-center text-danger'><h4>Halaman <strong>$page</strong> tidak ditemukan.</h4></div>";
        }
    } else {
        echo "<div class='text-center text-danger'><h4>Akses ditolak untuk halaman <strong>$page</strong>.</h4></div>";
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
