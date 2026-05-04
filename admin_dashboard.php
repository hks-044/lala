<?php
session_start();

// PENJAGA PINTU
// Kalau tidak punya tiket 'sudah_login', tendang balik ke login
if (!isset($_SESSION['sudah_login'])) {
    header("Location: admin_login.php");
    exit;
}

include 'koneksi.php';

// --- 1. LOGIKA SUBSCRIBER ---
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = $_GET['cari'];
    $query_string = "SELECT * FROM subscribers WHERE email LIKE '%$keyword%' ORDER BY id DESC";
} else {
    $query_string = "SELECT * FROM subscribers ORDER BY id DESC";
}

$subs_terbaru = @mysqli_query($koneksi, $query_string);

// Hitung Total
$q_total = @mysqli_query($koneksi, "SELECT * FROM subscribers");
$jml_subs = ($q_total) ? mysqli_num_rows($q_total) : 0;


// --- 2. LOGIKA KALENDER ---
date_default_timezone_set('Asia/Jakarta');
$real_d = date('d'); $real_m = date('m'); $real_y = date('Y');

if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $bulan_pilih = $_GET['bulan']; $tahun_pilih = $_GET['tahun'];
} else {
    $bulan_pilih = date('m'); $tahun_pilih = date('Y');
}

$prev_bulan = $bulan_pilih - 1; $prev_tahun = $tahun_pilih;
if ($prev_bulan < 1) { $prev_bulan = 12; $prev_tahun--; }

$next_bulan = $bulan_pilih + 1; $next_tahun = $tahun_pilih;
if ($next_bulan > 12) { $next_bulan = 1; $next_tahun++; }

