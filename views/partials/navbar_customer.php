<?php
$base_url = '/Rekayasa_E-bisnis_KELOMPOK-4/views/pelanggan/';
$brand_href = $base_url . 'home_login.php';
$beranda_href = $base_url . 'home_login.php';
$katalog_href = $base_url . 'katalog.php';
$keranjang_href = $base_url . 'keranjang.php';
$riwayat_href = $base_url . 'riwayat.php';
$profil_href = $base_url . 'profil.php';
$logout_href = '/Rekayasa_E-bisnis_KELOMPOK-4/controllers/logout.php';
$login_href = '/Rekayasa_E-bisnis_KELOMPOK-4/auth/login.php';
$registrasi_href = '/Rekayasa_E-bisnis_KELOMPOK-4/auth/registrasi.php';
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-pink" href="<?php echo $brand_href; ?>">Bucketminiku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?php echo $beranda_href; ?>">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $katalog_href; ?>">Katalog</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $keranjang_href; ?>">Keranjang</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $riwayat_href; ?>">Riwayat</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $profil_href; ?>">Profil</a></li>
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
