<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM produk");
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">📦 Daftar Produk</h3>
  <a href="dashboard_admin.php?page=tambah_produk" class="btn btn-pink mb-3">Tambah Produk</a>
  <table class="table table-bordered table-striped">
    <thead class="table-pink">
      <tr>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
        <td><?= htmlspecialchars($row['kategori']) ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td><?= $row['stok'] ?></td>
        <td>
          <a href="dashboard_admin.php?page=edit_produk&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="dashboard_admin.php?page=hapus_produk&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus produk ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
