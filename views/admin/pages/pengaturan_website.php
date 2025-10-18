<?php
require_once __DIR__ . '/../../../models/pengaturanModel.php';
$settings = getAllSettings();
?>

<div class="container">
  <h4 class="fw-bold mb-4">⚙️ Pengaturan Website</h4>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Pengaturan berhasil disimpan!
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Terjadi kesalahan saat menyimpan pengaturan.
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <ul class="nav nav-tabs" id="settingsTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="umum-tab" data-bs-toggle="tab" data-bs-target="#umum" type="button" role="tab" aria-controls="umum" aria-selected="true">Pengaturan Umum</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="logo-tab" data-bs-toggle="tab" data-bs-target="#logo" type="button" role="tab" aria-controls="logo" aria-selected="false">Logo</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="favicon-tab" data-bs-toggle="tab" data-bs-target="#favicon" type="button" role="tab" aria-controls="favicon" aria-selected="false">Favicon</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="kontak-tab" data-bs-toggle="tab" data-bs-target="#kontak" type="button" role="tab" aria-controls="kontak" aria-selected="false">Informasi Kontak</button>
    </li>
  </ul>

  <div class="tab-content" id="settingsTabContent">
    <div class="tab-pane fade show active" id="umum" role="tabpanel" aria-labelledby="umum-tab">
      <div class="mt-4">
        <h5>Pengaturan Umum</h5>
        <form method="POST" action="../../controllers/pengaturanController.php">
          <div class="mb-3">
            <label for="site_title" class="form-label">Judul Situs</label>
            <input type="text" class="form-control" id="site_title" name="nilai" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>">
            <input type="hidden" name="nama_setting" value="site_title">
          </div>
          <div class="mb-3">
            <label for="site_description" class="form-label">Deskripsi Situs</label>
            <textarea class="form-control" id="site_description" name="nilai" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            <input type="hidden" name="nama_setting" value="site_description">
          </div>
          <button type="submit" name="update_setting" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>

    <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
      <div class="mt-4">
        <h5>Logo Website</h5>
        <form method="POST" action="../../controllers/pengaturanController.php" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo Baru</label>
            <input type="file" class="form-control" id="logo" name="logo">
            <input type="hidden" name="nama_setting" value="logo">
          </div>
          <button type="submit" name="update_setting" class="btn btn-primary">Upload</button>
        </form>
        <?php if (!empty($settings['logo'])): ?>
          <div class="mt-3">
            <p>Logo Saat Ini:</p>
            <img src="../../../uploads/<?= htmlspecialchars($settings['logo']) ?>" alt="Logo" width="100">
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="tab-pane fade" id="favicon" role="tabpanel" aria-labelledby="favicon-tab">
      <div class="mt-4">
        <h5>Favicon Website</h5>
        <form method="POST" action="../../controllers/pengaturanController.php" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="favicon" class="form-label">Upload Favicon Baru</label>
            <input type="file" class="form-control" id="favicon" name="favicon">
            <input type="hidden" name="nama_setting" value="favicon">
          </div>
          <button type="submit" name="update_setting" class="btn btn-primary">Upload</button>
        </form>
        <?php if (!empty($settings['favicon'])): ?>
          <div class="mt-3">
            <p>Favicon Saat Ini:</p>
            <img src="../../../uploads/<?= htmlspecialchars($settings['favicon']) ?>" alt="Favicon" width="32" height="32">
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="tab-pane fade" id="kontak" role="tabpanel" aria-labelledby="kontak-tab">
      <div class="mt-4">
        <h5>Informasi Kontak</h5>
        <form method="POST" action="../../controllers/pengaturanController.php">
          <div class="mb-3">
            <label for="contact_email" class="form-label">Email Kontak</label>
            <input type="email" class="form-control" id="contact_email" name="nilai" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
            <input type="hidden" name="nama_setting" value="contact_email">
          </div>
          <div class="mb-3">
            <label for="contact_phone" class="form-label">Telepon Kontak</label>
            <input type="text" class="form-control" id="contact_phone" name="nilai" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
            <input type="hidden" name="nama_setting" value="contact_phone">
          </div>
          <div class="mb-3">
            <label for="contact_address" class="form-label">Alamat</label>
            <textarea class="form-control" id="contact_address" name="nilai" rows="3"><?= htmlspecialchars($settings['contact_address'] ?? '') ?></textarea>
            <input type="hidden" name="nama_setting" value="contact_address">
          </div>
          <button type="submit" name="update_setting" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

