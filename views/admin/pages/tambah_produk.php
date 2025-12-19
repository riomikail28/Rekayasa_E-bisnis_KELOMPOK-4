<?php
require_once __DIR__ . '/../../../config/koneksi.php';

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
          header("Location: ../dashboard_admin.php?page=produk_admin");
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
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="card-title mb-0">➕ Tambah Produk Baru</h4>
    </div>
    <div class="card-body">
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
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
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" step="0.01" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar Produk</label>
          <div class="input-group">
            <input type="file" name="gambar" class="form-control custom-file-input" id="gambar" accept=".jpg,.jpeg,.png,.gif" required onchange="previewImage(event)">
            <label class="input-group-text" for="gambar">Pilih Gambar</label>
          </div>
          <div id="image-preview" class="mt-2" style="display: none;">
            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" name="submit" class="btn btn-success me-2">Upload Produk</button>
          <a href="dashboard_admin.php?page=produk_admin" class="btn btn-outline-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function previewImage(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('image-preview');
  const img = document.getElementById('preview-img');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      img.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    preview.style.display = 'none';
  }
}
</script>

