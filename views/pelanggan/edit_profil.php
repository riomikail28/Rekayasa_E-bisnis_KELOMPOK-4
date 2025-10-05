<?php
session_start();
require_once '../../config/koneksi.php';

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
$success = '';
$error = '';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_lengkap'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');
    $jenis    = $_POST['jenis_kelamin'] ?? '';
    $tanggal  = $_POST['tanggal_lahir'] ?? '';

    if ($nama && $email) {
        $update = mysqli_prepare($conn, "UPDATE users SET nama_lengkap = ?, email = ?, no_hp = ?, jenis_kelamin = ?, tanggal_lahir = ? WHERE id_users = ?");
        mysqli_stmt_bind_param($update, "sssssi", $nama, $email, $no_hp, $jenis, $tanggal, $id);
        $success = mysqli_stmt_execute($update) ? "Profil berhasil diperbarui." : "Gagal memperbarui profil.";
        mysqli_stmt_close($update);
    } else {
        $error = "Nama dan email wajib diisi.";
    }

    // Refresh data
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id_users = $id");
    $user = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil - Buketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #e0eafc, #cfdef3);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-save {
      background-color: #4facfe;
      color: white;
      border: none;
    }
    .btn-save:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4">
          <h3 class="text-center mb-4 fw-bold">Edit Profil</h3>

          <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">No HP</label>
              <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($user['no_hp']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="">Pilih</option>
                <option value="Laki-laki" <?= $user['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= $user['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control" value="<?= htmlspecialchars($user['tanggal_lahir']) ?>">
            </div>
            <button type="submit" class="btn btn-save w-100">Simpan Perubahan</button>
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
