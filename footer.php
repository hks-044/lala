<?php
// LOGIKA MENYIMPAN EMAIL KE DATABASE
if (isset($_POST['btn_subscribe'])) {
    // Pastikan koneksi.php sudah di-include di file utama
    // $koneksi diambil dari file utama
    $email_subs = htmlspecialchars($_POST['email_subs']);

    if (filter_var($email_subs, FILTER_VALIDATE_EMAIL)) {
        $cek_email = mysqli_query($koneksi, "SELECT email FROM subscribers WHERE email = '$email_subs'");
        
        if (mysqli_num_rows($cek_email) > 0) {
            echo "<script>alert('Email ini sudah terdaftar sebelumnya!');</script>";
        } else {
            $insert = mysqli_query($koneksi, "INSERT INTO subscribers (email) VALUES ('$email_subs')");
            if ($insert) {
                echo "<script>alert('Terima kasih! Anda berhasil berlangganan newsletter HKSyari Trip.');</script>";
            } else {
                echo "<script>alert('Gagal menyimpan email. Silakan coba lagi.');</script>";
            }
        }
    } else {
        echo "<script>alert('Format email tidak valid!');</script>";
    }
}
?>

<style>
    .footer-section {
        background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #0b5a4a 100%);
        color: #fff;
        padding: 60px 20px 30px;
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .footer-bg-overlay {
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        opacity: 0.1;
        background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=2074&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        z-index: 0;
    }

    .footer-content {
        position: relative;
        z-index: 1;
        max-width: 1100px;
        margin: 0 auto;
    }

    .footer-heading {
        font-size: 28px;
        font-weight: 400;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .footer-subtext {
        font-size: 14px;
        color: #d1d5db;
        margin-bottom: 30px;
        max-width: 600px;
        line-height: 1.6;
    }

    .subscribe-form {
        display: flex;
        gap: 10px;
        max-width: 500px;
        margin-bottom: 30px;
    }

    .input-subs {
        flex: 1;
        padding: 12px 15px;
        border-radius: 4px;
        border: none;
        outline: none;
        font-size: 14px;
        color: #333;
    }

    .btn-subs {
        background-color: #0c8c70;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .btn-subs:hover {
        background-color: #09634f;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .copyright-bar {
        margin-top: 40px; /* Jarak sedikit dikurangi karena tidak ada tombol download */
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
        text-align: center;
        font-size: 12px;
        color: #8899a6;
    }
    .copyright-bar strong { color: white; }

    @media (max-width: 600px) {
        .subscribe-form { flex-direction: column; }
        .btn-subs { width: 100%; }
        .footer-heading { font-size: 24px; }
    }
</style>

<footer class="footer-section">
    <div class="footer-bg-overlay"></div>

    <div class="footer-content">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="footer-heading">Dapatkan Inspirasi Perjalanan Halal Dunia</h2>
                <p class="footer-subtext">
                    Daftarkan email Anda untuk mendapatkan penawaran eksklusif haji, umrah, dan panduan wisata sejarah Islam langsung ke inbox Anda.
                </p>

                <form method="POST" action="">
                    <div class="subscribe-form">
                        <input type="email" name="email_subs" class="input-subs" placeholder="Masukkan alamat email Anda" required>
                        <button type="submit" name="btn_subscribe" class="btn-subs">Subscribe</button>
                    </div>
                </form>
                
                </div>
        </div>

        <div class="copyright-bar">
            &copy; 2025 <strong>HKSyari Trip</strong> | Menjelajah Alam, Mendekat kepada Allah
        </div>
    </div>
</footer>