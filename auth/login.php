<?php
session_start();
require_once '../helpers/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $role = loginUser($username, $password);

        if ($role === 'admin') {
            header("Location: ../views/admin/dashboard_admin.php");
            exit;
        } elseif ($role === 'pelanggan') {
            header("Location: ../views/pelanggan/home_login.php");
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Mohon isi semua field.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Buketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #ffecd2, #fcb69f);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-pink {
      background: linear-gradient(to right, #ff7e5f, #ff6ec4);
      color: white;
      border: none;
    }
    .btn-pink:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <h3 class="text-center mb-4 fw-bold">Login ke Buketminiku</h3>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-pink w-100">LOG IN</button>
          </form>

          <div class="text-center mt-3">
            <span class="text-muted">Belum punya akun?</span>
            <a href="registrasi.php" class="text-decoration-none text-primary fw-semibold">Daftar di sini</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
