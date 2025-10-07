<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_lengkap'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';

    $query = "UPDATE users SET nama_lengkap = ?, email = ?, no_hp = ? WHERE id_users = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $nama, $email, $no_hp, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard_admin.php?page=daftar_customer&msg=success");
    } else {
        echo "<div class='alert alert-danger'>Gagal update data.</div>";
    }
}

// Ambil data lama
$query = "SELECT * FROM users WHERE id_users = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
  <h3 class="fw-bold text-primary">✏️ Edit Customer</h3>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">No HP</label>
      <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']) ?>">
    </div>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-secondary">Batal</a>
  </form>
</div>
