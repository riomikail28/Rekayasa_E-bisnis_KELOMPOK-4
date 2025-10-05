<?php
require_once __DIR__'../../../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID customer tidak ditemukan.</div>";
  exit;
}

$query = "UPDATE users SET status = 'Aktif' WHERE id = $id AND role = 'pelanggan'";
if (mysqli_query($conn, $query)) {
  echo "<div class='alert alert-success'>Customer berhasil diaktifkan kembali.</div>";
} else {
  echo "<div class='alert alert-danger'>Gagal mengaktifkan customer.</div>";
}
?>
<div class="container mt-3">
  <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-outline-pink">Kembali ke Daftar Customer</a>
</div>
