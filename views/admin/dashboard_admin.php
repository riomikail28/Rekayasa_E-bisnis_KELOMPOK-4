<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit;
}

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
    'ganti_password_customer'
];

$page = $_GET['page'] ?? 'produk_admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
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
    }
    .sidebar .nav-link {
      color: #333;
    }
    .sidebar .nav-link:hover {
      background-color: #f06292;
      color: white;
    }
    .content-area {
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 sidebar p-3">
        <h4 class="text-pink fw-bold mb-4">Admin Panel</h4>
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link" href="dashboard_admin.php?page=produk_admin">📦 Kelola Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard_admin.php?page=tambah_produk">➕ Tambah Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard_admin.php?page=laporan_penjualan">📊 Laporan Penjualan</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard_admin.php?page=daftar_customer">👥 Daftar Customer</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="../../controllers/Logout.php">🚪 Logout</a></li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 content-area">
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
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
