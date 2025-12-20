<?php
require_once __DIR__ . '/../../../models/diskonModel.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID diskon tidak ditemukan.</div>";
  exit;
}

$diskon = getDiskonById($id);

if (!$diskon) {
  echo "<div class='alert alert-danger'>Diskon tidak ditemukan.</div>";
  exit;
}

if (deleteDiskon($id)) {
  echo "<div class='alert alert-success'>Kode diskon berhasil dihapus.</div>";
} else {
  echo "<div class='alert alert-danger'>Gagal menghapus kode diskon.</div>";
}
?>
<div class="container mt-3">
  <a href="../dashboard_admin.php?page=daftar_diskon" class="btn btn-outline-pink">Kembali ke Daftar Diskon</a>
</div>
