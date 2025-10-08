<?php
session_start();
require_once '../../config/koneksi.php';
require_once '../../controllers/keranjangController.php';

$id_user = $_SESSION['id_users'] ?? null;
if (!$id_user) {
    echo "<div class='alert alert-warning text-center mt-5'>Silakan login terlebih dahulu.</div>";
    exit;
}

// Ambil isi keranjang
$items = getKeranjangByUser($id_user);
if (empty($items)) {
    echo "<div class='alert alert-warning text-center mt-5'>Keranjang kamu kosong. Tidak ada yang bisa di-checkout.</div>";
    exit;
}

// Ambil input pengiriman dan pembayaran
$pengiriman = $_POST['pengiriman'] ?? null;
$pembayaran = $_POST['pembayaran'] ?? null;

if (!$pengiriman || !$pembayaran) {
    echo "<div class='alert alert-danger text-center mt-5'>Data checkout tidak lengkap. Silakan pilih metode pengiriman dan pembayaran.</div>";
    exit;
}

// Hitung total belanja
$total = 0;
foreach ($items as $item) {
    $total += $item['jumlah'] * $item['harga'];
}

// Simpan transaksi utama
$stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_user, total, metode_pengiriman, metode_pembayaran, status, approval, tgl_transaksi) VALUES (?, ?, ?, ?, 'pending', 'pending', NOW())");
mysqli_stmt_bind_param($stmt, "iiss", $id_user, $total, $pengiriman, $pembayaran);
mysqli_stmt_execute($stmt);
$id_transaksi = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

// Simpan detail transaksi
foreach ($items as $item) {
    $stmt = mysqli_prepare($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiii", $id_transaksi, $item['id_produk'], $item['jumlah'], $item['harga']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Kosongkan keranjang
$stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Buketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-upload {
      background-color: #4caf50;
      color: white;
      border: none;
    }
    .btn-upload:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4 text-center">
          <h3 class="fw-bold mb-3 text-success">✅ Checkout Berhasil!</h3>
          <p class="mb-4">Terima kasih telah berbelanja di Buketminiku. Silakan upload bukti pembayaran di halaman <a href="riwayat.php">Riwayat</a>.</p>
          <a href="riwayat.php" class="btn btn-upload">Upload Bukti Pembayaran</a>
          <a href="katalog.php" class="btn btn-outline-secondary mt-2">Belanja Lagi</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
