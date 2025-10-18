<?php
require_once __DIR__ . '/../../../models/pengirimanModel.php';
$pengiriman = getAllPengiriman();
$biaya_pengiriman = getBiayaPengiriman();
?>

<div class="container">
  <h4 class="fw-bold mb-4">🚚 Manajemen Pengiriman</h4>

  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPengirimanModal">➕ Tambah Pengiriman</button>

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Daftar Pengiriman</div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nama Pengiriman</th>
                <th>Biaya (Rp)</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pengiriman as $p): ?>
                <tr>
                  <td><?= htmlspecialchars($p['nama_pengiriman']) ?></td>
                  <td>Rp <?= number_format($p['biaya'], 0, ',', '.') ?></td>
                  <td><?= htmlspecialchars($p['deskripsi']) ?></td>
                  <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPengirimanModal" onclick="editPengiriman(<?= $p['id'] ?>, '<?= htmlspecialchars($p['nama_pengiriman']) ?>', <?= $p['biaya'] ?>, '<?= htmlspecialchars($p['deskripsi']) ?>')">✏️ Edit</button>
                    <a href="../../controllers/pengirimanController.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">Biaya Pengiriman</div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <?php foreach ($biaya_pengiriman as $b): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($b['nama_pengiriman']) ?>
                <span class="badge bg-primary rounded-pill">Rp <?= number_format($b['biaya'], 0, ',', '.') ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Pengiriman Modal -->
<div class="modal fade" id="addPengirimanModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../controllers/pengirimanController.php">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pengiriman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_pengiriman" class="form-label">Nama Pengiriman</label>
            <input type="text" class="form-control" id="nama_pengiriman" name="nama_pengiriman" required>
          </div>
          <div class="mb-3">
            <label for="biaya" class="form-label">Biaya (Rp)</label>
            <input type="number" class="form-control" id="biaya" name="biaya" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="add_pengiriman" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Pengiriman Modal -->
<div class="modal fade" id="editPengirimanModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../controllers/pengirimanController.php">
        <div class="modal-header">
          <h5 class="modal-title">Edit Pengiriman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">
          <div class="mb-3">
            <label for="edit_nama_pengiriman" class="form-label">Nama Pengiriman</label>
            <input type="text" class="form-control" id="edit_nama_pengiriman" name="nama_pengiriman" required>
          </div>
          <div class="mb-3">
            <label for="edit_biaya" class="form-label">Biaya (Rp)</label>
            <input type="number" class="form-control" id="edit_biaya" name="biaya" required>
          </div>
          <div class="mb-3">
            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="update_pengiriman" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editPengiriman(id, nama, biaya, deskripsi) {
  document.getElementById('edit_id').value = id;
  document.getElementById('edit_nama_pengiriman').value = nama;
  document.getElementById('edit_biaya').value = biaya;
  document.getElementById('edit_deskripsi').value = deskripsi;
}
</script>

