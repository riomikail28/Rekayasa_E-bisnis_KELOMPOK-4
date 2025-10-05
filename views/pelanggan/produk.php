<?php
require_once '../../models/produkModel.php';
$produk = getAllProduk();
?>

<h2>Produk Tersedia</h2>
<?php foreach ($produk as $p): ?>
  <div>
    <img src="../../uploads/<?= $p['gambar'] ?>" width="100"><br>
    <strong><?= $p['nama_produk'] ?></strong><br>
    Rp<?= $p['harga'] ?><br>
    <form method="POST" action="../../controllers/transaksiController.php">
      <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
      <input type="number" name="jumlah" value="1" min="1">
      <button type="submit" name="beli">Beli</button>
    </form>
  </div>
  <hr>
<?php endforeach; ?>

<h4>Berikan Ulasan</h4>
<form method="POST" action="../../controllers/ulasanController.php">
  <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
  <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
  <label>Rating (1–5):</label>
  <input type="number" name="rating" min="1" max="5" required><br>
  <label>Komentar:</label>
  <textarea name="komentar" rows="2" required></textarea><br>
  <button type="submit" name="kirim" class="btn btn-warning">Kirim Ulasan</button>
</form>

<?php
$ulasan = getUlasanByProduk($p['id']);
?>

<h4>Ulasan Pelanggan</h4>
<?php foreach ($ulasan as $u): ?>
  <div class="border p-2 mb-2">
    <strong><?= $u['username'] ?></strong> 
    <span class="badge bg-info"><?= $u['rating'] ?> ⭐</span><br>
    <em><?= $u['komentar'] ?></em><br>
    <small><?= $u['waktu'] ?></small>
  </div>
<?php endforeach; ?>
