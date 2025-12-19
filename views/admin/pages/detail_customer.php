<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? '';
$query = "SELECT * FROM users WHERE id_users = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
?>

<div class="container-fluid mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-xl-6">
      <?php if ($data): ?>
        <!-- Single Large Customer Detail Album Box -->
        <div class="album-box album-detail">
          <div class="album-content">
            <!-- Header Section -->
            <div class="album-header-section">
              <div class="album-icon">
                <i class="fas fa-user-circle"></i>
              </div>
              <div class="album-text">
                <h3 class="album-title">🔍 Detail Customer</h3>
                <p class="album-description">Informasi lengkap dan detail customer</p>
              </div>
            </div>

            <!-- Customer Information Grid -->
            <div class="customer-info-grid">
              <!-- Username -->
              <div class="info-item">
                <div class="info-icon">
                  <i class="fas fa-user-circle text-primary"></i>
                </div>
                <div class="info-content">
                  <small class="info-label">Username</small>
                  <div class="info-value"><?= htmlspecialchars($data['username']) ?></div>
                </div>
              </div>

              <!-- Full Name -->
              <div class="info-item">
                <div class="info-icon">
                  <i class="fas fa-user text-success"></i>
                </div>
                <div class="info-content">
                  <small class="info-label">Nama Lengkap</small>
                  <div class="info-value"><?= htmlspecialchars($data['nama_lengkap']) ?></div>
                </div>
              </div>

              <!-- Email -->
              <div class="info-item">
                <div class="info-icon">
                  <i class="fas fa-envelope text-warning"></i>
                </div>
                <div class="info-content">
                  <small class="info-label">Email</small>
                  <div class="info-value"><?= htmlspecialchars($data['email']) ?></div>
                </div>
              </div>

              <!-- Phone -->
              <div class="info-item">
                <div class="info-icon">
                  <i class="fas fa-phone text-info"></i>
                </div>
                <div class="info-content">
                  <small class="info-label">No. Telepon</small>
                  <div class="info-value"><?= htmlspecialchars($data['no_hp'] ?? 'Tidak ada') ?></div>
                </div>
              </div>

              <!-- Address -->
              <div class="info-item full-width">
                <div class="info-icon">
                  <i class="fas fa-map-marker-alt text-secondary"></i>
                </div>
                <div class="info-content">
                  <small class="info-label">Alamat</small>
                  <div class="info-value address-value"><?= htmlspecialchars($data['alamat'] ?? 'Tidak ada') ?></div>
                </div>
              </div>

              <!-- Status -->
              <div class="info-item">
                <div class="info-icon">
                  <i class="fas fa-shield-alt <?php echo ($data['status'] ?? 'Aktif') === 'Aktif' ? 'text-success' : 'text-danger'; ?>"></i>
                </div>
                <div class="info-content">
                  <small class="info-label">Status</small>
                  <span class="status-badge <?php echo ($data['status'] ?? 'Aktif') === 'Aktif' ? 'status-active' : 'status-inactive'; ?>">
                    <?php echo htmlspecialchars($data['status'] ?? 'Aktif'); ?>
                  </span>
                </div>
              </div>
            </div>

            <!-- Back Button -->
            <div class="mt-4 text-center">
              <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-outline-secondary album-btn">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Customer
              </a>
            </div>
          </div>
        </div>
      <?php else: ?>
        <!-- Not Found Album Box -->
        <div class="album-box album-danger">
          <div class="album-content text-center">
            <div class="album-icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="album-text">
              <h4 class="album-title">Data Tidak Ditemukan</h4>
              <p class="album-description">Customer yang dicari tidak ada dalam database</p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<style>
/* Album Box Styles */
.album-box {
  position: relative;
  background: white;
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: all 0.3s ease;
  aspect-ratio: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;
  border: 3px solid transparent;
}

.album-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.album-content {
  text-align: center;
  width: 100%;
}

.album-icon {
  font-size: 2.5rem;
  margin-bottom: 15px;
  display: block;
}

.album-text small {
  display: block;
  font-size: 0.75rem;
  color: #6c757d;
  margin-bottom: 5px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 600;
}

.album-value {
  font-size: 1rem;
  font-weight: 700;
  color: #212529;
  word-break: break-word;
}

.album-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 8px;
}

.album-description {
  font-size: 0.875rem;
  color: #6c757d;
  margin-bottom: 0;
}

/* Album Box Color Variants */
.album-primary {
  background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
  color: white;
}

.album-primary .album-value,
.album-primary .album-title {
  color: white;
}

.album-success {
  background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
  color: white;
}

.album-success .album-value,
.album-success .album-title {
  color: white;
}

.album-warning {
  background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
  color: #212529;
}

.album-info {
  background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
  color: white;
}

.album-info .album-value,
.album-info .album-title {
  color: white;
}

.album-secondary {
  background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
  color: white;
}

.album-secondary .album-value,
.album-secondary .album-title {
  color: white;
}

.album-danger {
  background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
  color: white;
}

.album-danger .album-value,
.album-danger .album-title {
  color: white;
}

.album-header {
  background: linear-gradient(135deg, #f06292 0%, #e91e63 100%);
  color: white;
  aspect-ratio: auto;
  padding: 30px;
  min-height: 120px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .album-box {
    aspect-ratio: auto;
    min-height: 120px;
    padding: 15px;
  }

  .album-icon {
    font-size: 2rem;
    margin-bottom: 10px;
  }
}
</style>

