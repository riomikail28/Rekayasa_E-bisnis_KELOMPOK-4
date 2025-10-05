<?php
// Aktifkan session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';

// Cek apakah user adalah admin
function isAdmin() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
}

// Cek apakah user adalah pelanggan (user biasa)
function isUser() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'pelanggan';
}

// Fungsi registrasi pengguna baru
function registerUser($data) {
    global $conn;

    $username = trim($data['username'] ?? '');
    $password = trim($data['password'] ?? '');
    $nama     = trim($data['nama_lengkap'] ?? '');
    $email    = trim($data['email'] ?? '');
    $no_hp    = trim($data['no_hp'] ?? '');
    $jenis    = $data['jenis_kelamin'] ?? '';
    $tanggal  = $data['tanggal_lahir'] ?? '';
    $foto     = ''; // default kosong
    $role     = 'user'; // default role

    // Validasi minimal
    if (!$username || !$password || !$nama || !$email) {
        return false;
    }

    // Cek apakah username sudah digunakan
    $check = mysqli_prepare($conn, "SELECT id_users FROM users WHERE username = ?");
    if (!$check) {
        error_log("Prepare failed: " . mysqli_error($conn));
        return false;
    }
    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);
    if (mysqli_stmt_num_rows($check) > 0) {
        mysqli_stmt_close($check);
        return false; // Username sudah digunakan
    }
    mysqli_stmt_close($check);

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data ke database
    $query = "INSERT INTO users (username, password, role, nama_lengkap, email, no_hp, jenis_kelamin, tanggal_lahir, foto)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt  = mysqli_prepare($conn, $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "sssssssss", $username, $hashedPassword, $role, $nama, $email, $no_hp, $jenis, $tanggal, $foto);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$success) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
    }

    return $success;
}

// Fungsi login pengguna
function loginUser($username, $password) {
    global $conn;

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt  = mysqli_prepare($conn, $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$user) {
        return false; // Username tidak ditemukan
    }

    if (!password_verify($password, $user['password'])) {
        return false; // Password tidak cocok
    }

    // Set session jika login berhasil
    $_SESSION['user_id']  = $user['id_users'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = strtolower($user['role']);

    return $user['role'];
}
