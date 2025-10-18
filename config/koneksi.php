<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "e_bisnis_db";

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

