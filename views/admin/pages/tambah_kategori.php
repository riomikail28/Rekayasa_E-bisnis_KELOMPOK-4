<?php
require_once __DIR__ . '/../../../config/koneksi.php';
if (isset($_POST['submit'])) {
  $kategori = $_POST['nama_kategori'];
  $query = "INSERT INTO kategori (nama_kategori) VALUES ('$kategori')";
  if (mysqli_query($conn, $query)) {
    echo "<div class='alert alert-success'>Kategori berhasil ditambahkan!</div>";
  } else {
    echo "<div class='alert alert-danger'>Gagal menambahkan kategori.</div>";
  }
}
?>

<div class="container mt-4">
  <h3 class="text-pink fw-bold">➕ Tambah Kategori</h3>
  <form method="POST">
    <div class="mb-3">
      <label>Nama Kategori</label>
      <input type="text" name="nama_kategori" class="form-control" required>
    </div>
    <button type="submit" name="submit" class="btn btn-pink">Simpan Kategori</button>
  </form>
</div>

