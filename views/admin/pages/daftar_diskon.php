<?php
require_once __DIR__ . '/../../../models/diskonModel.php';

$diskon = getAllDiskon();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $kode_diskon = trim($_POST['kode_diskon'] ?? '');
  $persentase_diskon = intval($_POST['persentase_diskon'] ?? 0);
  $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
  $tanggal_akhir = $_POST['tanggal_akhir'] ?? '';
  $status = $_POST['status'] ?? 'active';

  if (!$kode_diskon || !$persentase_diskon || !$tanggal_mulai || !$tanggal_akhir) {
    $error = "Semua field wajib diisi.";
  } elseif ($persentase_diskon < 1 || $persentase_diskon > 100) {
    $error = "Persentase diskon harus antara 1-100.";
  } elseif (strtotime($tanggal_mulai) >= strtotime($tanggal_akhir)) {
    $error = "Tanggal mulai harus sebelum tanggal akhir.";
  } elseif (isKodeDiskonExists($kode_diskon)) {
    $error = "Kode diskon sudah ada.";
  } else {
    if (addDiskon($kode_diskon, $persentase_diskon, $tanggal_mulai, $tanggal_akhir, $status)) {
      echo "<script>window.location.href = 'dashboard_admin.php?page=daftar_diskon&success=1';</script>";
      exit;
    } else {
      $error = "Gagal menyimpan diskon ke database.";
    }
  }
}
?>

<div class="container">
  <h4 class="fw-bold mb-4">🎫 Daftar Kode Diskon</h4>

  <button type="button" class="btn btn-success mb-3" onclick="toggleForm()">➕ Tambah Kode Diskon Baru</button>

  <div id="tambah-diskon-form" class="card shadow mb-4" style="display: none;">
    <div class="card-header bg-primary text-white">
      <h5 class="card-title mb-0">➕ Tambah Kode Diskon Baru</h5>
    </div>
    <div class="card-body">
      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Kode Diskon</label>
            <input type="text" name="kode_diskon" class="form-control" required placeholder="DISKON10">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Persentase Diskon (%)</label>
            <input type="number" name="persentase_diskon" class="form-control" min="1" max="100" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" name="submit" class="btn btn-success me-2">Simpan Diskon</button>
          <button type="button" class="btn btn-outline-secondary" onclick="toggleForm()">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <?php if (count($diskon) === 0): ?>
    <div class="alert alert-warning">Belum ada kode diskon yang ditambahkan.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>Kode Diskon</th>
            <th>Persentase</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Akhir</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($diskon as $d): ?>
            <tr>
              <td><strong><?= htmlspecialchars($d['kode_diskon']) ?></strong></td>
              <td><?= $d['persentase_diskon'] ?>%</td>
              <td><?= date('d/m/Y', strtotime($d['tanggal_mulai'])) ?></td>
              <td><?= date('d/m/Y', strtotime($d['tanggal_akhir'])) ?></td>
              <td>
                <span class="badge bg-<?= $d['status'] === 'active' ? 'success' : 'secondary' ?>">
                  <?= ucfirst($d['status']) ?>
                </span>
              </td>
              <td>
                <a href="dashboard_admin.php?page=edit_diskon&id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                <a href="pages/hapus_diskon.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kode diskon ini?')">🗑️ Hapus</a>
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
  const form = document.getElementById('tambah-diskon-form');
  if (form.style.display === 'none' || form.style.display === '') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}
</script>
