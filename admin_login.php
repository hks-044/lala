<?php
session_start();
include 'koneksi.php';

// --- LOGIKA LOGIN (TIDAK BERUBAH) ---
if (isset($_COOKIE['id_admin']) && isset($_COOKIE['kunci_rahasia'])) {
    $id = $_COOKIE['id_admin'];
    $key = $_COOKIE['kunci_rahasia'];
    $result = mysqli_query($koneksi, "SELECT username FROM admins WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['sudah_login'] = true;
    }
}

if (isset($_SESSION['sudah_login'])) {
    header("Location: admin_dashboard.php");
    exit;
}

if (isset($_POST['tombol_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek_user = mysqli_query($koneksi, "SELECT * FROM admins WHERE username = '$username'");

    if (mysqli_num_rows($cek_user) === 1) {
        $data = mysqli_fetch_assoc($cek_user);
        if (password_verify($password, $data['password'])) {
            $_SESSION['sudah_login'] = true;
            if (isset($_POST['ingat_saya'])) {
                setcookie('id_admin', $data['id'], time() + (7 * 24 * 60 * 60));
                setcookie('kunci_rahasia', hash('sha256', $data['username']), time() + (7 * 24 * 60 * 60));
            }
            header("Location: admin_dashboard.php");
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - HKSyari Trip</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* --- CSS AESTHETIC --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('assets/adminlogin.png'); /* Pastikan gambar ini ada, atau ganti URL online */
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            padding-right: 200px;
        }

        /* Overlay Hitam Transparan agar tulisan terbaca */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(12, 140, 112, 0.6); /* Warna Hijau Brand Transparan */
            background: linear-gradient(135deg, rgba(15, 32, 39, 0.8), rgba(12, 140, 112, 0.7)); 
            z-index: 1;
        }

        .login-card {
            position: relative;
            z-index: 2; /* Agar di atas overlay */
            background: rgba(255, 255, 255, 0.95); /* Putih sedikit transparan */
            padding: 40px 35px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease;
        }

        .brand-logo {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
            display: block;
            margin-left: 0;
            margin-right: auto;


        }

        .login-title {
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .login-subtitle {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        .form-control {
            background-color: #f7f9fc;
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #0c8c70; /* Hijau saat diklik */
            box-shadow: 0 0 0 4px rgba(12, 140, 112, 0.1);
        }

        .btn-login {
            background: #0c8c70;
            color: white;
            padding: 12px;
            border-radius: 10px;
            border: none;
            width: 100%;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #09634f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(12, 140, 112, 0.3);
        }

        .form-check-input:checked {
            background-color: #0c8c70;
            border-color: #0c8c70;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
            display: block;
            text-decoration: none;
            color: #888;
            font-size: 13px;
            transition: 0.3s;
        }
        .back-link:hover { color: #0c8c70; }

        /* Animasi Masuk */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <img src="assets/logotrip.png" alt="Logo HKSyari" class="brand-logo">
        
      <h4 class="login-title">
            <span style="display:block; margin-top:5px; color:#0c8c70; font-size:0.8em;">اَلسَّلَامُ عَلَيْكُمْ</span>
             Welcome Back! 
        </h4>

        <p class="login-subtitle">
            Silakan login untuk mengelola paket trip.
        </p>
                
        <?php if(isset($error)) : ?>
            <div class="alert alert-danger py-2 text-center" style="font-size:14px; border-radius:10px;">
                Username atau Password Salah!
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label" style="font-size:13px; font-weight:600; color:#555;">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
            </div>
            
            <div class="mb-3">
                <label class="form-label" style="font-size:13px; font-weight:600; color:#555;">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" name="ingat_saya" class="form-check-input" id="ingat">
                <label class="form-check-label" for="ingat" style="font-size:13px; color:#666;">Ingat Saya</label>
            </div>
            
            <button type="submit" name="tombol_login" class="btn-login">MASUK</button>
        </form>

        <a href="home.html" class="back-link">
            ← Kembali ke Halaman Utama
        </a>
    </div>

</body>
</html>