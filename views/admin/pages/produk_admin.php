<?php
require_once __DIR__ . '/../../../models/produkModel.php';
$produk = getAllProduk(); // Ambil dari tb_produk
?>

<div class="container">
  <h4 class="fw-bold mb-4">📦 Daftar Produk</h4>

  <a href="dashboard_admin.php?page=tambah_produk" class="btn btn-success mb-3">➕ Tambah Produk Baru</a>

  <?php if (count($produk) === 0): ?>
    <div class="alert alert-warning">Belum ada produk yang ditambahkan.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($produk as $p): ?>
            <?php
              $gambarPath = $p['gambar'] ? "../../uploads/{$p['gambar']}" : "../../assets/default.png";
              $deskripsi = strlen($p['deskripsi']) > 60 ? substr($p['deskripsi'], 0, 60) . '...' : $p['deskripsi'];
            ?>
            <tr>
              <td><img src="<?= $gambarPath ?>" alt="Gambar Produk" width="80" height="80" style="object-fit:cover; border-radius:8px;"></td>
              <td><?= htmlspecialchars($p['nama_produk']) ?></td>
              <td><?= htmlspecialchars($deskripsi) ?></td>
              <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
              <td><?= $p['stok'] ?></td>
              <td><?= htmlspecialchars($p['kategori']) ?></td>
              <td>
                <a href="dashboard_admin.php?page=edit_produk&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                <a href="pages/hapus_produk.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">🗑️ Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
