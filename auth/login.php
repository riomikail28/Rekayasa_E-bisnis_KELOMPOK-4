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
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Login</h2>
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
    <button type="submit" name="login" class="btn btn-pink">Login</button>
  </form>
</body>
</html>
