<?php
require_once __DIR__ . '/../../../models/diskonModel.php';

$error = '';

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
      echo "<script>window.location.href = '../dashboard_admin.php?page=daftar_diskon';</script>";
      exit;
    } else {
      $error = "Gagal menyimpan diskon ke database.";
    }
  }
}
?>

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="card-title mb-0">➕ Tambah Kode Diskon Baru</h4>
    </div>
    <div class="card-body">
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
          <a href="dashboard_admin.php?page=daftar_diskon" class="btn btn-outline-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
