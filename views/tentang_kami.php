<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang Kami - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Tentang Kami</h1>
    <div class="row">
      <div class="col-md-6">
        <h3>Visi</h3>
        <p>Menjadi penyedia bunga dan hadiah terdepan di Indonesia yang menghadirkan kebahagiaan dan cinta melalui produk berkualitas tinggi.</p>
      </div>
      <div class="col-md-6">
        <h3>Misi</h3>
        <ul>
          <li>Menyediakan produk bunga dan hadiah yang berkualitas dan inovatif.</li>
          <li>Memberikan pelayanan pelanggan yang ramah dan profesional.</li>
          <li>Mendorong kreativitas dalam setiap rangkaian bunga dan hadiah.</li>
          <li>Menjaga kepuasan pelanggan sebagai prioritas utama.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 Bucketminiku | WhatsApp: 0812-XXXX-XXXX | Instagram: https://www.instagram.com/Bucketminiku/
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

