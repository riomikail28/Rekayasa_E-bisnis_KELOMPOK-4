<?php
require_once __DIR__ . '/../config/koneksi.php';

//
// ✅ Blokir akses langsung ke controller
//
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['beli'])) {
    header("Location: ../views/pelanggan/katalog.php");
    exit;
}

//
// ✅ Ambil data dari form dan session
//
session_start();
$id_user   = $_SESSION['id_users'] ?? null;
$id_produk = $_POST['id_produk'] ?? null;
$jumlah    = $_POST['jumlah'] ?? 1;
$redirect  = $_POST['redirect'] ?? 'keranjang';

//
// ✅ Validasi input
//
if (!$id_user || !$id_produk || !is_numeric($id_produk)) {
    echo "Data tidak lengkap.";
    exit;
}

//
// ✅ Cek apakah produk sudah ada di keranjang
//
$cek = mysqli_prepare($conn, "SELECT id FROM keranjang WHERE id_user = ? AND id_produk = ?");
mysqli_stmt_bind_param($cek, "ii", $id_user, $id_produk);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {
    // ✅ Update jumlah jika sudah ada
    $update = mysqli_prepare($conn, "UPDATE keranjang SET jumlah = jumlah + ? WHERE id_user = ? AND id_produk = ?");
    mysqli_stmt_bind_param($update, "iii", $jumlah, $id_user, $id_produk);
    mysqli_stmt_execute($update);
    mysqli_stmt_close($update);
} else {
    // ✅ Insert baru jika belum ada
    $insert = mysqli_prepare($conn, "INSERT INTO keranjang (id_user, id_produk, jumlah) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert, "iii", $id_user, $id_produk, $jumlah);
    mysqli_stmt_execute($insert);
    mysqli_stmt_close($insert);
}

//
// ✅ Redirect kembali ke halaman asal
//
if ($redirect === 'katalog') {
    header("Location: ../views/pelanggan/katalog.php?msg=Produk berhasil ditambahkan ke keranjang");
} else {
    header("Location: ../views/pelanggan/keranjang.php?msg=Produk berhasil ditambahkan ke keranjang");
}
exit;


//
// ✅ Fungsi ambil riwayat transaksi
//
function getTransaksiByUser($id_user) {
    global $conn;
    $query = "SELECT 
                t.id, 
                t.id_produk, 
                p.nama_produk, 
                t.jumlah, 
                t.total, 
                t.status, 
                t.bukti_pembayaran, 
                t.approved, 
                t.tanggal 
              FROM transaksi t 
              JOIN produk p ON t.id_produk = p.id 
              WHERE t.id_user = ? 
              ORDER BY t.tanggal DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $data;
}

//
// ✅ Fungsi upload bukti pembayaran
//
function uploadBuktiPembayaran($id, $filename) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE transaksi SET bukti_pembayaran = ?, status = 'dibayar' WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $filename, $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

//
// ✅ Fungsi validasi transaksi oleh admin
//
function approveTransaksi($id_transaksi) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE transaksi SET approved = 'approved' WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_transaksi);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

