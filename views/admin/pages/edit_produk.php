<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<div class='alert alert-danger'>ID produk tidak ditemukan.</div>";
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
  echo "<div class='alert alert-danger'>Produk tidak ditemukan.</div>";
  exit;
}

if (isset($_POST['submit'])) {
  $nama = $_POST['nama_produk'];
  $kategori = $_POST['kategori'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];

  $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', stok='$stok' WHERE id=$id";
  if (mysqli_query($conn, $query)) {
    echo "<div class='alert alert-success'>Produk berhasil diperbarui!</div>";
  } else {
    echo "<div class='alert alert-danger'>Gagal memperbarui produk.</div>";
  }
}
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">✏️ Edit Produk</h3>
  <form method="POST">
    <div class="mb-3">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" value="<?= $produk['nama_produk'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Kategori</label>
      <input type="text" name="kategori" class="form-control" value="<?= $produk['kategori'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Harga</label>
      <input type="number" name="harga" class="form-control" value="<?= $produk['harga'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Stok</label>
      <input type="number" name="stok" class="form-control" value="<?= $produk['stok'] ?>" required>
    </div>
    <button type="submit" name="submit" class="btn btn-pink">Simpan Perubahan</button>
  </form>
</div>
