<?php 
require_once __DIR__ . '/../../../config/koneksi.php'; 

// Cek koneksi
if (!$conn) {
    die("<div class='alert alert-danger'>Koneksi database gagal: " . mysqli_connect_error() . "</div>");
}

// Pesan dari redirect
$message = $_GET['msg'] ?? '';
if ($message) {
    $alertClass = match($message) {
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        default => 'alert-info'
    };
    echo "<div class='alert {$alertClass} alert-dismissible fade show' role='alert'>{$message}<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
}

// Ambil data pelanggan
$query = "SELECT * FROM users WHERE role = 'pelanggan'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<div class='alert alert-danger'>Error query: " . mysqli_error($conn) . "</div>";
} else {
?>
<div class="container mt-4">
    <h3 class="text-pink fw-bold">👥 Daftar Pelanggan</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    $id = htmlspecialchars($row['id_users'] ?? '', ENT_QUOTES, 'UTF-8');
                    $username = htmlspecialchars($row['username'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
                    $status = $row['status'] ?? 'Aktif';
            ?>
                <tr>
                    <td><?= $username ?></td>
                    <td><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php if (!empty($id)): ?>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="dashboard_admin.php?page=detail_customer&id=<?= $id ?>" class="btn btn-info">Detail</a>
                                <a href="dashboard_admin.php?page=edit_customer&id=<?= $id ?>" class="btn btn-primary">Edit</a>
                                <?php if ($status === 'Aktif'): ?>
                                    <a href="dashboard_admin.php?page=blokir_customer&id=<?= $id ?>" class="btn btn-warning" onclick="return confirm('Yakin ingin blokir customer ini?')">Blokir</a>
                                <?php elseif ($status === 'Blokir'): ?>
                                    <a href="dashboard_admin.php?page=buka_blokir_customer&id=<?= $id ?>" class="btn btn-success" onclick="return confirm('Yakin ingin buka blokir customer ini?')">Buka Blokir</a>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= $status ?></span>
                                <?php endif; ?>
                                <a href="dashboard_admin.php?page=ganti_password_customer&id=<?= $id ?>" class="btn btn-secondary">Ganti Password</a>
                                <a href="dashboard_admin.php?page=hapus_customer&id=<?= $id ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus customer ini?')">Hapus</a>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">ID Tidak Tersedia</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php 
                }
                mysqli_free_result($result);
            } else {
            ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada pelanggan ditemukan.</td>
                </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>
<?php 
} // Akhir if (!$result)
?>
