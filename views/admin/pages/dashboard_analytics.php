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

  <h5 class="mb-3">📈 Grafik Penjualan per Bulan (Line Chart)</h5>
  <canvas id="grafikLine" height="120"></canvas>
  <script>
  const labels = <?= json_encode($labels) ?>;
  const dataOmzet = <?= json_encode($data) ?>;
  const ctx = document.getElementById('grafikLine').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Omzet (Rp)',
        data: dataOmzet,
        borderColor: '#f06292',
        backgroundColor: 'rgba(240,98,146,0.15)',
        fill: true,
        tension: 0.3,
        pointBackgroundColor: '#fff',
        pointBorderColor: '#f06292',
        pointRadius: 5,
        pointHoverRadius: 8,
        pointStyle: 'circle',
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Omzet: Rp ' + context.parsed.y.toLocaleString();
            }
          },
          backgroundColor: '#f06292',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#fff',
          borderWidth: 1,
          padding: 12
        }
      },
      scales: {
        x: {
          title: { display: true, text: 'Bulan', color: '#f06292', font: { weight: 'bold' } },
          ticks: { color: '#333' }
        },
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Omzet (Rp)', color: '#f06292', font: { weight: 'bold' } },
          ticks: {
            callback: value => 'Rp ' + value.toLocaleString(),
            color: '#333'
          }
        }
      }
    }
  });
  </script>

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

  <h5 class="mb-3 mt-4">📈 Statistik Tambahan</h5>
  <div class="row g-4 mb-5">
    <?php
    // Total pelanggan
    $q5 = mysqli_query($conn, "SELECT COUNT(*) AS total_pelanggan FROM users WHERE role = 'pelanggan'");
    $total_pelanggan = mysqli_fetch_assoc($q5)['total_pelanggan'] ?? 0;

    // Stok rendah
    $q6 = mysqli_query($conn, "SELECT COUNT(*) AS stok_rendah FROM produk WHERE stok <= 10");
    $stok_rendah = mysqli_fetch_assoc($q6)['stok_rendah'] ?? 0;

    // Transaksi pending
    $q7 = mysqli_query($conn, "SELECT COUNT(*) AS pending FROM transaksi WHERE status = 'pending'");
    $pending = mysqli_fetch_assoc($q7)['pending'] ?? 0;

    // Pengiriman pending (using transaksi table for now, as pengiriman table may not exist)
    $q8 = mysqli_query($conn, "SELECT COUNT(*) AS pengiriman_pending FROM transaksi WHERE status = 'pending'");
    $pengiriman_pending = mysqli_fetch_assoc($q8)['pengiriman_pending'] ?? 0;
    ?>

    <div class="col-md-3">
      <div class="card shadow-sm p-3">
        <h6>Total Pelanggan</h6>
        <p class="fs-5 fw-bold"><?= $total_pelanggan ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-warning text-dark">
        <h6>Stok Rendah</h6>
        <p class="fs-5 fw-bold"><?= $stok_rendah ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-info text-white">
        <h6>Transaksi Pending</h6>
        <p class="fs-5 fw-bold"><?= $pending ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-danger text-white">
        <h6>Pengiriman Pending</h6>
        <p class="fs-5 fw-bold"><?= $pengiriman_pending ?></p>
      </div>
    </div>
  </div>

  <h5 class="mb-3">📊 Tabel Statistik Lengkap</h5>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Metrik</th>
        <th>Nilai</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Total Pelanggan</td><td><?= $total_pelanggan ?></td></tr>
      <tr><td>Produk dengan Stok Rendah</td><td><?= $stok_rendah ?></td></tr>
      <tr><td>Transaksi Pending</td><td><?= $pending ?></td></tr>
      <tr><td>Pengiriman Pending</td><td><?= $pengiriman_pending ?></td></tr>
    </tbody>
  </table>
</div>
</body>
</html>
