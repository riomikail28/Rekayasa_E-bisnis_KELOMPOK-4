<?php
// File ini sudah dipindahkan ke checkout.php
// Silakan gunakan views/pelanggan/checkout.php untuk fitur keranjang dan checkout

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
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="home_login.php">Bucketminiku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="home_login.php">🏠 Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="katalog.php">🛍️ Katalog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="keranjang.php">🛒 Keranjang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="riwayat.php">📦 Riwayat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../../controllers/logout.php" onclick="return confirm('Yakin ingin logout?')">🔓 Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h3 class="fw-bold mb-4 text-center text-primary"><span style="font-size:2rem">🛒</span> Keranjang Belanja</h3>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <?php if (count($keranjang) > 0): ?>
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="table-responsive">
          <table class="table table-bordered align-middle" style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px #eee;">
            <thead class="table-light">
              <tr>
                <th>Gambar</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($keranjang as $item): 
                $subtotal = $item['jumlah'] * $item['harga'];
                $total_belanja += $subtotal;
              ?>
              <tr>
                <td class="text-center"><img src="../../uploads/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_produk']) ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px;box-shadow:0 0 8px #eee;" onerror="this.src='../../uploads/default.jpg'" /></td>
                <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                <td>Rp<?= number_format($item['harga']) ?></td>
                <td>
                  <div class="input-group input-group-sm justify-content-center" style="max-width:120px;">
                    <button class="btn btn-outline-pink btn-minus" data-id="<?= $item['id_keranjang'] ?>" type="button">-</button>
                    <input type="text" class="form-control text-center jumlah-input" value="<?= $item['jumlah'] ?>" data-id="<?= $item['id_keranjang'] ?>" style="width:40px;">
                    <button class="btn btn-outline-pink btn-plus" data-id="<?= $item['id_keranjang'] ?>" type="button">+</button>
                  </div>
                </td>
                <td class="fw-semibold text-success">Rp<?= number_format($subtotal) ?></td>
                <td><a href="../../controllers/hapus_item.php?id=<?= $item['id_keranjang'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin hapus item ini?')">Hapus</a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="text-end mt-3">
          <h5 class="fw-bold">Total Belanja: <span class="text-success">Rp<?= number_format($total_belanja) ?></span></h5>
        </div>
        <div class="text-end mt-4">
          <form method="POST" action="checkout.php">
            <?php foreach ($keranjang as $item): ?>
              <input type="hidden" name="id_produk[]" value="<?= $item['id_produk'] ?>">
              <input type="hidden" name="jumlah[]" value="<?= $item['jumlah'] ?>" class="hidden-jumlah" data-id="<?= $item['id_keranjang'] ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-success btn-lg">Checkout</button>
          </form>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">Keranjang kamu masih kosong. Yuk, belanja dulu di <a href="katalog.php">katalog</a>!</div>
  <?php endif; ?>
</div>

<script>
// Fitur -+ jumlah produk di keranjang
const minusBtns = document.querySelectorAll('.btn-minus');
const plusBtns = document.querySelectorAll('.btn-plus');
const jumlahInputs = document.querySelectorAll('.jumlah-input');

function updateJumlah(id, jumlah, input) {
  fetch('../../controllers/keranjangController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=update_jumlah&id_keranjang=${id}&jumlah=${jumlah}`
  }).then(res => res.json()).then(data => {
    if (data.success) {
      // Update subtotal dan total belanja di frontend
      const harga = parseInt(input.closest('tr').querySelector('td:nth-child(3)').textContent.replace(/[^\d]/g, ''));
      const subtotalCell = input.closest('tr').querySelector('td:nth-child(5)');
      const newSubtotal = harga * jumlah;
      subtotalCell.textContent = 'Rp' + newSubtotal.toLocaleString();
      // Update total belanja
      let total = 0;
      document.querySelectorAll('.jumlah-input').forEach(inp => {
        const row = inp.closest('tr');
        const harga = parseInt(row.querySelector('td:nth-child(3)').textContent.replace(/[^\d]/g, ''));
        const jumlah = parseInt(inp.value);
        total += harga * jumlah;
      });
      document.querySelector('.text-end.mt-3 h5 span').textContent = 'Rp' + total.toLocaleString();
    } else {
      alert('Gagal update jumlah!');
    }
  });
}

function syncHiddenJumlah(id, jumlah) {
  const hiddenInput = document.querySelector('.hidden-jumlah[data-id="'+id+'"]');
  if (hiddenInput) hiddenInput.value = jumlah;
}

minusBtns.forEach(btn => {
  btn.addEventListener('click', function() {
    const id = this.dataset.id;
    const input = document.querySelector('.jumlah-input[data-id="'+id+'"]');
    let val = parseInt(input.value);
    if (val > 1) {
      val--;
      input.value = val;
      updateJumlah(id, val, input);
      syncHiddenJumlah(id, val);
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
    updateJumlah(id, val, input);
    syncHiddenJumlah(id, val);
  });
});
jumlahInputs.forEach(input => {
  input.addEventListener('change', function() {
    const id = this.dataset.id;
    let val = parseInt(this.value);
    if (val > 0) {
      updateJumlah(id, val, this);
      syncHiddenJumlah(id, val);
    }
  });
});
</script>
<style>
.btn-outline-pink { border-color:#ff4d7e;color:#ff4d7e; }
.btn-outline-pink:hover { background:#ff4d7e;color:#fff; }
.btn-success.btn-lg { font-size:1.2rem;padding:0.7rem 2.5rem;border-radius:8px; }
.table-bordered th, .table-bordered td { vertical-align:middle; }
.table-bordered { border-radius:12px; overflow:hidden; }
</style>

</body>
</html>

