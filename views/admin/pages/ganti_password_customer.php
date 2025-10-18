<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = ? WHERE id_users = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $hash, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard_admin.php?page=daftar_customer&msg=success");
    } else {
        echo "<div class='alert alert-danger'>Gagal ganti password.</div>";
    }
}
?>

<div class="container mt-4">
  <h3 class="fw-bold text-secondary">🔐 Ganti Password Customer</h3>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Password Baru</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Ganti Password</button>
    <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-secondary">Batal</a>
  </form>
</div>

