<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC");
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">📊 Laporan Penjualan</h3>
  <table class="table table-bordered table-striped">
    <thead class="table-pink">
      <tr>
        <th>ID Transaksi</th>
        <th>Nama Pelanggan</th>
        <th>Total</th>
        <th>Status</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nama_pelanggan'] ?></td>
        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
