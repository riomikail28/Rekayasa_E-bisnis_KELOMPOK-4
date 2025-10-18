<?php
require_once __DIR__ . '/../../../config/koneksi.php';

if (isset($_POST['submit'])) {
  $nama     = $_POST['nama_produk'];
  $kategori = $_POST['kategori'];
  $harga    = $_POST['harga'];
  $stok     = $_POST['stok'];

  // Proses upload gambar
  $gambar = $_FILES['gambar']['name'];
  $tmp    = $_FILES['gambar']['tmp_name'];
  $folder = '../../../uploads/' . $gambar;

  if (move_uploaded_file($tmp, $folder)) {
    $query = "INSERT INTO produk (nama_produk, kategori, harga, stok, gambar) 
              VALUES ('$nama', '$kategori', '$harga', '$stok', '$gambar')";
    if (mysqli_query($conn, $query)) {
      echo "<div class='alert alert-success'>Produk berhasil ditambahkan dengan gambar!</div>";
    } else {
      echo "<div class='alert alert-danger'>Gagal menyimpan produk ke database.</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Gagal mengupload gambar.</div>";
  }
}
?>

<div class="container mt-3">
  <a href="dashboard_admin.php?page=produk_admin" class="btn btn-outline-pink">Kembali ke Daftar Produk</a>
</div>

