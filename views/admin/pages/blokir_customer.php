<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID customer tidak ditemukan.</div>";
  exit;
}

$query = "UPDATE users SET status = 'Blokir' WHERE id = $id AND role = 'pelanggan'";
if (mysqli_query($conn, $query)) {
  echo "<div class='alert alert-warning'>Customer berhasil diblokir.</div>";
} else {
  echo "<div class='alert alert-danger'>Gagal memblokir customer.</div>";
}
?>
<div class="container mt-3">
  <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-outline-pink">Kembali ke Daftar Customer</a>
</div>
