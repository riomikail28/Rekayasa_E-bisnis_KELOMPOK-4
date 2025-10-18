<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Testimoni Pelanggan - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Testimoni Pelanggan</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <p class="card-text">"Buket yang dipesan sangat indah dan segar. Pengiriman tepat waktu. Terima kasih Bucketminiku!"</p>
            <footer class="blockquote-footer">Ani, Jakarta</footer>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <p class="card-text">"Layanan pelanggan ramah dan responsif. Buket hadiah untuk ulang tahun suami sangat memuaskan."</p>
            <footer class="blockquote-footer">Sari, Bandung</footer>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <p class="card-text">"Harga terjangkau dengan kualitas premium. Akan pesan lagi untuk acara spesial."</p>
            <footer class="blockquote-footer">Rudi, Surabaya</footer>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 Bucketminiku | WhatsApp: 0812-XXXX-XXXX | Instagram: @bucketminiku
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

