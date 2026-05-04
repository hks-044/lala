<?php
include 'koneksi.php';

// Password yang kamu mau
$username = 'admin';
$password_baru = '123456'; 

// Biarkan laptop kamu yang mengacak kodenya
$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

// Masukkan ke database
$query = "UPDATE admins SET password = '$password_hash' WHERE username = '$username'";

if (mysqli_query($koneksi, $query)) {
    echo "<h1>SUKSES! ✅</h1>";
    echo "Password untuk user '<b>admin</b>' berhasil diatur menjadi: <b>123456</b><br>";
    echo "Sekarang silakan <a href='admin_login.php'>LOGIN DISINI</a>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>