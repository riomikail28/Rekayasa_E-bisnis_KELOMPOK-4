<?php
require_once '../../config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../auth/login.php");
    exit;
}

// Total transaksi
$q1 = mysqli_query($conn, "SELECT COUNT(*) AS total_transaksi FROM transaksi");
$total_transaksi = mysqli_fetch_assoc($q1)['total_transaksi'] ?? 0;

// Total omzet
$q2 = mysqli_query($conn, "SELECT SUM(total) AS total_omzet FROM transaksi WHERE status = 'dibayar'");
$total_omzet = mysqli_fetch_assoc($q2)['total_omzet'] ?? 0;

// Produk terlaris
$q3 = mysqli_query($conn, "SELECT p.nama_produk, SUM(d.jumlah) AS total_jual 
                           FROM detail_transaksi d 
                           JOIN produk p ON d.id_produk = p.id 
                           GROUP BY p.id 
                           ORDER BY total_jual DESC 
                           LIMIT 1");
$produk_terlaris = mysqli_fetch_assoc($q3)['nama_produk'] ?? 'Belum ada';

// Grafik penjualan per bulan
$q4 = mysqli_query($conn, "SELECT DATE_FORMAT(tgl_transaksi, '%Y-%m') AS bulan, SUM(total) AS omzet 
                           FROM transaksi 
                           WHERE status = 'dibayar' 
                           GROUP BY bulan 
                           ORDER BY bulan ASC");
$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($q4)) {
    $labels[] = $row['bulan'];
    $data[] = $row['omzet'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Analitik</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">
  <h3 class="fw-bold mb-4">📋 Dashboard Analitik</h3>

  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5>Total Transaksi</h5>
        <p class="fs-4 fw-bold"><?= $total_transaksi ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5>Total Omzet</h5>
        <p class="fs-4 fw-bold">Rp <?= number_format($total_omzet, 0, ',', '.') ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5>Produk Terlaris</h5>
        <p class="fs-5"><?= htmlspecialchars($produk_terlaris) ?></p>
      </div>
    </div>
  </div>

  <h5 class="mb-3">📈 Grafik Penjualan per Bulan</h5>
  <canvas id="grafikOmzet" height="100"></canvas>

  <h5 class="mb-3 mt-4">📊 Tabel Penjualan per Bulan</h5>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Bulan</th>
        <th>Omzet (Rp)</th>
      </tr>
    </thead>
    <tbody>
      <?php for ($i = 0; $i < count($labels); $i++): ?>
        <tr>
          <td><?php echo htmlspecialchars($labels[$i]); ?></td>
          <td>Rp <?php echo number_format($data[$i], 0, ',', '.'); ?></td>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>

<script>
const ctx = document.getElementById('grafikOmzet').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
      label: 'Omzet (Rp)',
      data: <?= json_encode($data) ?>,
      borderColor: '#f06292',
      backgroundColor: 'rgba(240,98,146,0.2)',
      fill: true,
      tension: 0.3
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: value => 'Rp ' + value.toLocaleString()
        }
      }
    }
  }
});
</script>
</body>
</html>
