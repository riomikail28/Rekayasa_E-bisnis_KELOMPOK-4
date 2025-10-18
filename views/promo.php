<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Promo & Diskon - BucketMiniku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Promo & Diskon Berlangsung</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Diskon 20% untuk Buket Mawar</h5>
            <p class="card-text">Berlaku hingga 31 Desember 2025. Minimal pembelian Rp 100.000.</p>
            <span class="badge bg-success">Aktif</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Gratis Ongkir untuk Kota Jakarta</h5>
            <p class="card-text">Berlaku untuk pesanan di atas Rp 150.000. Kode: JAKARTA20</p>
            <span class="badge bg-success">Aktif</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Buy 1 Get 1 Free Boneka</h5>
            <p class="card-text">Untuk pembelian buket dengan boneka. Berlaku hingga stok habis.</p>
            <span class="badge bg-success">Aktif</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 BucketMiniku | WhatsApp: 0812-XXXX-XXXX | Instagram: @bucketminiku
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

