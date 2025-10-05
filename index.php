<?php
session_start();
require_once 'config/koneksi.php';
require_once 'helpers/auth.php';

// Jika belum login, tampilkan home
if (!isset($_SESSION['user_id'])) {
    if (file_exists('views/home.php')) {
        include 'views/home.php';
    } else {
        echo "<h3>File views/home.php tidak ditemukan.</h3>";
    }
    exit;
}

// Jika sudah login, arahkan sesuai role
if (isAdmin()) {
    header("Location: views/admin/dashboard_admin.php");
    exit;
} elseif (isUser()) {
    header("Location: views/pelanggan/profil.php");
    exit;
} else {
    echo "<div class='alert alert-danger text-center mt-5'>Role tidak dikenali. Silakan login ulang.</div>";
    session_destroy();
}
?>
