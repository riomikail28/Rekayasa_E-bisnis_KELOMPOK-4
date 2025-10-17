<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllProduk() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
    $produk = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }
    return $produk;
}

function getProdukByKategori($kategori) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM t_barang WHERE kategori = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, "s", $kategori);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produk = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $produk;
}

function getProdukById($id_produk) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produk = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $produk;
}
