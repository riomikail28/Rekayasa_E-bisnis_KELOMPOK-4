<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';

// 🔐 Cek apakah user adalah admin
function isAdmin() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
}

// 🔐 Cek apakah user adalah pelanggan
function isUser() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'pelanggan';
}

// 📝 Registrasi pengguna baru
function registerUser($data) {
    global $conn;

    $username = trim($data['username'] ?? '');
    $password = trim($data['password'] ?? '');
    $nama     = trim($data['nama_lengkap'] ?? '');
    $email    = trim($data['email'] ?? '');
    $no_hp    = trim($data['no_hp'] ?? '');
    $jenis    = $data['jenis_kelamin'] ?? '';
    $tanggal  = $data['tanggal_lahir'] ?? '';
    $foto     = '';
    $role     = 'pelanggan';

    if (!$username || !$password || !$nama || !$email) {
        return false;
    }

    // Cek apakah username sudah digunakan
    $check = mysqli_prepare($conn, "SELECT id_users FROM users WHERE username = ?");
    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);
    if (mysqli_stmt_num_rows($check) > 0) {
        mysqli_stmt_close($check);
        return false;
    }
    mysqli_stmt_close($check);

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $query = "INSERT INTO users (username, password, role, nama_lengkap, email, no_hp, jenis_kelamin, tanggal_lahir, foto)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssssss", $username, $hashedPassword, $role, $nama, $email, $no_hp, $jenis, $tanggal, $foto);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $success;
}

// 🔑 Login pengguna
function loginUser($username, $password) {
    global $conn;

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Validasi password
    if (!$user || !password_verify($password, $user['password'])) {
        return false;
    }

    // Simpan session
    $_SESSION['id_users'] = $user['id_users'];     // ✅ konsisten dengan profil.php, keranjang.php
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = strtolower($user['role']);

    return $user['role'];
}

