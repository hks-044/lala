<?php
session_start();

// 1. Hapus Session
$_SESSION = [];
session_unset();
session_destroy();

// 2. Hapus Cookie (Atur waktunya jadi masa lalu biar hangus)
setcookie('id_admin', '', time() - 3600);
setcookie('kunci_rahasia', '', time() - 3600);

// 3. Kembalikan ke halaman login
header("Location: admin_login.php");
exit;
?>