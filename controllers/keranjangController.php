<?php
require_once __DIR__ . '/../config/koneksi.php';

// ✅ Ambil semua item keranjang milik user
function getKeranjangByUser($id_user) {
    global $conn;
    $query = "SELECT 
                k.id AS id_keranjang, 
                k.id_produk, 
                k.jumlah, 
                p.nama_produk, 
                p.harga, 
                p.gambar 
              FROM keranjang k 
              JOIN produk p ON k.id_produk = p.id 
              WHERE k.id_user = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $data;
}

// ✅ Tambah item ke keranjang
function tambahKeKeranjang($id_user, $id_produk, $jumlah) {
    global $conn;
    $query = "INSERT INTO keranjang (id_user, id_produk, jumlah) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iii', $id_user, $id_produk, $jumlah);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

// ✅ Hapus item dari keranjang berdasarkan ID keranjang
function hapusItemKeranjang($id_keranjang) {
    global $conn;
    $query = "DELETE FROM keranjang WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_keranjang);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

// ✅ Kosongkan seluruh keranjang milik user
function kosongkanKeranjang($id_user) {
    global $conn;
    $query = "DELETE FROM keranjang WHERE id_user = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_keranjang'])) {
    session_start();
    $id_user = $_SESSION['id_users'] ?? null;
    $id_produk = $_POST['id_produk'] ?? null;
    $jumlah = $_POST['jumlah'] ?? 1;
    $redirect = $_POST['redirect'] ?? '';
    header('Content-Type: application/json');
    if ($id_user && $id_produk) {
        $success = tambahKeKeranjang($id_user, $id_produk, $jumlah);
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Gagal menambah ke keranjang']);
        }
    } else {
        echo json_encode(['success' => false, 'msg' => 'Gagal menambah ke keranjang']);
    }
    exit;
}

// ✅ Validasi kode diskon
function validasiDiskon($kode_diskon) {
    global $conn;
    $query = "SELECT * FROM diskon WHERE kode_diskon = ? AND status = 'active' AND CURDATE() BETWEEN tanggal_mulai AND tanggal_akhir";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $kode_diskon);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $diskon = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $diskon;
}

// ✅ Hitung total dengan diskon
function hitungTotalDenganDiskon($total_belanja, $persentase_diskon) {
    $diskon = $total_belanja * ($persentase_diskon / 100);
    return $total_belanja - $diskon;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_jumlah') {
    session_start();
    $id_keranjang = $_POST['id_keranjang'] ?? null;
    $jumlah = $_POST['jumlah'] ?? null;
    if ($id_keranjang && $jumlah && $jumlah > 0) {
        global $conn;
        $stmt = mysqli_prepare($conn, "UPDATE keranjang SET jumlah = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'ii', $jumlah, $id_keranjang);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Data tidak valid']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'apply_diskon') {
    session_start();
    $kode_diskon = $_POST['kode_diskon'] ?? null;
    $total_belanja = $_POST['total_belanja'] ?? 0;
    header('Content-Type: application/json');
    if ($kode_diskon) {
        $diskon = validasiDiskon($kode_diskon);
        if ($diskon) {
            $total_dengan_diskon = hitungTotalDenganDiskon($total_belanja, $diskon['persentase_diskon']);
            echo json_encode([
                'success' => true,
                'diskon' => $diskon['persentase_diskon'],
                'total_diskon' => $total_belanja * ($diskon['persentase_diskon'] / 100),
                'total_baru' => $total_dengan_diskon
            ]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Kode diskon tidak valid atau sudah kadaluarsa']);
        }
    } else {
        echo json_encode(['success' => false, 'msg' => 'Kode diskon tidak boleh kosong']);
    }
    exit;
}

