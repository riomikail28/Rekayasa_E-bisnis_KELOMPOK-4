<?php
require_once __DIR__ . '/../../../config/koneksi.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "<div class='alert alert-danger'>ID customer tidak ditemukan.</div>";
    exit;
}

// Get customer data
$query = "SELECT * FROM users WHERE id_users = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$customer = mysqli_fetch_assoc($result);

if (!$customer) {
    echo "<div class='alert alert-danger'>Customer tidak ditemukan.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = ? WHERE id_users = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $hash, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard_admin.php?page=daftar_customer&msg=success");
    } else {
        echo "<div class='alert alert-danger'>Gagal ganti password.</div>";
    }
}
?>

<div class="container-fluid mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <!-- Password Change Album Box -->
      <div class="album-box album-form">
        <div class="album-content">
          <div class="album-icon">
            <i class="fas fa-lock"></i>
          </div>
          <div class="album-text">
            <h4 class="album-title">🔐 Ganti Password Customer</h4>
            <p class="album-description">Masukkan password baru yang aman untuk customer</p>
          </div>
          <form method="POST" class="mt-4">
            <div class="mb-4">
              <input type="password" name="password" class="form-control album-input"
                     placeholder="Password baru (minimal 8 karakter)"
                     required minlength="8"
                     id="passwordInput">
            </div>
            <div class="d-flex gap-3 justify-content-center">
              <button type="submit" class="btn btn-primary album-btn">
                <i class="fas fa-save me-2"></i>Simpan Password
              </button>
              <a href="dashboard_admin.php?page=daftar_customer" class="btn btn-outline-secondary album-btn">
                <i class="fas fa-arrow-left me-2"></i>Kembali
              </a>
            </div>
          </form>
        </div>
      </div>
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

.album-form {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px dashed #dee2e6;
  aspect-ratio: auto;
  min-height: 400px;
  padding: 30px;
}

.album-input {
  border: 2px solid #dee2e6;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.album-input:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.album-btn {
  border-radius: 10px;
  padding: 8px 16px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.album-btn:hover {
  transform: translateY(-2px);
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

  .album-form {
    min-height: 300px;
    padding: 20px;
  }
}
</style>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
  const passwordInput = document.querySelector('input[name="password"]');
  const eyeIcon = document.getElementById('eyeIcon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIcon.classList.remove('fa-eye');
    eyeIcon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password';
    eyeIcon.classList.remove('fa-eye-slash');
    eyeIcon.classList.add('fa-eye');
  }
});
</script>

