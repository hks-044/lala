<?php
// 1. KONEKSI KE DATABASE
include 'koneksi.php';

// 2. LOGIKA PENCARIAN (SEARCH)
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = $_GET['cari'];
    // REVISI: Mengarah ke tabel paket_internasional
    $query = "SELECT * FROM paket_internasional WHERE judul LIKE '%$keyword%' ORDER BY id DESC";
} else {
    // REVISI: Mengarah ke tabel paket_internasional
    $query = "SELECT * FROM paket_internasional ORDER BY id DESC";
}

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Paket Internasional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- COPY DARI DASHBOARD.PHP AGAR SEIRAMA --- */
        :root { 
            --primary-green: #0c8c70;      /* Hijau Utama */
            --dark-green: #086652;         /* Hijau Gelap */
            --light-green-bg: #e0f2ef;     /* Hijau Muda Pucat */
            --main-bg: #E6F4F1;            /* Background Abu Muda */
            --accent-gold: #C89F30;        /* Emas */
            --text-dark: #333333;
            --text-muted: #8898aa; 
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: var(--text-dark); }
        
        /* --- SIDEBAR STYLE DASHBOARD --- */
        .sidebar { 
            width: 280px; 
            background-color: var(--primary-green); 
            display: flex; flex-direction: column; 
            padding-top: 40px; color: white; 
            position: fixed; height: 100vh; left: 0; top: 0; z-index: 10; 
            overflow-y: auto; 
        }
        
        .profile-section { display: flex; flex-direction: column; align-items: center; margin-bottom: 40px; text-align: center; }
            .logo-lingkaran {
            /* 1. Latar belakang putih */
            background-color: white;

            /* 2. Membuat bentuk lingkaran */
            border-radius: 50%; 
            border: 5px solid #DAA520;

            /* 3. Ukuran harus persegi (Width = Height) agar bulat sempurna */
            width: 100px;
            height: 100px;

            /* 4. (Opsional) Memusatkan gambar logo di tengah lingkaran */
            display: flex;
            justify-content: center;
            align-items: center;
            
            /* 5. (Opsional) Memberikan sedikit bayangan agar terlihat timbul */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }

        /* Mengatur ukuran gambar di dalam lingkaran agar pas */
        .logo-lingkaran img {
            width: 100%; /* Sesuaikan persentase ini sesuai kebutuhan */
            height: auto;
        }
        .profile-name { font-size: 16px; font-weight: 700; margin-top: 15px; letter-spacing: 1px; text-transform: uppercase; }
        
        /* --- MENU NAVIGASI --- */
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
            border-top-left-radius: 50px; 
            border-bottom-left-radius: 50px;
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        
        .nav-link i { width: 25px; font-size: 18px; margin-right: 12px; }
        
        .nav-link:hover { color: white; background: rgba(255,255,255,0.1); transform: translateX(5px); }
        
        /* --- ACTIVE STATE --- */
        .nav-item.active .nav-link { 
            background-color: #E6F4F1; 
            color: var(--primary-green); 
            font-weight: 800; 
        }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 280px; flex: 1; padding: 30px 40px; }
        
        /* --- TOP BAR (BARU DITAMBAHKAN) --- */
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 15px 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.02); }
        .page-title { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .user-area { display: flex; align-items: center; gap: 25px; }

        /* SEARCH BOX */
        .search-box { display: flex; align-items: center; background-color: var(--main-bg); padding: 10px 20px; border-radius: 50px; width: 280px; border: 1px solid transparent; transition: 0.3s; }
        .search-box:focus-within { background-color: #fff; border-color: var(--primary-green); box-shadow: 0 0 0 4px rgba(12, 140, 112, 0.1); }
        .search-box input { border: none; background: transparent; outline: none; width: 100%; font-size: 13px; color: var(--text-dark); margin-left: 10px; }
        .search-box button { background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 0; }
        .search-box button:hover { color: var(--primary-green); }
        .user-profile-small { display: flex; align-items: center; gap: 10px; border-left: 1px solid #eee; padding-left: 25px; }
        .user-profile-small img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-gold); }
        .user-info-small h4 { font-size: 14px; margin: 0; font-weight: 600; }
        .user-info-small p { font-size: 11px; margin: 0; color: var(--text-muted); }

        /* HEADER KONTEN (JUDUL & TOMBOL ADD) */
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { font-size: 20px; font-weight: 700; color: var(--text-dark); margin: 0; }
        
        /* TOMBOL TAMBAH */
        .btn-add { 
            background-color: var(--accent-gold); color: white; padding: 12px 25px; 
            border-radius: 10px; text-decoration: none; font-weight: 600; 
            box-shadow: 0 4px 10px rgba(200, 159, 48, 0.3); transition: 0.3s; 
        }
        .btn-add:hover { background-color: #b08d2b; transform: translateY(-3px); }

        /* --- GRID KARTU ADMIN --- */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .admin-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
            position: relative;
        }
        .admin-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

        .card-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        /* TOMBOL AKSI MENGAMBANG */
        .action-overlay {
            position: absolute;
            top: 15px; right: 15px;
            display: flex; gap: 10px;
        }
        .btn-action {
            width: 35px; height: 35px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: white; font-size: 14px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2); transition: 0.2s;
        }
        .btn-edit { background-color: #f39c12; } 
        .btn-delete { background-color: #e74c3c; } 
        .btn-action:hover { transform: scale(1.1); }

        .card-body { padding: 20px; }
        .card-title { font-size: 16px; font-weight: 700; margin-bottom: 10px; color: #333; line-height: 1.4; height: 3em; overflow: hidden; }
        .card-meta { font-size: 13px; color: #777; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; }
        .card-price { font-size: 18px; font-weight: 700; color: var(--accent-gold); margin-top: 15px; display: block; }

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="profile-section">
            <div class="logo-lingkaran">
                <img src="assets\logotrip.png" alt="Logo">
            </div>
            <div class="profile-name">Hksyari Trip</div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="admin_dashboard.php" class="nav-link"><i class="fas fa-home"></i> DASHBOARD</a></li>
            
            <li class="nav-item"><a href="admin_sejarah.php" class="nav-link"><i class="fas fa-landmark"></i> TOUR SEJARAH</a></li>
            <li class="nav-item "><a href="admin_haji.php" class="nav-link"><i class="fas fa-kaaba"></i> HAJI KHUSUS</a></li>
            <li class="nav-item active"><a href="admin_internasional.php" class="nav-link"><i class="fas fa-globe-asia"></i> INTERNASIONAL</a></li>
            <li class="nav-item"><a href="admin_domestik.php" class="nav-link"><i class="fas fa-map-location-dot"></i> DOMESTIK</a></li>
            <li class="nav-item"><a href="admin_umrah.php" class="nav-link"><i class="fas fa-mosque"></i>UMRAH</a></li>
            <li class="nav-item" style="margin-top: 20px;"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
        </ul>
    </aside>

    <main class="main-content">
        
        <div class="top-bar">
            <h2 class="page-title">Wisata Halal Internasional</h2>
            
            <div class="user-area">
                <form action="" method="GET">
                    <div class="search-box">
                        <button type="submit"><i class="fas fa-search"></i></button>
                        <input type="text" name="cari" placeholder="Cari Paket..." value="<?= htmlspecialchars($keyword); ?>">
                    </div>
                </form>

                <div class="user-profile-small">
                    <div class="user-info-small" style="text-align: right;">
                        <h4>Null Admin</h4>
                        <p>Super Admin</p>
                    </div>
                    <img src="assets/foto.jpeg" alt="User">
                </div>
            </div>
        </div>

        <div class="content-header">
            <h1>Daftar Paket</h1>
            <a href="admin_internasionaltambah.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Paket</a>
        </div>

        <div class="card-grid">
            
            <?php 
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) : 
            ?>
            
            <div class="admin-card">
                <img src="assets/<?= $row['gambar']; ?>" alt="Foto" class="card-img">
                
                <div class="action-overlay">
                    <a href="admin_internasionaledit.php?id=<?= $row['id']; ?>" class="btn-action btn-edit" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="admin_internasionalhapus.php?id=<?= $row['id']; ?>" class="btn-action btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus paket ini?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>

                <div class="card-body">
                    <h3 class="card-title"><?= $row['judul']; ?></h3>
                    
                    <div class="card-meta">
                        <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($row['tanggal_keberangkatan'])); ?>
                    </div>
                    <div class="card-meta">
                        <i class="far fa-clock"></i> <?= $row['durasi']; ?>
                    </div>
                    
                    <span class="card-price">
                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                    </span>
                </div>
            </div>
            
            <?php 
                endwhile; 
            } else {
            ?>
                <div style="grid-column: 1 / -1; text-align: center; color: #999; margin-top: 50px;">
                    <div style="background:#e0f2ef; width:80px; height:80px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px auto;">
                        <i class="fas fa-search" style="font-size:30px; color:#0c8c70;"></i>
                    </div>
                    <h3>Data Paket Tidak Ditemukan</h3>
                    <p>Coba kata kunci lain atau tambahkan paket baru.</p>
                </div>
            <?php } ?>

        </div>

    </main>

</body>
</html>