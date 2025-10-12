<?php
session_start();
require_once '../../config/koneksi.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_users'];

// Ambil transaksi utama
$query = "SELECT * FROM transaksi WHERE id_user = ? ORDER BY tgl_transaksi DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$transaksi = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>

<button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar-wrapper">
  <div class="sidebar">
    <div class="text-center mb-4"><h4 class="fw-bold text-primary">Buketminiku</h4></div>
    <a href="katalog.php">🏠 Katalog</a>
    <a href="keranjang.php">🛒 Keranjang</a>
    <a href="riwayat.php" class="active">📦 Riwayat</a>
    <a href="home_login.php">🏠 Home</a>
    <a href="../../controllers/logout.php" class="text-danger" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
  </div>
</div>

<div class="content-area py-4 px-4">
  <h3 class="fw-bold text-center mb-4">📦 Riwayat Transaksi</h3>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <?php if (empty($transaksi)): ?>
    <div class="alert alert-info text-center">Belum ada transaksi. Yuk belanja dulu di <a href="katalog.php">katalog</a>!</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($transaksi as $t): ?>
        <?php
          $stmt = mysqli_prepare($conn, "SELECT p.nama_produk, p.gambar, d.jumlah FROM detail_transaksi d JOIN produk p ON d.id_produk = p.id WHERE d.id_transaksi = ?");
          mysqli_stmt_bind_param($stmt, "i", $t['id']);
          mysqli_stmt_execute($stmt);
          $items = mysqli_stmt_get_result($stmt);
        ?>
        <div class="col-md-6 mb-4">
          <div class="card card-transaksi p-3">
            <h5 class="fw-bold">Transaksi #<?= $t['id'] ?></h5>
            <p>Total: Rp <?= number_format($t['total'], 0, ',', '.') ?></p>
            <p>Pengiriman: <?= htmlspecialchars($t['metode_pengiriman']) ?></p>
            <p>Pembayaran: <?= htmlspecialchars($t['metode_pembayaran']) ?></p>
            <p>Status: <span class="badge bg-<?= $t['status'] === 'dibayar' ? 'success' : 'warning' ?>"><?= ucfirst($t['status']) ?></span></p>
            <p>Approved: <span class="badge bg-<?= $t['approved'] === 'disetujui' ? 'success' : ($t['approved'] === 'ditolak' ? 'danger' : 'secondary') ?>"><?= ucfirst($t['approved']) ?></span></p>
            <p>Tanggal: <?= date('d M Y H:i', strtotime($t['tgl_transaksi'])) ?></p>

            <hr>
            <p class="fw-semibold">Item:</p>
            <?php while ($item = mysqli_fetch_assoc($items)): ?>
              <div class="d-flex align-items-center mb-2">
                <img src="../../uploads/<?= htmlspecialchars($item['gambar']) ?: 'default.jpg' ?>" class="produk-img" alt="<?= htmlspecialchars($item['nama_produk']) ?>" onerror="this.src='../../uploads/default.jpg'">
                <span class="ms-2"><?= htmlspecialchars($item['nama_produk']) ?> (<?= $item['jumlah'] ?> pcs)</span>
              </div>
            <?php endwhile; ?>

            <?php if (!empty($t['bukti_pembayaran'])): ?>
              <p class="mt-3 mb-1">Bukti Pembayaran:</p>
              <img src="../../uploads/<?= htmlspecialchars($t['bukti_pembayaran']) ?>" class="bukti-img" alt="Bukti Pembayaran">
              <small class="text-muted"><?= htmlspecialchars($t['bukti_pembayaran']) ?></small>
            <?php elseif ($t['metode_pembayaran'] !== 'COD' && empty($t['bukti_pembayaran'])): ?>
              <form method="POST" action="../../controllers/upload_bukti.php" enctype="multipart/form-data" class="mt-3">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <div class="mb-2">
                  <input type="file" name="bukti" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success btn-sm">Upload Bukti Pembayaran</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<script>
  function toggleSidebar() {
    document.body.classList.toggle('sidebar-hidden');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
