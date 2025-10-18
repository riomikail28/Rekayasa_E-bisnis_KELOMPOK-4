<?php
session_start();
require_once '../../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id = intval($_SESSION['user_id']);
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $file = $_FILES['foto'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $error = "Format file tidak didukung. Gunakan JPG, PNG, atau GIF.";
    } elseif ($file['size'] > 2 * 1024 * 1024) {
        $error = "Ukuran file terlalu besar. Maksimal 2MB.";
    } elseif ($file['error'] !== 0) {
        $error = "Terjadi kesalahan saat upload.";
    } else {
        $filename = 'user_' . $id . '_' . time() . '.' . $ext;
        $target = '../../uploads/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $update = mysqli_prepare($conn, "UPDATE users SET foto = ? WHERE id_users = ?");
            mysqli_stmt_bind_param($update, "si", $filename, $id);
            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);
            $success = "Foto berhasil diunggah.";
        } else {
            $error = "Gagal menyimpan file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Foto - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <h3 class="text-center mb-4 fw-bold">Upload Foto Profil</h3>

          <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Pilih Foto</label>
              <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.gif" required>
            </div>
            <button type="submit" class="btn btn-upload-blue w-100">Upload</button>
          </form>

          <div class="text-center mt-4">
            <a href="profil.php" class="btn btn-outline-secondary">Kembali ke Profil</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

