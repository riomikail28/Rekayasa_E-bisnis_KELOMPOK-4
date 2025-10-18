<?php
require_once __DIR__ . '/../models/stokModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_stok'])) {
        $id = $_POST['id'];
        $stok = $_POST['stok'];
        if (updateStok($id, $stok)) {
            header("Location: ../views/admin/dashboard_admin.php?page=manajemen_stok&success=1");
        } else {
            header("Location: ../views/admin/dashboard_admin.php?page=manajemen_stok&error=1");
        }
        exit;
    }
}
?>

