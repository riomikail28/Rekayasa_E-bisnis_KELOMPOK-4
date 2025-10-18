<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $nama      = trim($_POST['nama_produk'] ?? '');
  $deskripsi = trim($_POST['deskripsi'] ?? '');
  $kategori  = $_POST['kategori'] ?? '';
  $harga     = floatval($_POST['harga'] ?? 0);
  $stok      = intval($_POST['stok'] ?? 0);
  $gambar    = $_FILES['gambar'] ?? null;

  if (!$nama || !$deskripsi || !$kategori || !$harga || !$stok || !$gambar) {
    $error = "Semua field wajib diisi.";
  } else {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
      $error = "Format gambar tidak didukung.";
    } elseif ($gambar['size'] > 2 * 1024 * 1024) {
      $error = "Ukuran gambar maksimal 2MB.";
    } elseif ($gambar['error'] !== 0) {
      $error = "Terjadi kesalahan saat upload.";
    } else {
      $uploadDir = realpath(__DIR__ . '/../../../uploads');
      if (!$uploadDir) {
        mkdir(__DIR__ . '/../../../uploads', 0777, true);
        $uploadDir = realpath(__DIR__ . '/../../../uploads');
      }

      $filename = 'produk_' . time() . '.' . $ext;
      $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

      if (move_uploaded_file($gambar['tmp_name'], $targetPath)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO produk (nama_produk, deskripsi, harga, stok, gambar, kategori) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssdiss", $nama, $deskripsi, $harga, $stok, $filename, $kategori);
        if (mysqli_stmt_execute($stmt)) {
          header("Location: dashboard_admin.php?page=produk_admin&status=success");
          exit;
        } else {
          $error = "Gagal menyimpan produk ke database.";
        }
        mysqli_stmt_close($stmt);
      } else {
        $error = "Gagal memindahkan gambar ke folder uploads.";
      }
    }
  }
}
?>

<div class="container mt-4">
  <h4 class="fw-bold mb-3">➕ Tambah Produk Baru</h4>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="kategori" class="form-select" required>
        <option value="">Pilih Kategori</option>
        <option value="bunga">Bunga</option>
        <option value="snack">Snack</option>
        <option value="boneka">Boneka</option>
        <option value="uang">Uang</option>
        <option value="kado">Kado</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" class="form-control" step="0.01" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Stok</label>
      <input type="number" name="stok" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Gambar Produk</label>
      <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.gif" required>
    </div>
    <button type="submit" name="submit" class="btn btn-success">Upload Produk</button>
    <a href="dashboard_admin.php?page=produk_admin" class="btn btn-outline-secondary ms-2">Kembali</a>
  </form>
</div>

