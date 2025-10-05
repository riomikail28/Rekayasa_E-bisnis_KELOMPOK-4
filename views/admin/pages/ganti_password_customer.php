<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID customer tidak ditemukan.</div>";
  exit;
}

if (isset($_POST['submit'])) {
  $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $query = "UPDATE users SET password = '$newPassword' WHERE id = $id AND role = 'pelanggan'";
  if (mysqli_query($conn, $query)) {
    echo "<div class='alert alert-success'>Password berhasil diubah.</div>";
  } else {
    echo "<div class='alert alert-danger'>Gagal mengubah password.</div>";
  }
}
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">🔒 Ganti Password Customer</h3>
  <form method="POST">
    <div class="mb-3">
      <label>Password Baru</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" name="submit" class="btn btn-pink">Simpan Password</button>
  </form>
</div>
