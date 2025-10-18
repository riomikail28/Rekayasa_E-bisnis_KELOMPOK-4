<?php
require_once '../../config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../auth/login.php");
    exit;
}

// Ambil data penjualan per bulan
$query = "SELECT DATE_FORMAT(tgl_transaksi, '%Y-%m') AS bulan, SUM(total) AS omzet 
          FROM transaksi 
          WHERE status = 'dibayar' 
          GROUP BY bulan 
          ORDER BY bulan ASC";
$result = mysqli_query($conn, $query);

$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['bulan'];
    $data[] = $row['omzet'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Grafik Penjualan</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">
  <h3 class="fw-bold mb-4">📈 Grafik Penjualan per Bulan</h3>
  <canvas id="grafikOmzet" height="100"></canvas>
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
      borderColor: '#ff6ec4',
      backgroundColor: 'rgba(255,110,196,0.2)',
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

