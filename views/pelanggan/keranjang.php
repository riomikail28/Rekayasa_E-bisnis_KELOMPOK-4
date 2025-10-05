<?php
require_once '../../models/keranjangModel.php';
$id_user = $_SESSION['id_user'];
$items = getKeranjangByUser($id_user);
?>

<h2>Keranjang Belanja</h2>
<table class="table">
  <tr>
    <th>Produk</th><th>Jumlah</th><th>Total</th><th>Gambar</th>
  </tr>
  <?php foreach ($items as $item): ?>
  <tr>
    <td><?= $item['nama_produk'] ?></td>
    <td><?= $item['jumlah'] ?></td>
    <td>Rp<?= $item['jumlah'] * $item['harga'] ?></td>
    <td><img src="../../uploads/<?= $item['gambar'] ?>" width="80"></td>
  </tr>
  <?php endforeach; ?>
</table>
<a href="checkout.php" class="btn btn-success">Checkout</a>

<?php
$pesan = "Halo BuketMinku, saya ingin pesan buket: " . $p['nama_produk'] . " seharga Rp " . number_format($p['harga'], 0, ',', '.');
$linkWA = "https://wa.me/62812XXXXXXX?text=" . urlencode($pesan);
?>

<a href="<?= $linkWA ?>" target="_blank" class="btn btn-success w-100 mt-2">Pesan via WhatsApp</a>
