<?php
include 'koneksi.php';

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. AMBIL NAMA GAMBAR DULU (Supaya bisa dihapus dari folder)
    $query_gambar = "SELECT gambar FROM paket_haji WHERE id = '$id'";
    $result_gambar = mysqli_query($koneksi, $query_gambar);
    $data = mysqli_fetch_assoc($result_gambar);
    
    // Hapus file gambar dari folder assets jika ada
    $path_gambar = "assets/" . $data['gambar'];
    if (file_exists($path_gambar)) {
        unlink($path_gambar); // Perintah hapus file
    }

    // 2. HAPUS DATA DARI DATABASE
    $query_delete = "DELETE FROM paket_haji WHERE id = '$id'";
    $hapus = mysqli_query($koneksi, $query_delete);

    if ($hapus) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location = 'admin_haji.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.location = 'admin_haji.php';
              </script>";
    }
} else {
    // Jika orang coba akses file ini tanpa ID
    header("Location: admin_haji.php");
}
?>