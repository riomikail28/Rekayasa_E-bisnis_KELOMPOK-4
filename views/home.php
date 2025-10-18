<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bucketminiku | Toko Bunga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

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
      <!-- Card 1 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket1.jpg" class="card-img-top" alt="Buket Bunga">
          <div class="card-body">
            <h5 class="card-title">Buket Mawar Merah</h5>
            <p class="card-text">Rp 99.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket2.jpg" class="card-img-top" alt="Buket Snack">
          <div class="card-body">
            <h5 class="card-title">Buket Snack & Minuman</h5>
            <p class="card-text">Rp 85.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket3.jpg" class="card-img-top" alt="Buket Boneka">
          <div class="card-body">
            <h5 class="card-title">Buket Boneka & Bunga</h5>
            <p class="card-text">Rp 120.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-md-3">
        <div class="card produk-card shadow-sm">
          <img src="uploads/buket4.jpg" class="card-img-top" alt="Buket Uang">
          <div class="card-body">
            <h5 class="card-title">Buket Uang Kreatif</h5>
            <p class="card-text">Rp 150.000</p>
            <a href="#" class="btn btn-pink w-100">Beli</a>
          </div>
        </div>
      </div>
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
          <a href="tentang_kami.php" class="btn btn-outline-pink btn-sm">Baca Lebih Lanjut</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#10067;</span></div>
          <h5 class="mb-2">FAQ</h5>
          <p class="mb-2">Pertanyaan umum tentang layanan kami.</p>
          <a href="faq.php" class="btn btn-outline-pink btn-sm">Lihat FAQ</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#127873;</span></div>
          <h5 class="mb-2">Promo</h5>
          <p class="mb-2">Daftar promo dan diskon terbaru.</p>
          <a href="promo.php" class="btn btn-outline-pink btn-sm">Lihat Promo</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm info-card text-center p-3">
          <div class="mb-2"><span style="font-size:2rem; color:#ff4d7e;">&#128172;</span></div>
          <h5 class="mb-2">Testimoni</h5>
          <p class="mb-2">Ulasan dari pelanggan kami.</p>
          <a href="testimoni.php" class="btn btn-outline-pink btn-sm">Baca Testimoni</a>
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

