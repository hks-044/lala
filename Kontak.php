<?php
include 'koneksi.php'; // <--- TAMBAHKAN INI (Pastikan nama filenya benar)
?>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Amiri&display=swap" rel="stylesheet">

<style>
  /* --- CSS KHUSUS CONTACT --- */
  
  .contact-section-wrapper {
      margin-top: 0px; 
      background: #fff;
      padding-bottom: 50px;
      width: 100%; 
  }

  .contact-scope {
    --accent: #0b5a4a; 
    --muted: #6b6b6b; 
    --line: #e9e9e9;
    font-family: 'Montserrat', sans-serif;
    color: #111;
  }

  .contact-header {
      padding: 10px 20px 0px;
      text-align: center;
  }
  .contact-header h1 {
      margin: 0;
      font-size: 30px;
      letter-spacing: 0.5px;
      font-weight: 700;
  }
  .breadcrumb-custom {
      font-size: 12px;
      color: var(--muted);
      margin-top: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
  }

  .wrap-contact { max-width: 1150px; margin: 0 auto; }

  /* Accordion */
  .accordion { 
      margin-top: 0px; 
      overflow: hidden; 
      border: none; 
  }
  
  .acc-item {
      display: flex; align-items: center; justify-content: space-between;
      padding: 15px 10px; 
      border-bottom: 1px solid var(--line);
      cursor: pointer; background: #fff; transition: 0.2s;
      
      /* Tambahan: Border kiri transparan agar tidak lompat saat aktif */
      border-left: 5px solid transparent; 
  }
  
  .acc-item:hover { background: #f9f9f9; }

  /* --- JUDUL BIASA --- */
  .acc-item h3 { 
      margin: 0; 
      font-size: 19px; 
      font-weight: 600; 
      color: #212529; /* Warna Hitam Default */
      font-family: 'Montserrat', sans-serif;
      line-height: 2; 
      transition: color 0.3s ease; /* Efek transisi halus */
  }

  /* --- JUDUL SAAT AKTIF (DIBUKA) --- */
  /* Ini kode yang Anda cari! */
  .acc-item.active-header h3 {
      color: #0b5a4a !important; /* Berubah jadi HIJAU */
  }
  
  /* Opsional: Jika ingin border kiri hijau juga muncul saat aktif */
  .acc-item.active-header {
      background-color: #f4fdfb; /* Latar sedikit hijau muda */
      border-left: 5px solid #0b5a4a; /* Garis hijau di kiri */
  }
  
  .accordion-arrow { font-size: 20px; display: inline-block; transition: transform .2s ease; color: #111; }

  /* Body Accordion */
  .acc-body {
      max-height: 0; 
      overflow: hidden; 
      transition: max-height .35s ease, padding .2s ease;
      background: #fff;
      padding: 0 10px;
  }
  
  .acc-body.open {
      padding: 18px 10px 28px; 
  }

  .acc-body .acc-info { 
      color: var(--muted); 
      line-height: 1.8; 
      font-size: 14px; 
      position: static; 
  }
  .acc-body .acc-info strong { color: #111; }
  
  @media (max-width:900px){ 
      .contact-header h1{ font-size: 2em; } 
  }
</style>

<div id="contact" class="contact-section-wrapper contact-scope">
    
    <div class="contact-header">
        <div class="wrap-contact">
          <h1>Kontak</h1>
          <div style="font-size:22px; color:#475569;">
            اتصل بنا
          </div>
          <div class="breadcrumb-custom">HUBUNGI KAMI</div>
        </div>
    </div>

    <div class="wrap-contact" style="padding: 0 20px;">
       <div class="accordion" id="accordion">

          <div class="acc-item" data-target="body1">
            <h3>Layanan Tour Sejarah Islam</h3>
            <span class="accordion-arrow">⌵</span>
          </div>
          <div class="acc-body" id="body1">
            <div class="acc-info">
              <strong>Alamat:</strong><br>
              Gedung Graha Pena Lt. 1<br>
              Jl. Urip Sumoharjo No. 20, Makassar 90234<br><br>
              
              <strong>Telepon:</strong> (0411) 455 6789<br>
              <strong>Email:</strong> sejarahislam@hksyaritrip.id<br>
              <strong>Jam Operasional:</strong><br>
                 Senin - Jumat, 08.30 - 17.30 WITA
            </div>
          </div>

          <div class="acc-item" data-target="body2">
            <h3>Layanan Haji Khusus</h3>
            <span class="accordion-arrow">⌵</span>
          </div>
          <div class="acc-body" id="body2">
            <div class="acc-info">
              <strong>Alamat:</strong><br>
              Kawasan Ruko Jasper 2 (Panakkukang)<br>
              Jl. Boulevard No. 88, Makassar 90231<br><br>
              
              <strong>Telepon:</strong> (0411) 422 3311<br>
              <strong>Email:</strong> hajikhusus@hksyaritrip.id<br>
              <strong>Jam Operasional:</strong><br>
                 Senin - Jumat, 08.30 - 17.30 WITA
            </div>
          </div>

          <div class="acc-item" data-target="body3">
            <h3>Layanan Umrah</h3>
            <span class="accordion-arrow">⌵</span>
          </div>
          <div class="acc-body" id="body3">
            <div class="acc-info">
              <strong>Alamat:</strong><br>
              Ruko Business Center Vivid<br>
              Jl. A.P. Pettarani No. 102, Makassar 90222<br><br>
              
              <strong>Telepon:</strong> (0411) 877 6655<br>
              <strong>Email:</strong> umrah@hksyaritrip.id<br>
              <strong>Jam Operasional:</strong><br>
                 Senin - Jumat, 08.30 - 17.30 WITA
            </div>
          </div>

          <div class="acc-item" data-target="body4">
            <h3>Layanan Wisata Halal</h3>
            <span class="accordion-arrow">⌵</span>
          </div>
          <div class="acc-body" id="body4">
            <div class="acc-info">
              <strong>Alamat:</strong><br>
              Jl. Sultan Alauddin No. 99 (Depan UIN)<br>
              Makassar, Sulawesi Selatan 90221<br><br>
              
              <strong>Telepon:</strong> (0411) 866 2233<br>
              <strong>Email:</strong> halal@hksyaritrip.id<br>
              <strong>Jam Operasional:</strong><br>
                 Senin - Jumat, 08.30 - 17.30 WITA
            </div>
          </div>

        </div>
    </div>

</div>

<script>
  document.querySelectorAll('.acc-item').forEach(item=>{
    item.addEventListener('click',()=>{
      const targetId = item.getAttribute('data-target');
      const body = document.getElementById(targetId);
      const arrow = item.querySelector('.accordion-arrow');

      if(!body) return;
      const isOpen = body.classList.contains('open');

      // 1. RESET: Tutup semua & Hapus warna hijau (active-header)
      document.querySelectorAll('.acc-body').forEach(b=>{
        b.classList.remove('open');
        b.style.maxHeight = null;
      });
      document.querySelectorAll('.accordion-arrow').forEach(a=>{
        a.style.transform = 'rotate(0)';
      });
      // Hapus class active-header dari semua item
      document.querySelectorAll('.acc-item').forEach(i => {
        i.classList.remove('active-header'); 
      });

      // 2. ACTION: Buka yang diklik & Tambah warna hijau
      if(!isOpen){
        body.classList.add('open');
        setTimeout(()=>{ body.style.maxHeight = body.scrollHeight + 'px'; }, 50);
        arrow.style.transform = 'rotate(180deg)';
        
        // Tambahkan class ini agar CSS warnanya bekerja
        item.classList.add('active-header'); 
      }
    });
  });
</script>

<?php include 'footer.php'; ?>