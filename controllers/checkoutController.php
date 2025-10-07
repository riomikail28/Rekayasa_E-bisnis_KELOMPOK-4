<?php
require_once __DIR__ . '/../config/koneksi.php';
session_start();

$id_user = $_SESSION['id_users'] ?? null;
$id_produk_list = $_POST['id_produk'] ?? [];
$jumlah_list    = $_POST['jumlah'] ?? [];

if (!$id_user || empty($id_produk_list) || empty($jumlah_list)) {
    echo "Data checkout tidak lengkap.";
    exit;
}

for ($i = 0; $i < count($id_produk_list); $i++) {
    $id_produk = $id_produk_list[$i];
    $jumlah    = $jumlah_list[$i];

    // Ambil harga produk
    $stmt = mysqli_prepare($conn, "SELECT harga FROM produk WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produk = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$produk) continue;

    $total = $produk['harga'] * $jumlah;

    // Simpan transaksi
    $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_user, id_produk, jumlah, total, status, approved, tanggal) VALUES (?, ?, ?, ?, 'pending', 'pending', NOW())");
    mysqli_stmt_bind_param($stmt, "iiid", $id_user, $id_produk, $jumlah, $total);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Kosongkan keranjang
$stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../views/pelanggan/riwayat.php?msg=Checkout berhasil");
exit;
