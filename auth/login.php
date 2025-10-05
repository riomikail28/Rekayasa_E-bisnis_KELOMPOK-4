<?php
session_start();
require_once '../helpers/auth.php';

if (isset($_POST['login'])) {
    $role = loginUser($_POST['username'], $_POST['password']);

    if ($role === 'admin') {
        header("Location: ../views/admin/dashboard_admin.php");
        exit;
    } elseif ($role === 'pelanggan') {
        header("Location: ../views/pelanggan/dashboard_pelanggan.php");
        exit;
    } else {
        $error = "Username atau password salah.";
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
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-wrapper {
      display: flex;
      height: 100vh;
    }
    .left-panel {
      flex: 1;
      background-color: #fff;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .right-panel {
      flex: 1;
      background: linear-gradient(to bottom right, #ff7e5f, #ff6ec4);
      color: white;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .logo {
      width: 80px;
      margin-bottom: 20px;
    }
    .btn-pink {
      background: linear-gradient(to right, #ff7e5f, #ff6ec4);
      color: white;
      border: none;
    }
    .btn-outline-pink {
      border: 1px solid #ff6ec4;
      color: #ff6ec4;
      background-color: transparent;
    }
    .form-control {
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="left-panel">
      <img src="../uploads/logo_bucketminiku.jpg" alt="Buketminiku Logo" class="logo">
      <h4 class="fw-bold">We are Buketminiku</h4>
      <p class="text-muted mb-4">Please login to your account.</p>

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
        <button type="submit" name="login" class="btn btn-pink w-100 mb-2">LOG IN</button>
        <div class="text-end">
          <a href="#" class="text-muted">Forgot password?</a>
        </div>
      </form>

      <hr>
      <div class="text-center">
        <span class="text-muted">Don't have an account?</span>
        <a href="registrasi.php" class="btn btn-outline-pink ms-2">CREATE NEW</a>
      </div>
    </div>

    <div class="right-panel text-center">
      <h2 class="fw-bold">We are more than just a company.</h2>
      <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
  </div>
</body>
</html>