$nama_bulan_tampil = date('F Y', mktime(0, 0, 0, $bulan_pilih, 10, $tahun_pilih));
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_pilih, $tahun_pilih);
$hari_pertama = date('N', strtotime("$tahun_pilih-$bulan_pilih-01"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hksyari Trip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- CSS UTAMA --- */
        :root { 
            --sidebar-bg: #0c8c70;         
            --main-bg: #E6F4F1;            
            --accent-gold: #C89F30;        
            --text-dark: #304746;          
            --text-muted: #AAB7B8; 
            --green-light-bg: #e0f2ef;     
            --green-text: #0c8c70;
            --primary-gradient: linear-gradient(135deg, #0c8c70 0%, #065041 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: #333; }
        
        /* SIDEBAR STYLE */
        .sidebar { width: 280px; background-color: var(--sidebar-bg); display: flex; flex-direction: column; padding-top: 40px; color: white; position: fixed; height: 100vh; left: 0; top: 0; z-index: 10; overflow-y: auto; }
        .profile-section { display: flex; flex-direction: column; align-items: center; margin-bottom: 40px; text-align: center; }
        .logo-lingkaran { background-color: white; border-radius: 50%; border: 5px solid #DAA520; width: 100px; height: 100px; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .logo-lingkaran img { width: 100%; height: auto; }
        .profile-name { font-size: 16px; font-weight: 700; margin-top: 15px; letter-spacing: 1px; text-transform: uppercase; }
        
        .nav-menu { list-style: none; width: 100%; padding-left: 20px; }
        .nav-item { margin-bottom: 12px; }
        .nav-link { display: flex; align-items: center; text-decoration: none; color: rgba(255,255,255,0.8); padding: 16px 25px; font-size: 13px; font-weight: 600; transition: all 0.3s ease; border-top-left-radius: 50px; border-bottom-left-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px; }
        .nav-link i { width: 25px; font-size: 18px; margin-right: 12px; }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .nav-item.active .nav-link { background-color: #E6F4F1; color: var(--sidebar-bg); font-weight: 800; }

        /* MAIN AREA */
        .main-content { margin-left: 280px; flex: 1; padding: 30px 40px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 15px 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.02); }
        .page-title { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .user-area { display: flex; align-items: center; gap: 25px; }

        .search-box { display: flex; align-items: center; background-color: var(--main-bg); padding: 10px 20px; border-radius: 50px; width: 280px; }
        .search-box input { border: none; background: transparent; outline: none; width: 100%; font-size: 13px; color: var(--text-dark); margin-left: 10px; }
        .search-box button { background: none; border: none; cursor: pointer; color: var(--text-muted); }
        
        .user-profile-small { display: flex; align-items: center; gap: 10px; border-left: 1px solid #eee; padding-left: 25px; }
        .user-profile-small img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-gold); }

        .dashboard-grid { display: grid; grid-template-columns: 2.2fr 1fr; gap: 30px; }
        .welcome-banner { background: var(--primary-gradient); border-radius: 25px; padding: 40px; color: white; margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(12, 140, 112, 0.25); }
        .banner-text h1 { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
        .arabic-text { font-family: 'Amiri', serif; font-size: 32px; color: var(--accent-gold); margin-bottom: 10px; display: block; }
        .banner-text p { opacity: 0.9; font-size: 14px; max-width: 80%; line-height: 1.6; }
        .banner-illustration i { font-size: 200px; opacity: 0.15; position: absolute; right: -30px; bottom: -50px; transform: rotate(-15deg); color: white; }

        /* --- STYLE TABEL (VERSI BERSIH & HIJAU) --- */
        .sub-list-container { 
            background: white; border-radius: 25px; padding: 25px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.03); 
            max-height: 550px; overflow-y: auto;
        }
        
        /* Style Tabel Utama */
        .custom-table {
            width: 100%;
            border-collapse: separate; 
            border-spacing: 0;
            /* Border abu-abu halus (BUKAN MERAH) */
            border: 1px solid #e0e0e0; 
            border-radius: 12px; 
            overflow: hidden;
            margin-top: 15px;
        }

        .custom-table thead th {
            /* Latar Hijau Sangat Muda (Serasi dengan tema) */
            background-color: #f0fdfa; 
            /* Teks Hijau Tua */
            color: var(--sidebar-bg); 
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 18px 20px;
            text-align: left;
            /* Garis bawah hijau tipis */
            border-bottom: 2px solid var(--sidebar-bg);
        }

        .custom-table tbody td {
            padding: 18px 20px;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
            color: #444;
            font-size: 14px;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }

        .custom-table tbody tr:hover {
            background-color: #fafafa;
        }

        /* Styling Kolom Profil (Ikon + Teks) */
        .user-flex {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-icon-circle {
            width: 40px; height: 40px; 
            background-color: var(--green-light-bg); 
            color: var(--green-text);
            border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 16px;
            flex-shrink: 0;
        }

        .user-text h4 { margin: 0; font-size: 14px; font-weight: 600; color: var(--text-dark); }
        .user-text span { font-size: 12px; color: #888; }

        .status-pill {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background-color: var(--green-light-bg);
            color: var(--green-text);
        }

        /* --- END STYLE TABEL --- */

        .right-col { display: flex; flex-direction: column; gap: 30px; }
        .quick-stats-card { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); text-align: center; border-bottom: 4px solid var(--accent-gold); }
        .quick-stat-icon { width: 70px; height: 70px; background-color: var(--green-light-bg); color: var(--green-text); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 15px auto; }
        .quick-stat-number { font-size: 36px; font-weight: 700; color: var(--text-dark); }
        
        .calendar-widget { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; gap: 8px; }
        .cal-date { font-size: 12px; padding: 8px 0; border-radius: 10px; color: var(--text-dark); }
        .cal-date.active { background-color: var(--sidebar-bg); color: white; }

        @media (max-width: 1024px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .right-col { flex-direction: column-reverse; } 
            .top-bar { flex-direction: column; gap: 15px; }
            .search-box { width: 100%; }
        }
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
            <li class="nav-item active"><a href="admin_dashboard.php" class="nav-link"><i class="fas fa-home"></i> DASHBOARD</a></li>
            <li class="nav-item"><a href="admin_sejarah.php" class="nav-link"><i class="fas fa-landmark"></i> TOUR SEJARAH</a></li>
            <li class="nav-item"><a href="admin_haji.php" class="nav-link"><i class="fas fa-kaaba"></i> HAJI KHUSUS</a></li>
            <li class="nav-item"><a href="admin_internasional.php" class="nav-link"><i class="fas fa-globe-asia"></i> INTERNASIONAL</a></li>
            <li class="nav-item"><a href="admin_domestik.php" class="nav-link"><i class="fas fa-map-location-dot"></i> DOMESTIK</a></li>
            <li class="nav-item"><a href="admin_umrah.php" class="nav-link"><i class="fas fa-mosque"></i>UMRAH</a></li>
            <li class="nav-item" style="margin-top: 20px;"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
        </ul>
    </aside>

    <main class="main-content">
        
        <div class="top-bar">
            <h2 class="page-title">Dashboard</h2>
            <div class="user-area">
                <div class="search-area">
                    <form action="" method="GET">
                        <div class="search-box">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input type="text" name="cari" placeholder="Cari Subscriber..." value="<?= htmlspecialchars($keyword); ?>">
                        </div>
                    </form>
                </div>
                <div class="user-profile-small">
                    <div class="user-info-small" style="text-align: right;">
                        <h4>Null Admin</h4>
                        <p>Super Admin</p>
                    </div>
                    <img src="assets/foto.jpeg" alt="User">
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            
            <div class="left-col">
                <div class="welcome-banner">
                    <div class="banner-text">
                        <span class="arabic-text">أهلاً وسهلاً بك يا أدمن</span>
                        <h1>Halo Admin, Selamat Datang!</h1>
                        <p>Kelola semua paket wisata Hksyari Trip dan pantau perkembangan subscriber website di sini.</p>
                    </div>
                    <div class="banner-illustration">
                        <i class="fas fa-mosque"></i>
                    </div>
                </div>

                <div class="section-header-area">
                    <h3 class="section-title">Subscriber Terbaru</h3>
                </div>

                <div class="sub-list-container">
                    
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Data Subscriber</th>
                                <th style="width: 30%;">Tanggal Bergabung</th>
                                <th style="width: 20%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($subs_terbaru && mysqli_num_rows($subs_terbaru) > 0) {
                                while($row = mysqli_fetch_assoc($subs_terbaru)) : 
                                    $nama_user = ucfirst(explode('@', $row['email'])[0]);
                            ?>
                            <tr>
                                <td>
                                    <div class="user-flex">
                                        <div class="user-icon-circle">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="user-text">
                                            <h4><?= $nama_user; ?></h4>
                                            <span><?= $row['email']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="far fa-calendar-alt" style="margin-right:8px; color:#aaa;"></i>
                                    <?= date('d M Y', strtotime($row['tanggal_subscribe'])); ?>
                                </td>
                                <td>
                                    <span class="status-pill">Aktif</span>
                                </td>
                            </tr>
                            <?php endwhile; 
                            } else { ?>
                            <tr>
                                <td colspan="3" style="text-align:center; padding: 30px; color:#999;">
                                    <i class="fas fa-inbox" style="font-size:30px; margin-bottom:10px; display:block;"></i>
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
                </div>

            <div class="right-col">
                <div class="quick-stats-card">
                    <div class="quick-stat-icon"><i class="fas fa-users"></i></div>
                    <div class="quick-stat-number"><?= $jml_subs; ?></div>
                    <div class="quick-stat-label">Total Subscribers</div>
                </div>
                <div class="calendar-widget">
                    <div class="calendar-header">
                        <h4><?= $nama_bulan_tampil; ?></h4>
                        <div class="calendar-nav">
                            <a href="?bulan=<?= $prev_bulan; ?>&tahun=<?= $prev_tahun; ?>"><i class="fas fa-chevron-left"></i></a>
                            <a href="?bulan=<?= $next_bulan; ?>&tahun=<?= $next_tahun; ?>"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="calendar-grid">
                        <div class="cal-day-name">Mo</div><div class="cal-day-name">Tu</div><div class="cal-day-name">We</div>
                        <div class="cal-day-name">Th</div><div class="cal-day-name">Fr</div><div class="cal-day-name">Sa</div><div class="cal-day-name">Su</div>
                        <?php
                        $kosong = $hari_pertama - 1; 
                        for($i=0; $i < $kosong; $i++){ echo '<div class="cal-date empty"></div>'; }
                        for($d=1; $d <= $jumlah_hari; $d++){
                            $is_today = ($d == $real_d && $bulan_pilih == $real_m && $tahun_pilih == $real_y);
                            $active_class = $is_today ? 'active' : '';
                            echo '<div class="cal-date '.$active_class.'">'.$d.'</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>