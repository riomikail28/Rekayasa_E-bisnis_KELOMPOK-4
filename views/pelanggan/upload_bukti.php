<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'] ?? null;
    $id_user = $_SESSION['id_users'] ?? null;

    if (!$id_transaksi || !$id_user || !isset($_FILES['bukti'])) {
        header("Location: ../views/pelanggan/riwayat.php?msg=Data tidak lengkap");
        exit;
    }

    $file = $_FILES['bukti'];

    // Validasi error upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../views/pelanggan/riwayat.php?msg=Gagal upload file");
        exit;
    }

    // Validasi tipe dan ukuran
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowed_types)) {
        header("Location: ../views/pelanggan/riwayat.php?msg=Format file tidak didukung");
        exit;
    }

    if ($file['size'] > $max_size) {
        header("Location: ../views/pelanggan/riwayat.php?msg=Ukuran file terlalu besar (maks 2MB)");
        exit;
    }

    // Simpan file
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nama_file = 'bukti_' . time() . '_' . rand(1000,9999) . '.' . $ext;
    $target_dir = '../uploads/';
    $target_file = $target_dir . $nama_file;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Update transaksi
        $stmt = mysqli_prepare($conn, "UPDATE transaksi SET bukti_pembayaran = ?, status = 'dibayar', approved
