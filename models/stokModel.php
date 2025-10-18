<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllStok() {
    global $conn;
    $query = "SELECT p.id, p.nama_produk, p.stok, p.harga, p.kategori FROM produk p ORDER BY p.stok ASC";
    $result = mysqli_query($conn, $query);
    $stok = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $stok[] = $row;
    }
    return $stok;
}

function getStokById($id) {
    global $conn;
    $query = "SELECT * FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateStok($id, $stok) {
    global $conn;
    $query = "UPDATE produk SET stok = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $stok, $id);
    return mysqli_stmt_execute($stmt);
}

function getLowStockAlerts($threshold = 5) {
    global $conn;
    $query = "SELECT * FROM produk WHERE stok <= ? ORDER BY stok ASC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $threshold);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $alerts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $alerts[] = $row;
    }
    return $alerts;
}
?>

