<?php
session_start();
require_once '../../config/koneksi.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_users'];

$id_produk = $_GET['id_produk'] ?? null;
if (!$id_produk) {
    echo "<div class='alert alert-warning text-center mt-5'>Produk tidak ditemukan.</div>";
    exit;
}

require_once '../../models/produkModel.php';
$produk = getProdukById($id_produk);
if (!$produk) {
    echo "<div class='alert alert-warning text-center mt-5'>Produk tidak ditemukan.</div>";
    exit;
}

$gambar = $produk['gambar'] ?? '';
$gambarPath = $gambar ? "../../uploads/$gambar" : "../../assets/default.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Produk - <?= htmlspecialchars($produk['nama_produk']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>

<!-- Tombol Toggle Sidebar (opsional, bisa dihapus jika tidak perlu) -->
<button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar-wrapper">
  <!-- Sidebar Kiri -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <h4 class="fw-bold text-primary">Bucketminiku</h4>
    </div>
    <a href="katalog.php">🏠 Katalog</a>
    <a href="keranjang.php">🛒 Keranjang</a>
    <a href="riwayat.php">📦 Riwayat</a>
    <a href="home_login.php">🏠 Home</a>
    <a href="../../controllers/logout.php" class="text-danger" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
  </div>
</div>

<!-- Konten Detail Produk -->
<div class="content-area py-4 px-4">
  <a href="katalog.php" class="btn btn-secondary mb-3">← Kembali ke Katalog</a>
  <h3 class="fw-bold text-center mb-4">Detail Produk</h3>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card produk-card">
        <img src="<?= $gambarPath ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>" class="produk-img">
        <div class="card-body text-center">
          <h5 class="card-title"><?= htmlspecialchars($produk['nama_produk']) ?></h5>
          <div class="produk-deskripsi">
            <?php
            $deskripsi = $produk['deskripsi'];
            $paragraphs = preg_split('/\n\s*\n/', $deskripsi);
            foreach ($paragraphs as $p) {
              $p = trim($p);
              if (!empty($p)) {
                echo '<p>' . nl2br(htmlspecialchars($p)) . '</p>';
              }
            }
            ?>
          </div>
          <p class="fw-semibold text-muted">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

          <!-- Quantity Selector -->
          <div class="input-group input-group-sm mb-2 justify-content-center" style="max-width:120px;margin:auto;">
            <button type="button" class="btn btn-outline-pink btn-minus" data-id="<?= $produk['id'] ?>">-</button>
            <input type="text" name="jumlah" value="1" min="1" class="form-control text-center jumlah-input" data-id="<?= $produk['id'] ?>" style="width:40px;">
            <button type="button" class="btn btn-outline-pink btn-plus" data-id="<?= $produk['id'] ?>">+</button>
          </div>

          <!-- Masukkan Keranjang Form -->
          <form method="POST" action="../../controllers/keranjangController.php" class="mb-2 keranjang-form">
            <input type="hidden" name="id_produk" value="<?= $produk['id'] ?>">
            <input type="hidden" name="jumlah" value="1" class="hidden-jumlah-keranjang" data-id="<?= $produk['id'] ?>">
            <input type="hidden" name="redirect" value="stay">
            <input type="hidden" name="tambah_keranjang" value="1">
            <button type="button" class="btn btn-outline-pink w-100 mb-2 btn-keranjang" data-id="<?= $produk['id'] ?>">Masukkan Keranjang</button>
          </form>

          <!-- BELI Button -->
          <form method="GET" action="checkout.php">
            <input type="hidden" name="id_produk" value="<?= $produk['id'] ?>">
            <input type="hidden" name="jumlah" value="1" class="hidden-jumlah-beli" data-id="<?= $produk['id'] ?>">
            <button type="submit" class="btn btn-beli w-100">BELI</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleSidebar() {
    document.body.classList.toggle('sidebar-hidden');
  }

  document.querySelectorAll('.btn-keranjang').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      var form = btn.closest('.keranjang-form');
      var formData = new FormData(form);
      fetch('../../controllers/keranjangController.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showToast('Produk berhasil dimasukkan ke keranjang!');
        } else {
          showToast('Gagal menambah ke keranjang!', true);
        }
      })
      .catch(() => showToast('Terjadi kesalahan!', true));
    });
  });

  function showToast(msg, error = false) {
    let toast = document.createElement('div');
    toast.className = 'toast-keranjang ' + (error ? 'bg-danger' : 'bg-success');
    toast.textContent = msg;
    toast.style.cssText = 'position:fixed;top:24px;right:24px;z-index:9999;padding:12px 24px;color:#fff;border-radius:8px;font-weight:600;box-shadow:0 2px 12px #eee;';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
  }

  // Fitur -+ jumlah produk
  const minusBtns = document.querySelectorAll('.btn-minus');
  const plusBtns = document.querySelectorAll('.btn-plus');
  const jumlahInputs = document.querySelectorAll('.jumlah-input');

  function syncJumlah(id, jumlah) {
    const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
    if (input) input.value = jumlah;
    const hiddenKeranjang = document.querySelector('.hidden-jumlah-keranjang[data-id="'+id+'"]');
    if (hiddenKeranjang) hiddenKeranjang.value = jumlah;
    const hiddenBeli = document.querySelector('.hidden-jumlah-beli[data-id="'+id+'"]');
    if (hiddenBeli) hiddenBeli.value = jumlah;
  }

  minusBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
      let val = parseInt(input.value);
      if (val > 1) {
        val--;
        input.value = val;
        syncJumlah(id, val);
      }
    });
  });
  plusBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
      let val = parseInt(input.value);
      val++;
      input.value = val;
      syncJumlah(id, val);
    });
  });
  jumlahInputs.forEach(input => {
    input.addEventListener('change', function() {
      const id = this.dataset.id;
      let val = parseInt(this.value);
      if (val > 0) {
        syncJumlah(id, val);
      }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
