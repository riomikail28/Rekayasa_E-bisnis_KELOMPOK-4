<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
require_once 'models/chatModel.php';
require_once 'config/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['kirim'])) {
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'] ?? 'admin';
    $pesan = $_POST['pesan'];

    if (sendMessage($pengirim, $penerima, $pesan)) {
        if ($_SESSION['role'] === 'admin') {
            header('Location: /Rekayasa_E-bisnis_KELOMPOK-4/views/admin/dashboard_admin.php?page=chat');
        } else {
            header('Location: /Rekayasa_E-bisnis_KELOMPOK-4/views/chat.php');
        }
        exit();
    } else {
        echo "Error sending message.";
    }
}
?>
