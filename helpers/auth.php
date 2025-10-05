

<?php
require_once __DIR__ . '/../config/koneksi.php';


function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isPelanggan() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'pelanggan';
}

function registerUser($data) {
    global $conn;
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $nama     = $data['nama_lengkap'];
    $email    = $data['email'];
    $role     = 'pelanggan';

    $query = "INSERT INTO users (username, password, role, nama_lengkap, email) VALUES (?, ?, ?, ?, ?)";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $role, $nama, $email);
    return mysqli_stmt_execute($stmt);
}

function loginUser($username, $password) {
    global $conn;
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        return $user['role'];
    }

    return false;
}
