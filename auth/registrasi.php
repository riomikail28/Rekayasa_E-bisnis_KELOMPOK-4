<?php
session_start();
require_once '../helpers/auth.php';

if (isset($_POST['register'])) {
    if (registerUser($_POST)) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Registrasi gagal.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrasi Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Daftar Akun Pelanggan</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nama Lengkap</label>
      <input type="text" name="nama_lengkap" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" name="register" class="btn btn-pink">Daftar</button>
  </form>
</body>
</html>
