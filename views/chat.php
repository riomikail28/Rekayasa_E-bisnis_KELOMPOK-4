<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
require_once 'models/chatModel.php';
$pengirim = $_SESSION['username'];
if ($_SESSION['role'] === 'admin') {
    $chat = getAllChatsForAdmin();
    $customers = getAllCustomers();
    $title = 'Live Chat Support';
} else {
    $penerima = 'admin';
    $chat = getChat($pengirim, $penerima);
    $title = 'Live Chat dengan Admin';
}
?>

<h2><?= $title ?></h2>
<div style="height:300px; overflow-y:scroll; border:1px solid #ccc; padding:10px;">
  <?php foreach ($chat as $c): ?>
    <p><strong><?= $c['pengirim'] ?>:</strong> <?= $c['pesan'] ?> <small><?= $c['waktu'] ?></small></p>
  <?php endforeach; ?>
</div>

<form method="POST" action="/Rekayasa_E-bisnis_KELOMPOK-4/controllers/chatController.php" class="mt-3">
  <input type="hidden" name="pengirim" value="<?= $pengirim ?>">
  <?php if ($_SESSION['role'] === 'admin'): ?>
    <select name="penerima" class="form-control mb-2" required>
      <option value="">Pilih Pelanggan</option>
      <?php foreach ($customers as $customer): ?>
        <option value="<?= $customer['username'] ?>"><?= $customer['username'] ?></option>
      <?php endforeach; ?>
    </select>
  <?php else: ?>
    <input type="hidden" name="penerima" value="<?= $penerima ?>">
  <?php endif; ?>
  <textarea name="pesan" class="form-control" rows="2" required></textarea><br>
  <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
</form>
