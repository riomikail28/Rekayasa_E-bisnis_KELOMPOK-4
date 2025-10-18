<?php
require_once __DIR__ . '/../models/pengirimanModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_pengiriman'])) {
        $data = [
            'nama_pengiriman' => $_POST['nama_pengiriman'],
            'biaya' => $_POST['biaya'],
            'deskripsi' => $_POST['deskripsi']
        ];
        if (addPengiriman($data)) {
            header("Location: ../views/admin/dashboard_admin.php?page=manajemen_pengiriman&success=1");
        } else {
            header("Location: ../views/admin/dashboard_admin.php?page=manajemen_pengiriman&error=1");
        }
        exit;
    } elseif (isset($_POST['update_pengiriman'])) {
        $id = $_POST['id'];
        $data = [
            'nama_pengiriman' => $_POST['nama_pengiriman'],
            'biaya' => $_POST['biaya'],
            'deskripsi' => $_POST['deskripsi']
        ];
        if (updatePengiriman($id, $data)) {
            header("Location: ../views/admin/dashboard_admin.php?page=manajemen_pengiriman&success=1");
        } else {
            header("Location: ../views/admin/dashboard_admin.php?page=manajemen_pengiriman&error=1");
        }
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deletePengiriman($id)) {
        header("Location: ../views/admin/dashboard_admin.php?page=manajemen_pengiriman&success=1");
    } else {
        header("Location: ../views/admin/dashboard_admin.php?page=manajemen_pengiriman&error=1");
    }
    exit;
}
?>

