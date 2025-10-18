<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? '';
if ($id) {
    $query = "DELETE FROM users WHERE id_users = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard_admin.php?page=daftar_customer&msg=success");
    } else {
        header("Location: dashboard_admin.php?page=daftar_customer&msg=error");
    }
} else {
    header("Location: dashboard_admin.php?page=daftar_customer&msg=warning");
}
?>

