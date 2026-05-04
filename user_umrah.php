<?php
// 1. HUBUNGKAN KE DATABASE
include 'koneksi.php';

// 2. AMBIL DATA
$query = "SELECT * FROM paket_umrah ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Paket Trip — Final</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  /* --- NAVBAR CSS (Saya rapikan duplikatnya) --- */
  .navbar {
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 100;
      padding: 15px 60px; /* Padding enak dilihat */
      display: flex;
      justify-content: space-between;
      align-items: center; 
      backdrop-filter: blur(10px);
      border-bottom: 1px solid #0c8c70;
      background: rgba(255, 255, 255, 0.9); /* Sedikit lebih solid */
  }

  .nav-links {
      display: flex;
      gap: 35px;
      align-items: center;
      list-style: none;
      margin: 0;
      padding: 0;
  }

  .nav-links a {
      text-decoration: none;
      color: #333;
      font-size: 15px;
      font-weight: 400;
      transition: 0.3s ease;
  }

  .nav-links a:hover {
      color: #0c8c70;
  }

  .logo img, .logo-img {
      height: 60px;   
      width: auto;
      object-fit: contain;
      cursor: pointer;
      display: block;
  }

  .btn {
      background-color: #0c8c70;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 14px;
      border-radius: 4px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: bold;
  }

  .btn:hover {
      background-color: #08463a;
  }

  /* --- CARD CSS --- */
  :root{ --photo-h:330px; --gap:0px; --accent:#ff7a00; --muted:#64748b; --card-radius:10px; }
  body{ background: #F0F6F5; font-family:system-ui, "Segoe UI", Roboto, sans-serif; -webkit-font-smoothing:antialiased; margin: 0; }
  .wrap{ max-width:1200px; margin:36px auto; padding:0 18px; }
  .row.g-5 { gap: 10px; }
  .tour-card{ position:relative; border-radius:var(--card-radius); background:#fff; box-shadow:0 6px 18px rgba(15,23,42,.06); transition: transform .18s ease, box-shadow .18s ease; display:block; cursor:pointer; overflow:visible; outline:none; }
  .tour-card:focus{ box-shadow:0 12px 30px rgba(15,23,42,.12); }
  .photo{ height:var(--photo-h); position:relative; overflow:hidden; border-top-left-radius:var(--card-radius); border-top-right-radius:var(--card-radius); background: #ffffff; padding:6px; }
  .photo img{ width:100%; height:100%; object-fit:cover; display:block; transition: transform .45s ease, filter .45s ease; }
  
  .info{ position:absolute; left:var(--gap); right:var(--gap); bottom:var(--gap); background: rgba(255,255,255,0.96); border-radius:8px; padding:10px 12px; box-shadow:0 10px 26px rgba(2,6,23,0.06); box-sizing:border-box; overflow:hidden; max-height:50px; transition: max-height .75s ease, padding .55s ease; pointer-events:none; }
  
  .info-inner{ display:flex; flex-direction:column; gap:8px; }
  
  .info .title{ 
    font-weight:700; color:#0f172a; font-size:0.98rem; line-height:1.3; 
    word-break: break-word; overflow-wrap: break-word;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;
    height: 2.6em; 
  }
  
  .info .meta{ color:var(--muted); font-size:.9rem; }

  .meta-lokasi {
      word-break: break-word; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 1.3em; 
  }

  .meta-deskripsi ul {
      margin: 6px 0 0 18px; padding: 0;
      word-break: break-word; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;
  }

  .tour-card:hover .info, .tour-card:focus .info, .tour-card.show-info .info{ max-height: 500px; }
  .tour-card:hover .photo img, .tour-card:focus .photo img, .tour-card.show-info .photo img{ transform: scale(1.08); filter: brightness(.48); }
  .card-footer-space { height:12px; }
  @media (max-width:576px){ :root{ --photo-h:150px; } .info{ transition:none; } }
  .col { display:flex; }
  .col > .tour-card { flex:1; display:block; border-radius: var(--card-radius); overflow:hidden; }
</style>
</head>
<body>

  <header class="navbar">
      
      <div class="logo">
          <a href="home.html">
            <img src="assets/logotrip.png" class="logo-img" alt="Logo">
          </a>
      </div>

      <ul class="nav-links">
          <li><a href="home.html#home">Home</a></li>
          
          <li><a href="home.html#about">About Us</a></li>
          
          <li><a class="nav-link" href="home.html#packages">Travel Packages</a></li>
          
          <li><a href="#contactumrah">Contact</a></li>
          
          <li>
              <a href="admin_login.php">
                  <button class="btn">Admin Masuk</button>
              </a>
          </li>
      </ul>

  </header>

  <div class="wrap">
            <h2 style="margin-bottom:6px;margin-top:120px; font-weight:700; text-align:center;">
          Paket Tour Sejarah Islam Dunia<br>
          <span style="font-size:22px; color:#475569; font-weight:500;">
            جولات في معالم التاريخ الإسلامي حول العالم
          </span>
        </h2>

        <p style="color:#475569;margin-bottom:18px; text-align:center;">
          Sempurnakan ibadah Anda ke Baitullah dengan fasilitas premium, bimbingan intensif, dan kenyamanan maksimal<br>
        </p>

          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

          <?php 
          while($row = mysqli_fetch_assoc($result)) : 
          ?>

          <div class="col">
            <article class="tour-card" tabindex="0">
              <div class="photo">
                <img src="assets/<?= $row['gambar']; ?>" alt="<?= $row['judul']; ?>">

                <div class="info" aria-hidden="true">
                  <div class="info-inner">

                    <div class="title"><?= $row['judul']; ?></div>

                    <div class="meta">📅 <?= date('d F Y', strtotime($row['tanggal_keberangkatan'])); ?></div>
                    <div class="meta">⏱ <?= $row['durasi']; ?></div>
                    <div class="meta" style="font-weight:700; color:#d97706;">
                        💳 Harga: Rp <?= number_format($row['harga'], 0, ',', '.'); ?> / pax
                    </div>

                    <div class="meta meta-lokasi">📍 <?= $row['lokasi']; ?></div>

                    <div class="meta meta-deskripsi">
                      📜 Highlight Perjalanan:
                      <ul style="margin:6px 0 0 0; padding-left: 15px; list-style-type: disc;">
                        <?php
                            $deskripsi_mentah = $row['deskripsi_umrah'];
                            $pola_ganti = array('<br>', '<br />', '<br/>', "\r\n", "\r");
                            $deskripsi_bersih = str_replace($pola_ganti, "\n", $deskripsi_mentah);
                            $daftar_poin = explode("\n", $deskripsi_bersih);

                            foreach($daftar_poin as $poin) {
                                $poin = trim($poin);
                                if(!empty($poin)) {
                                    echo "<li>" . htmlspecialchars($poin) . "</li>";
                                }
                            }
                        ?>
                      </ul>
                    </div>

                  </div>
                </div>

              </div>
            </article>
          </div>

          <?php endwhile; ?>
          
          <?php if(mysqli_num_rows($result) == 0) : ?>
             <div style="width:100%; text-align:center; padding:20px;">Belum ada paket tersedia saat ini.</div>
          <?php endif; ?>

        </div>
        <div class="card-footer-space"></div>
  </div>

<div id="contactumrah" class="scroll-target">
<?php include 'Kontak.php'; ?>

</body>
</html>