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

<div class="container mt-4">
  <h3 class="fw-bold text-info">🔍 Detail Customer</h3>
  <?php if ($data): ?>
    <ul class="list-group">
      <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($data['username']) ?></li>
      <li class="list-group-item"><strong>Nama Lengkap:</strong> <?= htmlspecialchars($data['nama_lengkap']) ?></li>
      <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></li>
      <li class="list-group-item"><strong>No HP:</strong> <?= htmlspecialchars($data['no_hp']) ?></li>
      <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($data['status'] ?? 'Aktif') ?></li>
    </ul>
  <?php else: ?>
    <div class="alert alert-warning">Data customer tidak ditemukan.</div>
  <?php endif; ?>
</div>
