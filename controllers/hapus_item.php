<?php
require_once __DIR__ . '/../config/koneksi.php';
session_start();

$id_user = $_SESSION['id_users'] ?? null;
$id_keranjang = $_GET['id'] ?? null;

if (!$id_user || !$id_keranjang) {
    header("Location: ../views/pelanggan/keranjang.php?msg=Gagal hapus item");
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id = ? AND id_user = ?");
mysqli_stmt_bind_param($stmt, "ii", $id_keranjang, $id_user);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../views/pelanggan/keranjang.php?msg=Item berhasil dihapus");
exit;

