<?php
require_once __DIR__ . '/../../../models/stokModel.php';
$stok = getAllStok();
$low_stock_alerts = getLowStockAlerts();
?>

<div class="container">
  <h4 class="fw-bold mb-4">📦 Manajemen Stok</h4>

  <?php if (count($low_stock_alerts) > 0): ?>
    <div class="alert alert-warning">
      <strong>Peringatan Stok Habis:</strong>
      <ul>
        <?php foreach ($low_stock_alerts as $alert): ?>
          <li><?= htmlspecialchars($alert['nama_produk']) ?> - Stok: <?= $alert['stok'] ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card">
    <div class="card-header">Daftar Stok</div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($stok as $s): ?>
            <tr class="<?= $s['stok'] <= 5 ? 'table-warning' : '' ?>">
              <td><?= htmlspecialchars($s['nama_produk']) ?></td>
              <td>
                <form method="POST" action="../../../controllers/stokController.php" class="d-inline">
                  <input type="hidden" name="id" value="<?= $s['id'] ?>">
                  <input type="number" name="stok" value="<?= $s['stok'] ?>" min="0" class="form-control form-control-sm d-inline" style="width: 80px;">
                  <button type="submit" name="update_stok" class="btn btn-sm btn-primary">Update</button>
                </form>
              </td>
              <td>Rp <?= number_format($s['harga'], 0, ',', '.') ?></td>
              <td><?= htmlspecialchars($s['kategori']) ?></td>
              <td>
                <button class="btn btn-sm btn-info" onclick="alert('Tambah/Edit/Hapus stok dilakukan di halaman Kelola Produk')">ℹ️ Info</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
