<?php
session_start();
require_once __DIR__ . '/../../controllers/keranjangController.php';

$id_user = $_SESSION['id_users'] ?? null;
if (!$id_user) {
    echo "<div class='alert alert-warning text-center mt-5'>Silakan login untuk melihat keranjang.</div>";
    exit;
}

$keranjang = getKeranjangByUser($id_user);
$total_belanja = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-product {
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .img-thumb {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
    }
    .btn-hapus {
      font-size: 0.85rem;
    }
    .summary-box {
      border-radius: 12px;
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 20px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="home_login.php">Buketminiku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="home_login.php">🏠 Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="keranjang.php">🛒 Keranjang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="riwayat.php">📦 Riwayat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../../auth/logout.php" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h3 class="fw-bold mb-4 text-center text-primary">🛒 Keranjang Belanja</h3>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <?php if (count($keranjang) > 0): ?>
    <div class="row">
      <div class="col-lg-8">
        <?php foreach ($keranjang as $item): 
          $subtotal = $item['jumlah'] * $item['harga'];
          $total_belanja += $subtotal;
        ?>
        <div class="card mb-3 card-product">
          <div class="row g-0 align-items-center">
            <div class="col-md-2 text-center p-2">
              <img src="../../uploads/<?= htmlspecialchars($item['gambar']) ?>" 
                   alt="<?= htmlspecialchars($item['nama_produk']) ?>" 
                   class="img-thumb" 
                   onerror="this.src='../../uploads/default.jpg'" />
            </div>
            <div class="col-md-6">
              <div class="card-body">
                <h5 class="card-title mb-1"><?= htmlspecialchars($item['nama_produk']) ?></h5>
                <p class="card-text text-muted mb-0">Rp<?= number_format($item['harga']) ?> / item</p>
                <small class="text-muted">Jumlah: <?= $item['jumlah'] ?> pcs</small>
              </div>
            </div>
            <div class="col-md-2 text-center">
              <p class="fw-semibold mb-1 text-success">Rp<?= number_format($subtotal) ?></p>
            </div>
            <div class="col-md-2 text-center">
              <a href="../../controllers/hapus_item.php?id=<?= $item['id_keranjang'] ?>" 
                 class="btn btn-sm btn-outline-danger btn-hapus" 
                 onclick="return confirm('Yakin ingin hapus item ini?')">Hapus</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <div class="text-end mt-3">
        <h5 class="fw-bold">Total Belanja: <span class="text-success">Rp<?= number_format($total_belanja) ?></span></h5>
      </div>

      </div>

      <div class="col-lg-4">
              <div class="summary-box">
                <form method="POST" action="../../controllers/checkoutController.php">
        <?php foreach ($keranjang as $item): ?>
          <input type="hidden" name="id_produk[]" value="<?= $item['id_produk'] ?>">
          <input type="hidden" name="jumlah[]" value="<?= $item['jumlah'] ?>">
        <?php endforeach; ?>

        <div class="mb-3">
          <label for="pengiriman" class="form-label">Metode Pengiriman</label>
          <select name="pengiriman" id="pengiriman" class="form-select" required>
            <option value="">-- Pilih Pengiriman --</option>
            <option value="GoSend">GoSend</option>
            <option value="GrabExpress">GrabExpress</option>
            <option value="Shopee Instant">Shopee Instant</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="pembayaran" class="form-label">Metode Pembayaran</label>
          <select name="pembayaran" id="pembayaran" class="form-select" required>
            <option value="">-- Pilih Pembayaran --</option>
            <option value="Transfer BCA">Transfer BCA</option>
            <option value="Transfer BNI">Transfer BNI</option>
            <option value="COD">COD (Bayar di tempat)</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Lanjut ke Checkout</button>
      </form>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">Keranjang kamu masih kosong. Yuk, belanja dulu di <a href="katalog.php">katalog</a>!</div>
  <?php endif; ?>
</div>

</body>
</html>
