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
              <h5 class="card-title text-center text-pink"><?= htmlspecialchars($p['nama_produk']) ?></h5>
              <p class="fw-semibold text-muted text-center">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
              <a href="produk_detail.php?id_produk=<?= $p['id'] ?>" target="_blank" class="btn btn-beli w-100 d-block text-center text-decoration-none">BELI</a>
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
          <h5 class="mb-2">Live Chat</h5>
          <p class="mb-2">Hubungi admin untuk bantuan.</p>
          <a href="../chat.php" class="btn btn-outline-pink btn-sm">Buka Chat</a>
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
<script>
  document.querySelectorAll('.btn-keranjang').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      var form = btn.closest('.keranjang-form');
      var formData = new FormData(form);
      fetch('../../controllers/keranjangController.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showToast('Produk berhasil dimasukkan ke keranjang!');
        } else {
          showToast('Gagal menambah ke keranjang!', true);
        }
      })
      .catch(() => showToast('Terjadi kesalahan!', true));
    });
  });

  function showToast(msg, error = false) {
    let toast = document.createElement('div');
    toast.className = 'toast-keranjang ' + (error ? 'bg-danger' : 'bg-success');
    toast.textContent = msg;
    toast.style.cssText = 'position:fixed;top:24px;right:24px;z-index:9999;padding:12px 24px;color:#fff;border-radius:8px;font-weight:600;box-shadow:0 2px 12px #eee;';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
  }

  // Fitur -+ jumlah produk di home
  const minusBtns = document.querySelectorAll('.btn-minus');
  const plusBtns = document.querySelectorAll('.btn-plus');
  const jumlahInputs = document.querySelectorAll('.jumlah-input');

  function syncJumlah(id, jumlah) {
    // Untuk keranjang
    const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
    if (input) input.value = jumlah;
  }

  minusBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
      let val = parseInt(input.value);
      if (val > 1) {
        val--;
        input.value = val;
        syncJumlah(id, val);
      }
    });
  });
  plusBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
      let val = parseInt(input.value);
      val++;
      input.value = val;
      syncJumlah(id, val);
    });
  });
  jumlahInputs.forEach(input => {
    input.addEventListener('change', function() {
      const id = this.dataset.id;
      let val = parseInt(this.value);
      if (val > 0) {
        syncJumlah(id, val);
      }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
.toast-keranjang { transition:all .3s; opacity:0.95; }
</style>
</body>
</html>

