<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

$id_user = $_SESSION['id_users'] ?? null;
$pengiriman = $_POST['pengiriman'] ?? null;
$pembayaran = $_POST['pembayaran'] ?? null;
$id_produk_list = $_POST['id_produk'] ?? [];
$jumlah_list = $_POST['jumlah'] ?? [];

if (!$id_user || !$pengiriman || !$pembayaran || empty($id_produk_list) || count($id_produk_list) !== count($jumlah_list)) {
    header("Location: ../views/pelanggan/keranjang.php?msg=Data checkout tidak lengkap");
    exit;
}

// Hitung total belanja dan siapkan data produk
$total_belanja = 0;
$produk_data = [];

foreach ($id_produk_list as $i => $id_produk) {
    $jumlah = (int) $jumlah_list[$i];

    $stmt = mysqli_prepare($conn, "SELECT harga FROM produk WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produk = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$produk) continue;

    $harga = (int) $produk['harga'];
    $subtotal = $harga * $jumlah;
    $total_belanja += $subtotal;

    $produk_data[] = [
        'id_produk' => $id_produk,
        'jumlah' => $jumlah,
        'harga' => $harga
    ];
}

if (empty($produk_data)) {
    header("Location: ../views/pelanggan/keranjang.php?msg=Produk tidak valid");
    exit;
}

// Simpan transaksi utama (satu baris)
$status = 'pending';
$approved = 'pending';
$bukti_pembayaran = ''; // kosong dulu, bisa diisi saat upload bukti

$stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_user, total, metode_pengiriman, metode_pembayaran, status, bukti_pembayaran, approved, tgl_transaksi) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
mysqli_stmt_bind_param($stmt, "idsssss", $id_user, $total_belanja, $pengiriman, $pembayaran, $status, $bukti_pembayaran, $approved);
mysqli_stmt_execute($stmt);
$id_transaksi = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

// Simpan detail item ke tabel detail_transaksi
$stmt = mysqli_prepare($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) VALUES (?, ?, ?, ?)");
foreach ($produk_data as $item) {
    mysqli_stmt_bind_param($stmt, "iiii", $id_transaksi, $item['id_produk'], $item['jumlah'], $item['harga']);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_close($stmt);

// Kosongkan keranjang setelah checkout
$stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirect ke keranjang dengan pesan sukses
header("Location: ../views/pelanggan/keranjang.php?msg=Checkout berhasil! Silakan tunggu konfirmasi admin.");
exit;
