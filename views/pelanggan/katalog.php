<?php
session_start();
require_once '../../config/koneksi.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_users'];

// Ambil kategori unik
$kategori = [];
$kategori_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk");
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategori[] = $row['kategori'];
}

// Filter produk jika ada kategori
$filter_kategori = $_GET['kategori'] ?? null;

if ($filter_kategori) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE kategori = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, "s", $filter_kategori);
} else {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk ORDER BY id DESC");
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Katalog Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>

<!-- ✅ Tombol Toggle Sidebar -->
<button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar-wrapper">
  <!-- ✅ Sidebar Kiri -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <h4 class="fw-bold text-primary">Buketminiku</h4>
    </div>
    <a href="katalog.php" class="<?= !$filter_kategori ? 'active' : '' ?>">🏠 Semua Produk</a>
    <?php foreach ($kategori as $kat): ?>
      <a href="katalog.php?kategori=<?= urlencode($kat) ?>" class="<?= ($filter_kategori === $kat) ? 'active' : '' ?>">
        <?= htmlspecialchars(ucwords($kat)) ?>
      </a>
    <?php endforeach; ?>
    <hr>
    <a href="keranjang.php">🛒 Keranjang</a>
    <a href="riwayat.php">📦 Riwayat</a>
    <a href="home_login.php">🏠 Home</a>
    <a href="../../controllers/logout.php" class="text-danger" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
  </div>
</div>

<!-- ✅ Konten Produk -->
<div class="content-area py-4 px-4">
  <h3 class="fw-bold text-center mb-4">🌸 Wishlist Buketminiku</h3>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <div class="row">
    <?php while ($p = mysqli_fetch_assoc($result)): ?>
      <?php
        $gambar = $p['gambar'] ?? '';
        $gambarPath = $gambar ? "../../uploads/$gambar" : "../../assets/default.png";
      ?>
      <div class="col-md-4 mb-4">
        <div class="card produk-card h-100">
          <img src="<?= $gambarPath ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" class="produk-img">
          <div class="card-body">
            <h5 class="card-title text-center"><?= htmlspecialchars($p['nama_produk']) ?></h5>
            <p class="produk-deskripsi"><?= htmlspecialchars($p['deskripsi']) ?></p>
            <p class="fw-semibold text-muted text-center">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
            <form method="POST" action="../../controllers/keranjangController.php" class="mb-2 keranjang-form">
              <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
              <div class="input-group input-group-sm mb-2 justify-content-center" style="max-width:120px;margin:auto;">
                <button type="button" class="btn btn-outline-pink btn-minus" data-id="<?= $p['id'] ?>">-</button>
                <input type="text" name="jumlah" value="1" min="1" class="form-control text-center jumlah-input" data-id="<?= $p['id'] ?>" style="width:40px;">
                <button type="button" class="btn btn-outline-pink btn-plus" data-id="<?= $p['id'] ?>">+</button>
              </div>
              <input type="hidden" name="redirect" value="stay">
              <input type="hidden" name="tambah_keranjang" value="1">
              <button type="button" class="btn btn-outline-pink w-100 mb-2 btn-keranjang" data-id="<?= $p['id'] ?>">Masukkan Keranjang</button>
            </form>
            <form method="GET" action="checkout.php" class="form-beli">
              <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
              <input type="hidden" name="jumlah" value="1" class="hidden-jumlah-beli" data-id="<?= $p['id'] ?>">
              <button type="submit" class="btn btn-beli w-100">BELI</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
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

  // Fitur -+ jumlah produk di katalog
  const minusBtns = document.querySelectorAll('.btn-minus');
  const plusBtns = document.querySelectorAll('.btn-plus');
  const jumlahInputs = document.querySelectorAll('.jumlah-input');

  function syncJumlah(id, jumlah) {
    // Untuk keranjang
    const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
    if (input) input.value = jumlah;
    // Untuk form BELI
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
<style>
.toast-keranjang { transition:all .3s; opacity:0.95; }
</style>
</body>
</html>
