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
    'pengaturan_website',
    'laporan_keuangan',
    'manajemen_pengiriman',
    'manajemen_stok',
];

$page = $_GET['page'] ?? 'produk_admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin | Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="../../assets/css/admin.css?v=2">
</head>
<body>
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top" style="background: #f06292;">
    <div class="container-fluid">
      <button class="btn btn-outline-light me-3" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
      <a class="navbar-brand fw-bold" href="#">Bucketminiku Admin</a>

      <div class="d-flex">
        <div class="dropdown">
          <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user me-2"></i>Admin
          </button>
          <ul class="dropdown-menu" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="../../controllers/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar" style="background: #f06292;">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
      <h5 class="text-white mb-0">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
      </h5>
      <button class="btn btn-sm btn-outline-light sidebar-hide-btn" id="sidebarHideBtn" title="Hide Sidebar">
        <i class="fas fa-angle-left"></i>
      </button>
    </div>
    <button class="btn btn-sm btn-outline-light sidebar-show-btn" id="sidebarShowBtn" title="Show Sidebar" style="cursor: pointer; background: #f06292;">
      <i class="fas fa-angle-right"></i>
    </button>
    <ul class="nav flex-column px-3">
      <li class="nav-item">
        <a class="nav-link <?= $page === 'produk_admin' ? 'active' : '' ?>" href="dashboard_admin.php?page=produk_admin">
          <i class="fas fa-box me-2"></i>Kelola Produk
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'tambah_produk' ? 'active' : '' ?>" href="dashboard_admin.php?page=tambah_produk">
          <i class="fas fa-plus me-2"></i>Tambah Produk
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'laporan_penjualan' ? 'active' : '' ?>" href="dashboard_admin.php?page=laporan_penjualan">
          <i class="fas fa-chart-line me-2"></i>Laporan Penjualan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'dashboard_analytics' ? 'active' : '' ?>" href="dashboard_admin.php?page=dashboard_analytics">
          <i class="fas fa-chart-bar me-2"></i>Analitik Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'daftar_customer' ? 'active' : '' ?>" href="dashboard_admin.php?page=daftar_customer">
          <i class="fas fa-users me-2"></i>Daftar Customer
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'admin_transaksi' ? 'active' : '' ?>" href="dashboard_admin.php?page=admin_transaksi">
          <i class="fas fa-shopping-cart me-2"></i>Validasi Transaksi
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'pengaturan_website' ? 'active' : '' ?>" href="dashboard_admin.php?page=pengaturan_website">
          <i class="fas fa-cog me-2"></i>Pengaturan Website
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'laporan_keuangan' ? 'active' : '' ?>" href="dashboard_admin.php?page=laporan_keuangan">
          <i class="fas fa-dollar-sign me-2"></i>Laporan Keuangan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'manajemen_pengiriman' ? 'active' : '' ?>" href="dashboard_admin.php?page=manajemen_pengiriman">
          <i class="fas fa-truck me-2"></i>Manajemen Pengiriman
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $page === 'manajemen_stok' ? 'active' : '' ?>" href="dashboard_admin.php?page=manajemen_stok">
          <i class="fas fa-warehouse me-2"></i>Manajemen Stok
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="content-area" id="content">
    <?php if ($page === 'produk_admin'): ?>
      <!-- Dashboard Overview Cards -->
      <div class="row mb-4">
        <?php
        require_once '../../config/koneksi.php';

        // Get total products
        $total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM produk"))['total'];

        // Get total customers
        $total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'pelanggan'"))['total'];

        // Get total transactions
        $total_transactions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi"))['total'];

        // Get total revenue
        $total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi WHERE status = 'dibayar'"))['total'] ?? 0;
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_products; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-box fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Customer</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_customers; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Transaksi</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_transactions; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pendapatan</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

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
  <script>
    // Sidebar toggle functionality
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('content').classList.toggle('expanded');
    });

    // Sidebar hide button functionality
    document.getElementById('sidebarHideBtn').addEventListener('click', function() {
      document.getElementById('sidebar').classList.add('collapsed');
      document.getElementById('content').classList.add('expanded');
    });

    // Sidebar show button functionality
    document.getElementById('sidebarShowBtn').addEventListener('click', function() {
      document.getElementById('sidebar').classList.remove('collapsed');
      document.getElementById('content').classList.remove('expanded');
    });
  </script>
</body>
</html>

