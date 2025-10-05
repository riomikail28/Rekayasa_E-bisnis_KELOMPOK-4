<?php
require_once __DIR__ . '/../../../config/koneksi.php';
if (isset($_POST['submit'])) {
  $nama = $_POST['nama_produk'];
  $kategori = $_POST['kategori'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];

  $query = "INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES ('$nama', '$kategori', '$harga', '$stok')";
  if (mysqli_query($conn, $query)) {
    echo "<div class='alert alert-success'>Produk berhasil ditambahkan!</div>";
  } else {
    echo "<div class='alert alert-danger'>Gagal menambahkan produk.</div>";
  }
}
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">➕ Tambah Produk</h3>
  <form method="POST" action="dashboard_admin.php?page=upload_produk" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Kategori</label>
      <input type="text" name="kategori" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Harga</label>
      <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Stok</label>
      <input type="number" name="stok" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Gambar Produk</label>
      <input type="file" name="gambar" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" name="submit" class="btn btn-pink">Simpan Produk</button>
  </form>
</div>
