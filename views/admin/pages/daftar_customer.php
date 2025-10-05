<?php
require_once __DIR__ . '/../../../config/koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'pelanggan'");
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">👥 Daftar Pelanggan</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Username</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $row['username'] ?></td>
        <td><?= $row['status'] ?? 'Aktif' ?></td>
        <td>
          <a href="dashboard_admin.php?page=detail_customer&id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Detail</a>
          <a href="dashboard_admin.php?page=blokir_customer&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Blokir</a>
          <a href="dashboard_admin.php?page=hapus_customer&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus customer ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
