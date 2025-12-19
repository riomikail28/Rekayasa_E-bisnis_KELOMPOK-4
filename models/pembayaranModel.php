<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllPembayaran() {
    global $conn;
    $query = "SELECT * FROM pembayaran ORDER BY nama_pembayaran ASC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPembayaranById($id) {
    global $conn;
    $query = "SELECT * FROM pembayaran WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function addPembayaran($nama_pembayaran, $deskripsi) {
    global $conn;
    $query = "INSERT INTO pembayaran (nama_pembayaran, deskripsi) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nama_pembayaran, $deskripsi);
    return mysqli_stmt_execute($stmt);
}

function updatePembayaran($id, $nama_pembayaran, $deskripsi) {
    global $conn;
    $query = "UPDATE pembayaran SET nama_pembayaran = ?, deskripsi = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $nama_pembayaran, $deskripsi, $id);
    return mysqli_stmt_execute($stmt);
}

function deletePembayaran($id) {
    global $conn;
    $query = "DELETE FROM pembayaran WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}
?>
