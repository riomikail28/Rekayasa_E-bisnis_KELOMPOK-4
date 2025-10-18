<?php
session_start();
require_once '../../config/koneksi.php';
require_once '../../controllers/keranjangController.php';
require_once '../../models/userModel.php';
require_once '../../models/pengirimanModel.php';

$id_user = $_SESSION['id_users'] ?? null;
if (!$id_user) {
    echo "<div class='alert alert-warning text-center mt-5'>Silakan login terlebih dahulu.</div>";
    exit;
}

$user = getUserById($id_user);
$alamat = $user['alamat'] ?? '-';

// Ambil isi keranjang atau data langsung dari katalog
$id_produk = $_GET['id_produk'] ?? $_POST['id_produk'] ?? null;
$jumlah = $_GET['jumlah'] ?? $_POST['jumlah'] ?? null;
require_once '../../models/produkModel.php';

if (isset($_POST['id_produk']) && isset($_POST['jumlah']) && is_array($_POST['id_produk']) && is_array($_POST['jumlah'])) {
    // Checkout dari keranjang (POST array)
    $items = [];
    $debug_invalid = [];
    foreach ($_POST['id_produk'] as $idx => $id_produk) {
        $id_produk = intval($id_produk);
        $jumlah = isset($_POST['jumlah'][$idx]) ? intval($_POST['jumlah'][$idx]) : 0;
        $produk = getProdukById($id_produk);
        if (!empty($produk) && $jumlah > 0) {
            $items[] = [
                'id_produk' => $id_produk,
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'jumlah' => $jumlah
            ];
        } else {
            $debug_invalid[] = [
                'id_produk' => $id_produk,
                'jumlah' => $jumlah,
                'produk' => $produk
            ];
        }
    }
    if (empty($items)) {
        echo "<div class='alert alert-warning text-center mt-5'>Produk tidak ditemukan atau jumlah tidak valid.<br><br>Debug:<br>";
        foreach ($debug_invalid as $err) {
            echo "ID: ".$err['id_produk'].", Jumlah: ".$err['jumlah'].", Produk: ".(empty($err['produk']) ? 'NOT FOUND' : 'FOUND')."<br>";
        }
        echo "</div>";
        exit;
    }
} elseif ($id_produk && $jumlah) {
    // Single product checkout
    $id_produk = intval($id_produk);
    $jumlah = intval($jumlah);
    $produk = getProdukById($id_produk);
    if ($produk && $jumlah > 0) {
        $items = [[
            'id_produk' => $produk['id'],
            'nama_produk' => $produk['nama_produk'],
            'harga' => $produk['harga'],
            'jumlah' => $jumlah
        ]];
    } else {
        echo "<div class='alert alert-warning text-center mt-5'>Produk tidak ditemukan atau jumlah tidak valid.</div>";
        exit;
    }
} else {
    // Cart checkout (tanpa POST, fallback ke keranjang)
    $raw_items = getKeranjangByUser($id_user);
    if (empty($raw_items)) {
        echo "<div class='alert alert-warning text-center mt-5'>Keranjang kamu kosong. Tidak ada yang bisa di-checkout.</div>";
        exit;
    }
    $items = [];
    foreach ($raw_items as $item) {
        $produk = getProdukById($item['id_produk']);
        if (!empty($produk) && $item['jumlah'] > 0) {
            $items[] = [
                'id_produk' => $item['id_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'jumlah' => $item['jumlah']
            ];
        }
    }
    if (empty($items)) {
        echo "<div class='alert alert-warning text-center mt-5'>Produk tidak ditemukan atau jumlah tidak valid.</div>";
        exit;
    }
}

// Hitung total belanja (selalu tersedia untuk ringkasan belanja)
$total = 0;
foreach ($items as $item) {
    $total += $item['jumlah'] * $item['harga'];
}

// Ambil input pengiriman dan pembayaran
$pengiriman = $_POST['pengiriman'] ?? null;
$pembayaran = $_POST['pembayaran'] ?? null;

if (!$pengiriman || !$pembayaran) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8">
      <title>Checkout - Bucketminiku</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="../../assets/css/main.css">
      <style>
        .checkout-card { box-shadow:0 2px 16px #f8cdda33; border-radius:16px; }
        .gradient-header { background:linear-gradient(90deg,#f8cdda,#fbc2eb); color:#fff; border-radius:16px 16px 0 0; }
        .form-label { font-weight:500; }
        .summary-card { background:#fff6fa; border-radius:12px; }
        .icon-checkout { font-size:2.5rem; color:#f06292; }
      </style>
    </head>
    <body>
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card checkout-card">
              <div class="gradient-header p-4 text-center">
                <span class="icon-checkout">🛍️</span>
                <h3 class="fw-bold mb-0">Checkout Bucketminiku</h3>
              </div>
              <div class="card-body">
                <div class="alert alert-danger text-center mb-4"><br>Silakan pilih metode pengiriman dan pembayaran.</div>
                <div class="mb-3">
                  <label class="form-label">Alamat Pengiriman</label>
                  <div class="p-3 rounded bg-light border mb-2" style="min-height:48px;">
                    <span class="fw-semibold text-secondary"><?= htmlspecialchars($alamat) ?></span>
                    <a href="edit_profil.php" class="float-end btn btn-sm btn-outline-pink">Ubah Alamat</a>
                  </div>
                </div>
                <form method="POST" action="checkout.php">
                  <div class="mb-3">
                    <label for="pengiriman" class="form-label">Metode Pengiriman</label>
                    <select class="form-select" id="pengiriman" name="pengiriman" required>
                      <option value="">- Pilih Pengiriman -</option>
                      <?php
                      require_once '../../models/pengirimanModel.php';
                      $biaya_pengiriman = getBiayaPengiriman();
                      foreach ($biaya_pengiriman as $p):
                      ?>
                        <option value="<?= htmlspecialchars($p['nama_pengiriman']) ?>" data-biaya="<?= $p['biaya'] ?>"><?= htmlspecialchars($p['nama_pengiriman']) ?> - Rp<?= number_format($p['biaya'], 0, ',', '.') ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                    <select class="form-select" id="pembayaran" name="pembayaran" required>
                      <option value="">- Pilih Pembayaran -</option>
                      <option value="Transfer BCA">Transfer BCA</option>
                      <option value="Transfer Mandiri">Transfer Mandiri</option>
                      <option value="OVO">OVO</option>
                      <option value="DANA">DANA</option>
                      <option value="COD">COD</option>
                    </select>
                  </div>
                  <div class="mb-4 summary-card p-3">
                    <h5 class="fw-bold mb-2">Ringkasan Belanja</h5>
                    <ul class="list-unstyled mb-2">
                      <?php foreach ($items as $item): ?>
                        <li class="mb-1">
                          <span class="fw-semibold"><?= htmlspecialchars($item['nama_produk']) ?></span> x <?= $item['jumlah'] ?> <span class="float-end text-success">Rp<?= number_format($item['jumlah'] * $item['harga']) ?></span>
                        </li>
                      <?php endforeach; ?>
                      <li class="mb-1" id="shipping-line" style="display: none;">
                        <span class="fw-semibold">Biaya Pengiriman</span> <span class="float-end text-success" id="shipping-cost">Rp0</span>
                      </li>
                    </ul>
                    <div class="fw-bold text-end">Total: <span class="text-success" id="total-amount">Rp<?= number_format($total) ?></span></div>
                  </div>
                  <button type="submit" class="btn btn-pink w-100 py-2 fw-bold">Checkout Sekarang</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <script>
        document.getElementById('pengiriman').addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const biaya = selectedOption.getAttribute('data-biaya') ? parseInt(selectedOption.getAttribute('data-biaya')) : 0;
          const shippingLine = document.getElementById('shipping-line');
          const shippingCost = document.getElementById('shipping-cost');
          const totalAmount = document.getElementById('total-amount');
          const baseTotal = <?= $total ?>;

          if (biaya > 0) {
            shippingLine.style.display = 'block';
            shippingCost.textContent = 'Rp' + biaya.toLocaleString('id-ID');
            totalAmount.textContent = 'Rp' + (baseTotal + biaya).toLocaleString('id-ID');
          } else {
            shippingLine.style.display = 'none';
            shippingCost.textContent = 'Rp0';
            totalAmount.textContent = 'Rp' + baseTotal.toLocaleString('id-ID');
          }
        });
      </script>
    </body>
    </html>
    <?php
    exit;
}

// Hitung biaya pengiriman
$biaya_pengiriman = 0;
$biaya_pengiriman_list = getBiayaPengiriman();
foreach ($biaya_pengiriman_list as $p) {
    if ($p['nama_pengiriman'] == $pengiriman) {
        $biaya_pengiriman = $p['biaya'];
        break;
    }
}
$total_dengan_pengiriman = $total + $biaya_pengiriman;

// Simpan transaksi utama
$stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_user, total, metode_pengiriman, metode_pembayaran, status, tgl_transaksi) VALUES (?, ?, ?, ?, 'pending', NOW())");
mysqli_stmt_bind_param($stmt, "iiss", $id_user, $total_dengan_pengiriman, $pengiriman, $pembayaran);
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

// Kosongkan keranjang hanya jika checkout dari keranjang
if (!isset($_GET['id_produk'])) {
    $stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Bucketminiku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/main.css">
  <style>
    .checkout-card { box-shadow:0 2px 16px #f8cdda33; border-radius:16px; }
    .gradient-header { background:linear-gradient(90deg,#f8cdda,#fbc2eb); color:#fff; border-radius:16px 16px 0 0; }
    .icon-checkout { font-size:2.5rem; color:#f06292; }
    .btn-upload-green { background:#43e97b; color:#fff; border-radius:8px; font-weight:600; }
    .btn-upload-green:hover { background:#38c172; color:#fff; }
    .btn-outline-secondary { border-radius:8px; }
    .success-anim { font-size:3rem; animation:pop 0.7s cubic-bezier(.68,-0.55,.27,1.55) 1; }
    @keyframes pop { 0%{transform:scale(0.7);} 80%{transform:scale(1.2);} 100%{transform:scale(1);} }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4 text-center checkout-card">
          <div class="gradient-header p-4">
            <span class="success-anim">✅</span>
            <h3 class="fw-bold mb-3">Checkout Berhasil!</h3>
          </div>
          <div class="card-body">
            <p class="mb-4">Terima kasih telah berbelanja di Bucketminiku.<br>Silakan upload bukti pembayaran di halaman <a href="riwayat.php" class="fw-bold text-pink">Riwayat</a>.</p>
            <a href="riwayat.php" class="btn btn-upload-green">Upload Bukti Pembayaran</a>
            <a href="katalog.php" class="btn btn-outline-secondary mt-2">Belanja Lagi</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

