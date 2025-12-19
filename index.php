<?php
session_start();
require_once 'config/koneksi.php';
require_once 'helpers/auth.php';

// Get the requested path
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Remove the base path
$base_path = '/Rekayasa_E-bisnis_KELOMPOK-4';
if (strpos($path, $base_path) === 0) {
    $path = substr($path, strlen($base_path));
}

// Route handling
if ($path === '/' || $path === '/index.php') {
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
} elseif (strpos($path, '/controllers/') === 0) {
    // Route controller requests
    $controller_path = substr($path, 1); // Remove leading slash

    if (file_exists($controller_path)) {
        include $controller_path;
    } else {
        http_response_code(404);
        echo "<h3>Controller tidak ditemukan.</h3>";
    }
} elseif (strpos($path, '/views/') === 0 || strpos($path, '/auth/') === 0) {
    // Allow direct access to views and auth pages
    $file_path = substr($path, 1); // Remove leading slash

    if (file_exists($file_path)) {
        include $file_path;
    } else {
        http_response_code(404);
        echo "<h3>Halaman tidak ditemukan.</h3>";
    }
} else {
    // Default: redirect to home
    header("Location: /Rekayasa_E-bisnis_KELOMPOK-4/");
    exit;
}
?>

