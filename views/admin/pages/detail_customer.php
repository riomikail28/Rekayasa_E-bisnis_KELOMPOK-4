<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID customer tidak ditemukan.</div>";
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id AND role = 'pelanggan'");
$customer = mysqli_fetch_assoc($result);

if (!$customer) {
  echo "<div class='alert alert-danger'>Customer tidak ditemukan.</div>";
  exit;
}
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">👤 Detail Pelanggan</h3>
  <table class="table table-bordered">
    <tr><th>Username</th><td><?= $customer['username'] ?></td></tr>
    <tr><th>Status</th><td><?= $customer['status'] ?? 'Aktif' ?></td></tr>
    <tr><th>Email</th><td><?= $customer['email'] ?? '-' ?></td></tr>
    <tr><th>Alamat</th><td><?= $customer['alamat'] ?? '-' ?></td></tr>
  </table>
  <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-outline-pink">Kembali</a>
</div>
