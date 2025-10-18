<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Syarat & Ketentuan - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Syarat dan Ketentuan Penggunaan Website</h1>
    <div class="row">
      <div class="col-md-12">
        <h3>Penggunaan Umum</h3>
        <p>Dengan mengakses dan menggunakan situs web Bucketminiku, Anda setuju untuk mematuhi syarat dan ketentuan ini. Jika Anda tidak setuju, silakan jangan gunakan situs web kami.</p>
        
        <h3>Pendaftaran dan Akun</h3>
        <ul>
          <li>Anda harus berusia minimal 18 tahun atau memiliki persetujuan orang tua/wali untuk mendaftar akun.</li>
          <li>Informasi yang diberikan harus akurat dan lengkap. Anda bertanggung jawab atas kerahasiaan password akun Anda.</li>
          <li>Bucketminiku berhak menangguhkan atau menghapus akun yang melanggar ketentuan.</li>
        </ul>
        
        <h3>Pesanan dan Pembayaran</h3>
        <ul>
          <li>Semua pesanan bersifat final setelah konfirmasi pembayaran.</li>
          <li>Kami tidak bertanggung jawab atas kesalahan alamat pengiriman yang diberikan oleh pelanggan.</li>
          <li>Pembayaran harus dilakukan melalui metode yang disediakan, dan bukti transfer harus diunggah.</li>
        </ul>
        
        <h3>Pengiriman dan Pengembalian</h3>
        <ul>
          <li>Waktu pengiriman tergantung pada lokasi dan ketersediaan produk.</li>
          <li>Pengembalian hanya diterima untuk produk yang rusak atau salah kirim, dalam waktu 24 jam setelah penerimaan.</li>
          <li>Biaya pengiriman tidak dapat dikembalikan.</li>
        </ul>
        
        <h3>Hak Kekayaan Intelektual</h3>
        <p>Semua konten di situs web ini, termasuk teks, gambar, dan desain, adalah milik Bucketminiku dan dilindungi oleh hukum hak cipta.</p>
        
        <h3>Penafian</h3>
        <p>Bucketminiku tidak bertanggung jawab atas kerugian tidak langsung yang timbul dari penggunaan situs web ini.</p>
        
        <p>Ketentuan ini dapat diubah sewaktu-waktu tanpa pemberitahuan sebelumnya. Penggunaan situs web setelah perubahan berarti Anda menerima ketentuan baru.</p>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 Bucketminiku | WhatsApp: 0812-XXXX-XXXX | Instagram: @Bucketminiku
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

