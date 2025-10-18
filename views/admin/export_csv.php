<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

// Validasi akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit('Akses ditolak');
}

// Ambil parameter tanggal
$tgl_awal = $_GET['awal'] ?? '';
$tgl_akhir = $_GET['akhir'] ?? '';

$where = '';
if ($tgl_awal && $tgl_akhir) {
    $where = "WHERE t.tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

// Query data transaksi
$query = "SELECT
            t.id AS id_transaksi,
            t.tgl_transaksi,
            u.username,
            u.alamat,
            t.total,
            t.metode_pembayaran,
            t.status,
            t.approved
          FROM transaksi t
          JOIN users u ON t.id_user = u.id_users
          $where
          ORDER BY t.tgl_transaksi DESC";

$result = mysqli_query($conn, $query);

// Header CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=laporan_penjualan.csv');

// Buka output stream
$output = fopen('php://output', 'w');

// Header kolom
fputcsv($output, ['ID Transaksi', 'Tanggal', 'Username', 'Alamat', 'Total', 'Pembayaran', 'Status', 'Approved']);

// Isi data
while ($row = mysqli_fetch_assoc($result)) {
fputcsv($output, [
        $row['id_transaksi'],
        date('Y-m-d H:i:s', strtotime($row['tgl_transaksi'])),
        $row['username'],
        $row['alamat'],
        $row['total'],
        $row['metode_pembayaran'],
        $row['status'],
        $row['approved']
    ]);
}

fclose($output);
exit;

