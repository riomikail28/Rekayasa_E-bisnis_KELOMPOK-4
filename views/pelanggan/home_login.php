<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../../config/koneksi.php';

// Pastikan hanya pelanggan yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pelanggan') {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_users'] ?? null;
$username = $_SESSION['username'] ?? 'Pelanggan';

// Fetch first 4 products for preview
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC LIMIT 4");
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bucketminiku | Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
  <link rel="stylesheet" href="../../assets/css/profil.css">
  <style>
    /* Small enhancements untuk tampilan e-commerce yang menarik */
    .hero { background: linear-gradient(90deg, #fff0f3 0%, #fff 100%); padding: 40px 0; }
    .text-pink { color: #ff4d7e; }
    .btn-pink { background-color: #ff4d7e; color: #fff; border: none; }
    .btn-pink:hover{ background-color:#ff2b61 }
    .card-summary { border-radius: 12px; }
    .produk-card img { height: 180px; object-fit: cover; border-top-left-radius:12px; border-top-right-radius:12px }
    .badge-status { font-size: 0.9rem; padding: 0.45rem 0.6rem; }
  </style>
</head>
<body class="bg-light">

<?php include '../partials/navbar_customer.php'; ?>

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(90deg, #fff0f3 0%, #f06292 100%); padding: 40px 0;">
  <div class="container">
    <h1 class="display-5 fw-bold">Selamat Datang di Bucketminiku</h1>
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

<!-- Informasi & Layanan Section -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Informasi & Layanan</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#128218;</span></div>
          <h5 class="mb-2">Tentang Kami</h5>
          <p class="mb-2">Pelajari visi dan misi perusahaan kami.</p>
          <a href="/Rekayasa_E-bisnis_KELOMPOK-4/views/tentang_kami.php" class="btn btn-outline-pink btn-sm">Baca Lebih Lanjut</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#10067;</span></div>
          <h5 class="mb-2">FAQ</h5>
          <p class="mb-2">Pertanyaan umum tentang layanan kami.</p>
          <a href="/Rekayasa_E-bisnis_KELOMPOK-4/views/faq.php" class="btn btn-outline-pink btn-sm">Lihat FAQ</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#127873;</span></div>
          <h5 class="mb-2">Promo</h5>
          <p class="mb-2">Daftar promo dan diskon terbaru.</p>
          <a href="/Rekayasa_E-bisnis_KELOMPOK-4/views/promo.php" class="btn btn-outline-pink btn-sm">Lihat Promo</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#128172;</span></div>
          <h5 class="mb-2">Testimoni</h5>
          <p class="mb-2">Ulasan dari pelanggan kami.</p>
          <a href="/Rekayasa_E-bisnis_KELOMPOK-4/views/testimoni.php" class="btn btn-outline-pink btn-sm">Baca Testimoni</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 Bucketminiku | WhatsApp: 0812-XXXX-XXXX | Instagram: @Bucketminiku.id
</footer>

<style>
  .produk-card:hover, .info-card:hover {
    box-shadow: 0 0 16px #ffb6c1;
    transform: translateY(-4px);
    transition: box-shadow 0.2s, transform 0.2s;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

