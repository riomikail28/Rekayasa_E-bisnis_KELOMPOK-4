<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID produk tidak ditemukan.</div>";
  exit;
}

$query = "DELETE FROM detail_transaksi WHERE id_produk = $id";
if (mysqli_query($conn, $query)) {
  $query2 = "DELETE FROM produk WHERE id = $id";
  if (mysqli_query($conn, $query2)) {
    echo "<div class='alert alert-success'>Produk berhasil dihapus.</div>";
  } else {
    echo "<div class='alert alert-danger'>Gagal menghapus produk.</div>";
  }
} else {
  echo "<div class='alert alert-danger'>Gagal menghapus detail transaksi terkait.</div>";
}
?>
<div class="container mt-3">
  <a href="dashboard_admin.php" class="btn btn-outline-pink">Kembali ke Daftar Produk</a>
</div>

