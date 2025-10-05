<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id = intval($_SESSION['user_id']);
$result = mysqli_query($conn, "SELECT * FROM users WHERE id_users = $id");

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-danger text-center mt-5'>Data pengguna tidak ditemukan.</div>";
    exit;
}

$user = mysqli_fetch_assoc($result);

// Proses upload foto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_foto']) && isset($_FILES['foto'])) {
    $file = $_FILES['foto'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo "<div class='alert alert-danger text-center'>Format file tidak didukung.</div>";
    } elseif ($file['size'] > 2 * 1024 * 1024) {
        echo "<div class='alert alert-danger text-center'>Ukuran file maksimal 2MB.</div>";
    } elseif ($file['error'] !== 0) {
        echo "<div class='alert alert-danger text-center'>Terjadi kesalahan saat upload.</div>";
    } else {
        // Pastikan folder uploads tersedia
        $uploadDir = '../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = 'user_' . $id . '_' . time() . '.' . $ext;
        $target = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $update = mysqli_prepare($conn, "UPDATE users SET foto = ? WHERE id_users = ?");
            mysqli_stmt_bind_param($update, "si", $filename, $id);
            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);
            echo "<div class='alert alert-success text-center'>Foto berhasil diperbarui.</div>";
            // Refresh data
            $result = mysqli_query($conn, "SELECT * FROM users WHERE id_users = $id");
            $user = mysqli_fetch_assoc($result);
        } else {
            echo "<div class='alert alert-danger text-center'>Gagal menyimpan file.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya - Buketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-edit {
      background-color: #ff6ec4;
      color: white;
      border: none;
    }
    .btn-edit1 {
      background-color: rgb(217, 255, 0);
      color: white;
      border: none;
    }
    .btn-edit:hover, .btn-edit1:hover {
      opacity: 0.9;
    }
    img.rounded-circle {
      border: 4px solid #ff6ec4;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      object-fit: cover;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4">
          <h3 class="text-center mb-4 fw-bold">Profil Pengguna</h3>

          <?php
          $foto = $user['foto'] ?? '';
          $fotoPath = $foto ? "../../uploads/$foto" : "../../assets/default-user.png";
          ?>

          <div class="text-center mb-4">
            <img src="<?= $fotoPath ?>" alt="Foto Profil" class="rounded-circle" width="140" height="140">
            <form method="POST" enctype="multipart/form-data" class="mt-3">
              <div class="mb-2">
                <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.gif" required>
              </div>
              <button type="submit" name="upload_foto" class="btn btn-sm btn-outline-primary">Ganti Foto</button>
            </form>
          </div>

          <table class="table table-bordered">
            <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
            <tr><th>Nama Lengkap</th><td><?= htmlspecialchars($user['nama_lengkap']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($user['email'] ?? '-') ?></td></tr>
            <tr><th>No HP</th><td><?= htmlspecialchars($user['no_hp'] ?? '-') ?></td></tr>
            <tr><th>Jenis Kelamin</th><td><?= htmlspecialchars($user['jenis_kelamin'] ?? '-') ?></td></tr>
            <tr><th>Tanggal Lahir</th><td><?= htmlspecialchars($user['tanggal_lahir'] ?? '-') ?></td></tr>
            <tr><th>Role</th><td><?= htmlspecialchars($user['role']) ?></td></tr>
          </table>

          <div class="text-center mt-4">
            <a href="../../controllers/logout.php" class="btn btn-outline-danger">Logout</a>
            <a href="edit_profil.php" class="btn btn-edit ms-2">Edit Profil</a>
            <a href="home_login.php" class="btn btn-edit1 ms-2">Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
