<?php
$base_url = '/Rekayasa_E-bisnis_KELOMPOK-4/';
$brand_href = (isset($_SESSION['role']) && $_SESSION['role'] === 'pelanggan') ? $base_url . 'views/pelanggan/home_login.php' : $base_url . 'index.php';
$beranda_href = $brand_href;
$logout_href = $base_url . 'controllers/logout.php';
$login_href = $base_url . 'auth/login.php';
$registrasi_href = $base_url . 'auth/registrasi.php';
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-pink" href="<?php echo $brand_href; ?>">Bucketminiku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $beranda_href; ?>">Beranda</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Informasi
            </a>
            <ul class="dropdown-menu" aria-labelledby="informasiDropdown">
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>views/tentang_kami.php">Tentang Kami</a></li>
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>views/kontak_kami.php">Kontak Kami</a></li>
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>views/faq.php">FAQ</a></li>
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>views/syarat_ketentuan.php">Syarat & Ketentuan</a></li>
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>views/kebijakan_privasi.php">Kebijakan Privasi</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_url; ?>views/promo.php">Promo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_url; ?>views/wishlist.php">Wishlist</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_url; ?>views/testimoni.php">Testimoni</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_url; ?>views/blog.php">Blog</a>
          </li>
          <?php if (isset($_SESSION['role'])): ?>
            <li class="nav-item">
              <a class="btn btn-outline-danger" href="<?php echo $logout_href; ?>">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="btn btn-outline-pink me-2" href="<?php echo $login_href; ?>">Login</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-pink" href="<?php echo $registrasi_href; ?>">Daftar</a>
            </li>
          <?php endif; ?>
        </ul>
    </div>
  </div>
</nav>
