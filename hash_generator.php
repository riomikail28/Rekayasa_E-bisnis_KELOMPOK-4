<?php
$password = "admin123"; // ganti dengan password yang kamu mau
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password asli: " . $password . "<br>";
echo "Hash-nya: " . $hash;
?>
