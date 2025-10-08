<?php
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/transaksiController.php';
session_start();

$id_user = $_SESSION['id_users'] ?? null;
$id_transaksi = $_POST['id_transaksi'] ?? null;

if (!$id_user || !$id_transaksi || !isset($_FILES['bukti'])) {
    header("Location: ../views/pelanggan/riwayat.php?msg=Gagal upload bukti");
    exit;
}

$filename = 'bukti_' . time() . '_' . basename($_FILES['bukti']['name']);
$target = '../uploads/' . $filename;

if (move_uploaded_file($_FILES['bukti']['tmp_name'], $target)) {
    if (uploadBuktiPembayaran($id_transaksi, $filename)) {
        header("Location: ../views/pelanggan/riwayat.php?msg=Bukti pembayaran berhasil diupload");
        exit;
    }
}

header("Location: ../views/pelanggan/riwayat.php?msg=Gagal menyimpan bukti");
exit;
