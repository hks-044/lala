<?php
include 'koneksi.php';

// --- LOGIKA PHP (TIDAK DIUBAH SAMA SEKALI) ---
if (isset($_POST['simpan'])) {
    $judul    = $_POST['judul'];
    $tanggal  = $_POST['tanggal'];
    $durasi   = $_POST['durasi'];
    $harga    = $_POST['harga'];
    $lokasi   = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];

    $foto       = $_FILES['gambar']['name'];
    $tmp_foto   = $_FILES['gambar']['tmp_name'];
    
    $nama_baru = date('dmYHis') . '-' . $foto;
    $path      = "assets/" . $nama_baru;

    if ($foto != "") {
        if (move_uploaded_file($tmp_foto, $path)) {
            $query = "INSERT INTO paket_sejarah (judul, tanggal_keberangkatan, durasi, harga, lokasi, deskripsi_sejarah, gambar) 
                      VALUES ('$judul', '$tanggal', '$durasi', '$harga', '$lokasi', '$deskripsi', '$nama_baru')";
            
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo "<script>alert('Data berhasil disimpan!'); window.location='admin_sejarah.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ke database.');</script>";
            }
        } else {
            echo "<script>alert('Gagal upload gambar.');</script>";
        }
    } else {
        echo "<script>alert('Harap pilih gambar terlebih dahulu.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket Sejarah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- CSS UTAMA (UPDATED) --- */
        :root { 
            --sidebar-bg: #0c8c70;         /* Hijau Utama */
            --main-bg: #F5F7FA;            /* Abu muda */
            --accent-gold: #C89F30;        /* Emas */
            --text-muted: #AAB7B8; 
            --text-active: #0c8c70;
            --input-bg: #F3F4F6;           /* Abu untuk input */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: #333; }
        
        /* --- SIDEBAR (SESUAI DASHBOARD) --- */
        .sidebar { 
            width: 280px; 
            background-color: var(--sidebar-bg); 
            display: flex; flex-direction: column; 
            padding-top: 40px; color: white; 
            position: fixed; height: 100vh; left: 0; top: 0; z-index: 10; 
            overflow-y: auto; 
            box-shadow: 4px 0 20px rgba(0,0,0,0.05); 
        }
        
        .profile-section { display: flex; flex-direction: column; align-items: center; margin-bottom: 40px; text-align: center; }
        .avatar { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent-gold); padding: 3px; background: white; }
        .profile-name { font-size: 16px; font-weight: 700; margin-top: 15px; letter-spacing: 1px; text-transform: uppercase; }
        
        /* MENU NAVIGASI */
        .nav-menu { 
            list-style: none; width: 100%; 
            padding-left: 20px; 
            padding-right: 0;   
            padding-bottom: 30px; 
        }
        
        .nav-item { margin-bottom: 12px; }
        
        .nav-link { 
            display: flex; align-items: center; 
            text-decoration: none; 
            color: rgba(255,255,255,0.8); 
            padding: 16px 25px; 
            font-size: 13px; 
            font-weight: 600; 
            transition: all 0.3s ease; 
            /* Bentuk Tab Melengkung */
            border-top-left-radius: 50px; 
            border-bottom-left-radius: 50px;
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        
        .nav-link i { width: 25px; font-size: 18px; margin-right: 12px; }
        
        .nav-link:hover { color: white; background: rgba(255,255,255,0.1); transform: translateX(5px); }

        /* MAIN CONTENT (Sesuaikan margin dengan sidebar baru 280px) */
        .main-content { margin-left: 280px; flex: 1; padding: 40px; }
        
        /* HEADER PAGE */
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 24px; font-weight: 700; color: var(--sidebar-bg); }
        .breadcrumb { font-size: 14px; color: #888; }

        /* --- CARD FORM STYLE --- */
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            display: flex;
            gap: 40px;
        }

        /* KOLOM KIRI (FOTO) */
        .photo-column {
            flex: 0 0 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 1px solid #eee;
            padding-right: 30px;
        }

        .image-upload-wrapper {
            width: 180px;
            height: 180px;
            background-color: var(--input-bg);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            border: 2px dashed #ccc;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-upload-wrapper:hover { border-color: var(--accent-gold); }
        
        #preview-img { width: 100%; height: 100%; object-fit: cover; display: none; }
        
        .upload-placeholder { text-align: center; color: #888; padding: 10px; }
        .upload-placeholder i { font-size: 30px; margin-bottom: 10px; color: var(--accent-gold); }
        .upload-label { font-size: 13px; font-weight: 500; margin-top: 15px; color: var(--sidebar-bg); }

        /* KOLOM KANAN (INPUT DATA) */
        .input-column { flex: 1; }
        .section-title { font-size: 18px; font-weight: 700; color: #333; margin-bottom: 25px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full-width { grid-column: span 2; }

        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #666; margin-bottom: 8px; }

        input[type="text"], input[type="number"], input[type="date"], textarea {
            width: 100%; padding: 12px 15px; background-color: var(--input-bg);
            border: 1px solid transparent; border-radius: 8px; font-size: 14px;
            color: #333; transition: 0.3s; outline: none;
        }

        input:focus, textarea:focus {
            background-color: #fff; border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(200, 159, 48, 0.1);
        }

        textarea { resize: vertical; min-height: 100px; }

        /* BUTTONS */
        .btn-area { margin-top: 30px; display: flex; gap: 15px; justify-content: flex-end; }
        
        .btn-submit {
            background-color: var(--accent-gold); color: white; padding: 12px 30px;
            border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background-color: #b08d2b; box-shadow: 0 5px 15px rgba(200, 159, 48, 0.3); }

        .btn-cancel {
            background-color: white; color: #888; padding: 12px 20px;
            border-radius: 8px; border: 1px solid #ddd; text-decoration: none;
            font-size: 14px; font-weight: 500; transition: 0.3s;
        }
        .btn-cancel:hover { background-color: #f9f9f9; color: #333; }

        @media (max-width: 900px) {
            .form-card { flex-direction: column; }
            .photo-column { border-right: none; border-bottom: 1px solid #eee; padding-bottom: 30px; padding-right: 0; }
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="profile-section">
            <img src="assets/logo.png" alt="Profile" class="avatar">
            <div class="profile-name">Hksyari Trip ADMIN</div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="admin_sejarah.php" class="nav-link"><i class="fas fa-arrow-left"></i> KEMBALI</a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <h1>Tambah Paket Sejarah</h1>
            <div class="breadcrumb">Dashboard > Sejarah > Baru</div>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-card">
                
                <div class="photo-column">
                    <div style="font-weight:700; margin-bottom:15px; color:#333;">Thumbnail Paket</div>
                    
                    <label for="file-upload" class="image-upload-wrapper">
                        <img id="preview-img" alt="Preview">
                        <div class="upload-placeholder" id="placeholder-text">
                            <i class="fas fa-camera"></i><br>
                            Klik untuk<br>Upload Foto
                        </div>
                    </label>
                    <input type="file" name="gambar" id="file-upload" accept="image/*" style="display: none;" onchange="previewImage(event)" required>
                    
                    <div class="upload-label">Format: JPG/PNG, Max 2MB</div>
                </div>

                <div class="input-column">
                    <div class="section-title">Detail Informasi Paket</div>
                    
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Judul Paket</label>
                            <input type="text" name="judul" placeholder="Contoh: Mesir - Jejak Para Nabi" required>
                        </div>

                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" placeholder="Kairo, Giza" required>
                        </div>

                        <div class="form-group">
                            <label>Durasi</label>
                            <input type="text" name="durasi" placeholder="6 Days" required>
                        </div>

                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input type="number" name="harga" placeholder="27500000" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Keberangkatan</label>
                            <input type="date" name="tanggal" required>
                        </div>

                        <div class="form-group full-width">
                            <label>Deskripsi & Itinerary</label>
                            <textarea name="deskripsi" placeholder="Tuliskan poin-poin sejarah atau itinerary singkat..." required></textarea>
                            <p style="font-size:12px; color:#999; margin-top:5px;">Gunakan Enter untuk baris baru.</p>
                        </div>
                    </div>

                    <div class="btn-area">
                        <a href="admin_sejarah.php" class="btn-cancel">Batal</a>
                        <button type="submit" name="simpan" class="btn-submit">
                            <i class="fas fa-save" style="margin-right:5px;"></i> Simpan Data
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </main>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-img');
                var placeholder = document.getElementById('placeholder-text');
                output.src = reader.result;
                output.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>
</html>