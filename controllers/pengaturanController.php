<?php
require_once __DIR__ . '/../models/pengaturanModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_setting'])) {
        $nama_setting = $_POST['nama_setting'];
        $nilai = $_POST['nilai'];

        // Handle file uploads for logo and favicon
        if ($nama_setting === 'logo' && isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../uploads/';
            $file_name = 'logo_' . time() . '.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $file_path = $upload_dir . $file_name;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $file_path)) {
                $nilai = $file_name;
            } else {
                header("Location: ../views/admin/dashboard_admin.php?page=pengaturan_website&error=upload");
                exit;
            }
        } elseif ($nama_setting === 'favicon' && isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../uploads/';
            $file_name = 'favicon_' . time() . '.' . pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION);
            $file_path = $upload_dir . $file_name;
            if (move_uploaded_file($_FILES['favicon']['tmp_name'], $file_path)) {
                $nilai = $file_name;
            } else {
                header("Location: ../views/admin/dashboard_admin.php?page=pengaturan_website&error=upload");
                exit;
            }
        }

        if (updateSetting($nama_setting, $nilai)) {
            header("Location: ../views/admin/dashboard_admin.php?page=pengaturan_website&success=1");
        } else {
            header("Location: ../views/admin/dashboard_admin.php?page=pengaturan_website&error=1");
        }
        exit;
    }
}
?>

