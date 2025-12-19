<?php
require_once 'config/koneksi.php';

function getChat($pengirim, $penerima) {
    global $conn;
    $query = "SELECT * FROM chat WHERE (pengirim = ? AND penerima = ?) OR (pengirim = ? AND penerima = ?) ORDER BY waktu ASC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $pengirim, $penerima, $penerima, $pengirim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function sendMessage($pengirim, $penerima,  $pesan) {
    global $conn;
    $query = "INSERT INTO chat (pengirim, penerima, pesan, waktu) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $pengirim, $penerima, $pesan);
    return mysqli_stmt_execute($stmt);
}

function getAllChatsForAdmin() {
    global $conn;
    $query = "SELECT * FROM chat WHERE penerima = 'admin' ORDER BY waktu ASC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllCustomers() {
    global $conn;
    $query = "SELECT username FROM users WHERE role = 'pelanggan'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
