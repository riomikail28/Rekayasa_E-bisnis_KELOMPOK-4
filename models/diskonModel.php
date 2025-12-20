<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllDiskon() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM diskon ORDER BY id DESC");
    $diskon = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $diskon[] = $row;
    }
    return $diskon;
}

function getDiskonById($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM diskon WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $diskon = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $diskon;
}

function addDiskon($kode_diskon, $persentase_diskon, $tanggal_mulai, $tanggal_akhir, $status) {
    global $conn;
    $stmt = mysqli_prepare($conn, "INSERT INTO diskon (kode_diskon, persentase_diskon, tanggal_mulai, tanggal_akhir, status) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sisss", $kode_diskon, $persentase_diskon, $tanggal_mulai, $tanggal_akhir, $status);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function updateDiskon($id, $kode_diskon, $persentase_diskon, $tanggal_mulai, $tanggal_akhir, $status) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE diskon SET kode_diskon = ?, persentase_diskon = ?, tanggal_mulai = ?, tanggal_akhir = ?, status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sisssi", $kode_diskon, $persentase_diskon, $tanggal_mulai, $tanggal_akhir, $status, $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function deleteDiskon($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM diskon WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function isKodeDiskonExists($kode_diskon, $exclude_id = null) {
    global $conn;
    $query = "SELECT id FROM diskon WHERE kode_diskon = ?";
    $params = [$kode_diskon];
    $types = "s";

    if ($exclude_id) {
        $query .= " AND id != ?";
        $params[] = $exclude_id;
        $types .= "i";
    }

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $exists = mysqli_fetch_assoc($result) !== null;
    mysqli_stmt_close($stmt);
    return $exists;
}
?>
