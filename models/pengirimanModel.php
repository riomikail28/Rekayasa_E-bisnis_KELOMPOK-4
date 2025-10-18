<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllPengiriman() {
    global $conn;
    $query = "SELECT * FROM tb_pengiriman ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $pengiriman = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $pengiriman[] = $row;
    }
    return $pengiriman;
}

function getPengirimanById($id) {
    global $conn;
    $query = "SELECT * FROM tb_pengiriman WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function addPengiriman($data) {
    global $conn;
    $query = "INSERT INTO tb_pengiriman (nama_pengiriman, biaya, deskripsi) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sds", $data['nama_pengiriman'], $data['biaya'], $data['deskripsi']);
    return mysqli_stmt_execute($stmt);
}

function updatePengiriman($id, $data) {
    global $conn;
    $query = "UPDATE tb_pengiriman SET nama_pengiriman = ?, biaya = ?, deskripsi = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sdsi", $data['nama_pengiriman'], $data['biaya'], $data['deskripsi'], $id);
    return mysqli_stmt_execute($stmt);
}

function deletePengiriman($id) {
    global $conn;
    $query = "DELETE FROM tb_pengiriman WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}

function getBiayaPengiriman() {
    global $conn;
    $query = "SELECT * FROM tb_pengiriman WHERE aktif = 1";
    $result = mysqli_query($conn, $query);
    $biaya = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $biaya[] = $row;
    }
    return $biaya;
}
?>

