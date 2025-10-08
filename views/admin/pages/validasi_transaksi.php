<?php
require_once __DIR__ . '/../../../config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_transaksi = $_GET['id'] ?? null;
$aksi = $_GET['aksi'] ?? null;

if (!$id_transaksi || !in_array($aksi, ['verifikasi', 'tolak'])) {
    echo "<div class='alert alert-danger text-center'>Data tidak valid.</div>";
    echo "<script>setTimeout(() => window.location.href='dashboard_admin.php?page=admin_transaksi', 2000);</script>";
    exit;
}

// Tentukan status dan approved sesuai aksi
$status = $aksi === 'verifikasi' ? 'dibayar' : 'pending';
$approved = $aksi === 'verifikasi' ? 'disetujui' : 'ditolak';

// Update transaksi
$stmt = mysqli_prepare($conn, "UPDATE transaksi SET status = ?, approved = ? WHERE id = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $status, $approved, $id_transaksi);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<div class='alert alert-success text-center'>Transaksi #$id_transaksi berhasil diupdate sebagai <strong>$approved</strong>.</div>";
} else {
    echo "<div class='alert alert-danger text-center'>Gagal memproses transaksi. Silakan cek struktur tabel atau koneksi.</div>";
}

echo "<script>setTimeout(() => window.location.href='dashboard_admin.php?page=admin_transaksi', 2000);</script>";
