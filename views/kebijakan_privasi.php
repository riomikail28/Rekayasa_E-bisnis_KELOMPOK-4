<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kebijakan Privasi - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- Content -->
<section class="py-5">
  <div class="container">
    <h1 class="text-center mb-4">Kebijakan Privasi</h1>
    <div class="row">
      <div class="col-md-12">
        <p>Kebijakan privasi ini menjelaskan bagaimana Bucketminiku mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan situs web kami.</p>
        
        <h3>Informasi yang Kami Kumpulkan</h3>
        <ul>
          <li>Informasi pribadi: Nama, alamat email, nomor telepon, alamat pengiriman yang Anda berikan saat mendaftar atau melakukan pesanan.</li>
          <li>Informasi teknis: Alamat IP, jenis browser, halaman yang dikunjungi, dan data cookie untuk meningkatkan pengalaman pengguna.</li>
        </ul>
        
        <h3>Penggunaan Informasi</h3>
        <ul>
          <li>Memproses pesanan dan pengiriman produk.</li>
          <li>Mengirimkan konfirmasi pesanan, pembaruan pengiriman, dan informasi promosi.</li>
          <li>Meningkatkan situs web dan layanan kami berdasarkan analisis penggunaan.</li>
          <li>Mematuhi persyaratan hukum dan melindungi hak kami.</li>
        </ul>
        
        <h3>Berbagi Informasi</h3>
        <p>Kami tidak menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga. Informasi hanya dibagikan kepada penyedia layanan pengiriman dan pembayaran yang diperlukan untuk menyelesaikan pesanan Anda.</p>
        
        <h3>Keamanan Data</h3>
        <p>Kami menggunakan langkah-langkah keamanan standar industri untuk melindungi informasi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran.</p>
        
        <h3>Hak Anda</h3>
        <ul>
          <li>Akses dan memperbarui informasi pribadi Anda melalui akun Anda.</li>
          <li>Meminta penghapusan data Anda, sesuai dengan hukum yang berlaku.</li>
          <li>Menolak pemasaran langsung kapan saja.</li>
        </ul>
        
        <h3>Perubahan Kebijakan</h3>
        <p>Kebijakan ini dapat diperbarui sewaktu-waktu. Perubahan akan diberitahukan melalui situs web atau email.</p>
        
        <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, hubungi kami di support@Bucketminiku.com.</p>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center py-3 mt-5" style="background-color: #ffb6c1;">
  &copy; 2025 Bucketminiku | WhatsApp: 0812-XXXX-XXXX | Instagram: @Bucketminiku.id
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

