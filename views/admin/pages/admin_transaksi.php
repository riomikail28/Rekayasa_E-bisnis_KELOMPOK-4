<?php
require_once __DIR__ . '/../../../config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil semua transaksi yang statusnya 'dibayar'
$query = "SELECT t.*, u.username FROM transaksi t 
          JOIN users u ON t.id_user = u.id_users 
          WHERE t.status IN ('pending', 'checkout') 
          ORDER BY t.tgl_transaksi DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container">
  <h3 class="fw-bold mb-4 text-primary">📦 Validasi Transaksi</h3>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Transaksi #<?= $row['id'] ?> - <?= htmlspecialchars($row['username']) ?></h5>
        <p class="mb-1">Total: <strong>Rp<?= number_format($row['total']) ?></strong></p>
        <p class="mb-1">Pengiriman: <?= htmlspecialchars($row['metode_pengiriman']) ?></p>
        <p class="mb-1">Pembayaran: <?= htmlspecialchars($row['metode_pembayaran']) ?></p>
        <p class="mb-1">Tanggal: <?= $row['tgl_transaksi'] ?></p>
        <p class="mb-2">Bukti Pembayaran: 
          <?php if (!empty($row['bukti_pembayaran'])): ?>
            <a href="../../../uploads/<?= $row['bukti_pembayaran'] ?>" target="_blank">Lihat Bukti</a>
          <?php else: ?>
            <span class="text-danger">Belum diupload</span>
          <?php endif; ?>
        </p>

        <div class="d-flex gap-2">
          <!-- Tombol Setujui -->
          <form method="GET" action="dashboard_admin.php" style="display:inline;">
            <input type="hidden" name="page" value="validasi_transaksi">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="aksi" value="verifikasi">
            <button type="submit" class="btn btn-success">Setujui</button>
          </form>

          <!-- Tombol Tolak -->
          <form method="GET" action="dashboard_admin.php" style="display:inline;">
            <input type="hidden" name="page" value="validasi_transaksi">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="aksi" value="tolak">
            <button type="submit" class="btn btn-danger">Tolak</button>
          </form>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>
