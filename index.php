<?php
session_start();
require_once 'config/koneksi.php';
require_once 'helpers/auth.php';

// Jika user sudah login
if (isset($_SESSION['role'])) {
    if (isAdmin()) {
        include 'views/dashboard_admin.php';
    } elseif (isPelanggan()) {
        include 'views/pelanggan/home.php'; // pindahkan home pelanggan ke folder yang konsisten
    } else {
        echo "Role tidak dikenali.";
    }
} else {
    // Jika belum login, tampilkan halaman depan
    if (file_exists('views/home.php')) {
        include 'views/home.php';
    } else {
        echo "<h3>File views/home.php tidak ditemukan.</h3>";
    }
}
