<?php
require_once __DIR__ . '/../../../config/koneksi.php';

// Daftar Laporan Keuangan
$laporan_keuangan = [
    ['nama' => 'Laporan Pendapatan', 'deskripsi' => 'Laporan pendapatan bulanan dan tahunan'],
    ['nama' => 'Laporan Pengeluaran', 'deskripsi' => 'Laporan pengeluaran operasional']
];

// Laporan Pendapatan
$query_pendapatan = "SELECT DATE_FORMAT(tgl_transaksi, '%Y-%m') AS bulan, SUM(total) AS pendapatan 
                     FROM transaksi 
                     WHERE status = 'dibayar' 
                     GROUP BY bulan 
                     ORDER BY bulan DESC 
                     LIMIT 12";
$result_pendapatan = mysqli_query($conn, $query_pendapatan);
$pendapatan_data = [];
while ($row = mysqli_fetch_assoc($result_pendapatan)) {
    $pendapatan_data[] = $row;
}

// Laporan Pengeluaran (asumsi ada tabel pengeluaran, jika tidak ada, placeholder)
$query_pengeluaran = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(jumlah) AS pengeluaran 
                      FROM pengeluaran 
                      GROUP BY bulan 
                      ORDER BY bulan DESC 
                      LIMIT 12";
$result_pengeluaran = mysqli_query($conn, $query_pengeluaran);
$pengeluaran_data = [];
while ($row = mysqli_fetch_assoc($result_pengeluaran)) {
    $pengeluaran_data[] = $row;
}
?>

<div class="container">
  <h4 class="fw-bold mb-4">💰 Laporan Keuangan</h4>

  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">Daftar Laporan Keuangan</div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <?php foreach ($laporan_keuangan as $laporan): ?>
              <li class="list-group-item">
                <strong><?= htmlspecialchars($laporan['nama']) ?></strong><br>
                <small class="text-muted"><?= htmlspecialchars($laporan['deskripsi']) ?></small>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Laporan Pendapatan</div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Bulan</th>
                <th>Pendapatan (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pendapatan_data as $data): ?>
                <tr>
                  <td><?= htmlspecialchars($data['bulan']) ?></td>
                  <td>Rp <?= number_format($data['pendapatan'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">Laporan Pengeluaran</div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Bulan</th>
                <th>Pengeluaran (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($pengeluaran_data) > 0): ?>
                <?php foreach ($pengeluaran_data as $data): ?>
                  <tr>
                    <td><?= htmlspecialchars($data['bulan']) ?></td>
                    <td>Rp <?= number_format($data['pengeluaran'], 0, ',', '.') ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="2" class="text-center">Belum ada data pengeluaran.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

