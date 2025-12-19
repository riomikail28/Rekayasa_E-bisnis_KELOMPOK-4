<?php
require_once __DIR__ . '/../../../models/produkModel.php';
require_once __DIR__ . '/../../../config/koneksi.php';

$produk = getAllProduk(); // Ambil dari tb_produk

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
          header("Location: dashboard_admin.php?page=produk_admin");
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

<div class="container">
  <h4 class="fw-bold mb-4">📦 Daftar Produk</h4>

  <button type="button" class="btn btn-success mb-3" onclick="toggleForm()">➕ Tambah Produk Baru</button>

  <div id="tambah-produk-form" class="card shadow mb-4" style="display: none;">
    <div class="card-header bg-primary text-white">
      <h5 class="card-title mb-0">➕ Tambah Produk Baru</h5>
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
          <button type="button" class="btn btn-outline-secondary" onclick="toggleForm()">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <?php if (count($produk) === 0): ?>
    <div class="alert alert-warning">Belum ada produk yang ditambahkan.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($produk as $p): ?>
            <?php
              $gambarPath = $p['gambar'] ? "../../uploads/{$p['gambar']}" : "../../assets/default.png";
              $deskripsi = strlen($p['deskripsi']) > 60 ? substr($p['deskripsi'], 0, 60) . '...' : $p['deskripsi'];
            ?>
            <tr>
              <td><img src="<?= $gambarPath ?>" alt="Gambar Produk" width="80" height="80" style="object-fit:cover; border-radius:8px;"></td>
              <td><?= htmlspecialchars($p['nama_produk']) ?></td>
              <td><?= htmlspecialchars($deskripsi) ?></td>
              <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
              <td><?= $p['stok'] ?></td>
              <td><?= htmlspecialchars($p['kategori']) ?></td>
              <td>
                <a href="dashboard_admin.php?page=edit_produk&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                <a href="pages/hapus_produk.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">🗑️ Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<script>
function toggleForm() {
  const form = document.getElementById('tambah-produk-form');
  if (form.style.display === 'none' || form.style.display === '') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}

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

