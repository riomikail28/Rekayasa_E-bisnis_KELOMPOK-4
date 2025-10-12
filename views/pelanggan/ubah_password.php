<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_users'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id = intval($_SESSION['id_users']);
$result = mysqli_query($conn, "SELECT password FROM users WHERE id_users = $id");

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-danger text-center mt-5'>Data pengguna tidak ditemukan.</div>";
    exit;
}

$user = mysqli_fetch_assoc($result);
$success = '';
$error = '';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = trim($_POST['current_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (!$current_password || !$new_password || !$confirm_password) {
        $error = "Semua field wajib diisi.";
    } elseif (!password_verify($current_password, $user['password'])) {
        $error = "Password lama salah.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Password baru dan konfirmasi tidak cocok.";
    } elseif (strlen($new_password) < 6) {
        $error = "Password baru minimal 6 karakter.";
    } else {
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id_users = ?");
        mysqli_stmt_bind_param($update, "si", $hashed_new_password, $id);
        $success = mysqli_stmt_execute($update) ? "✅ Password berhasil diubah." : "❌ Gagal mengubah password.";
        mysqli_stmt_close($update);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ubah Password - Buketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/profil.css">
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4">
          <h3 class="text-center mb-4 fw-bold">Ubah Password</h3>

          <?php if ($success): ?>
            <div class="alert alert-success text-center"><?= $success ?></div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Password Lama</label>
              <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password Baru</label>
              <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-save w-100">🔒 Ubah Password</button>
          </form>

          <div class="text-center mt-4">
            <a href="profil.php" class="btn btn-back">← Kembali ke Profil</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
