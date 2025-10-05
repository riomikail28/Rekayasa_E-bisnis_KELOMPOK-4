<?php
require_once '../../config/koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Katalog Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .produk-card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: 0.3s;
    }
    .produk-card:hover {
      transform: scale(1.02);
    }
    .produk-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 12px 12px 0 0;
    }
    .btn-beli {
      background-color: #ff6ec4;
      color: white;
      border: none;
    }
    .btn-beli:hover {
      background-color: #ff4fa8;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="text-center fw-bold mb-4">🌸 Wishlist Buketminiku</h2>

    <div class="row">
      <?php while ($p = mysqli_fetch_assoc($result)): ?>
        <?php
          // Path gambar disesuaikan dengan posisi file katalog.php
          $gambar = $p['gambar'] ?? '';
          $gambarPath = $gambar ? "../../uploads/$gambar" : "../../assets/default.png";
        ?>
        <div class="col-md-3 mb-4">
          <div class="card produk-card h-100">
            <img src="<?= $gambarPath ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" class="produk-img">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($p['nama_produk']) ?></h5>
              <p class="fw-semibold text-muted">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
              <form method="POST" action="../../controllers/transaksiController.php">
                <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
                <input type="number" name="jumlah" value="1" min="1" class="form-control mb-2">
                <button type="submit" name="beli" class="btn btn-beli w-100">Beli</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
