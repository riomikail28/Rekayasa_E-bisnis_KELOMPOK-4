<?php
require_once __DIR__ . '/../config/koneksi.php';

function getAllSettings() {
    global $conn;
    $query = "SELECT * FROM tb_pengaturan";
    $result = mysqli_query($conn, $query);
    $settings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['nama_setting']] = $row['nilai'];
    }
    return $settings;
}

function updateSetting($nama_setting, $nilai) {
    global $conn;
    $query = "UPDATE tb_pengaturan SET nilai = ? WHERE nama_setting = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $nilai, $nama_setting);
    return mysqli_stmt_execute($stmt);
}

function getSetting($nama_setting) {
    global $conn;
    $query = "SELECT nilai FROM tb_pengaturan WHERE nama_setting = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nama_setting);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row['nilai'] : null;
}
?>

