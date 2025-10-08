<?php
require_once '../../config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit;
}

// Filter tanggal
$tgl_awal = $_GET['awal'] ?? '';
$tgl_akhir = $_GET['akhir'] ?? '';

$where = '';
if ($tgl_awal && $tgl_akhir) {
    $where = "WHERE t.tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$query = "SELECT 
            t.id AS id_transaksi, 
            t.tgl_transaksi, 
            t.total, 
            t.metode_pembayaran, 
            t.status, 
            t.approved, 
            u.username
          FROM transaksi t
          JOIN users u ON t.id_user = u.id_users
          $where
          ORDER BY t.tgl_transaksi DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .badge-status {
      font-size: 0.85rem;
      padding: 6px 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container py-4">
  <h3 class="fw-bold mb-4">📊 Laporan Penjualan</h3>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">Tanggal Awal</label>
      <input type="date" name="awal" class="form-control" value="<?= htmlspecialchars($tgl_awal) ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Tanggal Akhir</label>
      <input type="date" name="akhir" class="form-control" value="<?= htmlspecialchars($tgl_akhir) ?>">
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button type="submit" class="btn btn-primary me-2">Filter</button>
      <a href="../../controllers/admin/pages/export_csv.php?awal=<?= urlencode($tgl_awal) ?>&akhir=<?= urlencode($tgl_akhir) ?>" class="btn btn-success">📥 Export CSV</a>
    </div>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Username</th>
        <th>Total</th>
        <th>Pembayaran</th>
        <th>Status</th>
        <th>Approved</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td>#<?= $row['id_transaksi'] ?></td>
            <td><?= date('d M Y H:i', strtotime($row['tgl_transaksi'])) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
            <td>
              <span class="badge bg-<?= $row['status'] === 'dibayar' ? 'success' : ($row['status'] === 'dikirim' ? 'primary' : 'warning') ?> badge-status">
                <?= ucfirst($row['status']) ?>
              </span>
            </td>
            <td>
              <span class="badge bg-<?= $row['approved'] === 'disetujui' ? 'success' : ($row['approved'] === 'ditolak' ? 'danger' : 'secondary') ?> badge-status">
                <?= ucfirst($row['approved']) ?>
              </span>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center text-muted">Tidak ada data transaksi untuk rentang tanggal ini.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
