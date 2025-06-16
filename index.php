<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- LINK SWIPER -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- LINK CSS -->
  <link rel="stylesheet" href="css/style.css" />

  <!-- FONT LINK -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <title>YUMMY FOOD | RESTO</title>
</head>

<body>
  <!-- HEADER SECTION START -->
  <header>
    <a href="#" class="logo"><i class="fas fa-cutlery"></i>Yummy.</a>
    <div class="navbar">
      <a class="" href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#menu">Menu</a>
      <a href="#contact">Contact</a>
    </div>

    <div class="icons">
      <i class="fas fa-bars" id="menu-bars"></i>
      <i class="fas fa-search" id="search-icon"></i>
      <a href="#" class="fas fa-shopping-cart"></a>
      <?php if (isset($_SESSION['user'])): ?>
    <style>
      
   .login-btn {
      background: #37aa37;
      color: white;
      padding: 12px 10px;
      border: none;
      border-radius: 0;
      text-decoration: none;
    }
   .login-btn:hover {
      background: #2a872a;
    }
    </style>
        <a href="#" onclick="if(confirm('Apakah Anda yakin ingin logout?')) window.location.href='logout.php';" class="login-btn"> <span style="color: black; font-weight: 600;"><?= htmlspecialchars($_SESSION['user']) ?></span></a>
    <?php else: ?>
        <a href="login.php" class="login-btn">LOGIN</a>
    <?php endif; ?>
    <style>
      
   .login-btn {
      background: #37aa37;
      color: white;
      padding: 12px 10px;
      border: none;
      border-radius: 0;
      text-decoration: none;
    }
   .login-btn:hover {
      background: #2a872a;
    }
    </style>
    </div>
  </header>
  <!-- HEADER SECTION END -->

  <!-- SEARCH FORM -->
  <form action="" id="search-form">
    <input type="search" name="" placeholder="search here ..." id="search-box">
    <label for="search-box" class="fas fa-search"></label>
    <i class="fas fa-times" id="close"></i>
  </form>
  <!-- SEARCH FORM END -->

  <!-- KERANJANG SECTION START-->
  <div class="cart-overlay" id="cart-overlay"></div>
  <div class="cart" id="cart">
    <h3>Keranjang</h3>
    <ul id="cart-items"></ul>
    <div class="cart-summary">
      <p>Total Item: <span id="total-items">0</span></p>
      <p>Total Harga: <span id="total-price">Rp0</span></p>
    </div>
    <button id="close-cart" class="btn">Tutup</button>
    <button id="checkout-btn" class="btn">Checkout</button>
  </div>
  <!-- KERANJANG SECTION END -->


  <!-- HOME SECTION START -->
  <section class="home" id="home">
    <div class="swiper home-slider">
      <div class="swiper-wrapper wrapper">

        <div class="swiper-slide slide">
          <div class="content">
            <span>Menu Spesial Kita</span>
            <h3>Baked Salmon</h3>
            <p>disajikan dengan bayam tumis (sauteed spinach) dan saus krim lemon atau saus krim ringan lainnya yang dicampur dengan tomat.</p>
            <a href="#menu" class="btn">order now</a>
          </div>
          <div class="image">
            <img src="img/food6.jpg" alt="">
          </div>
        </div>

        <div class="swiper-slide slide">
          <div class="content">
            <span>Menu Spesial Kita</span>
            <h3>Linguine Udang</h3>
            <p>disajikan dengan potongan tomat ceri dan taburan daun bawang dengan menggunakan saus Aglio e Olio yang memberikan cita rasa segar dan gurih.</p>
            <a href="#menu" class="btn">order now</a>
          </div>
          <div class="image">
            <img src="img/food5.jpg" alt="">
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
    </div>
  </section>
  <!-- HOME SECTION END -->


  <!-- ABOUT SECTION START -->
  <section class="about" id="about">
    <h3 class="sub-heading">About Us</h3>
    <h1 class="heading"> why chose us? </h1>

    <div class="row">
      <div class="image">
        <img src="img/food1.jpg" alt="">
      </div>

      <div class="content">
      <h3>Nikmati Kelezatan Terbaik di Setiap Gigitan</h3>
      <p>Yummy Food hadir dengan dedikasi untuk menyajikan hidangan lezat yang dibuat dari bahan-bahan segar pilihan dan resep otentik. Setiap menu kami diracik dengan passion, memastikan pengalaman kuliner yang tak terlupakan bagi Anda dan keluarga. Kami percaya bahwa makanan enak adalah seni, dan kami bersemangat untuk membagikan karya terbaik kami kepada Anda.</p>        <div class="icons-container">
          <div class="icons">
            <i class="fa fa-truck"></i>
            <span>fast delivery</span>
          </div>

          <div class="icons">
            <i class="fa fa-usd"></i>
            <span>easy payment</sp>
          </div>

          <div class="icons">
            <i class="fa fa-headphones"></i>
            <span>24/7 services</span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ABOUT SECTION END -->

  <!-- MENU SECTION START -->
  <section class="menu" id="menu">
    <h3 class="sub-heading">Menu Kita</h3>

    <div class="box-container">
      <?php
      // Menghubungkan ke database
      include 'koneksi.php';

      // Query untuk mengambil data menu
      $query = "SELECT * FROM menu";
      $result = mysqli_query($conn, $query);

      // Menampilkan menu dari database
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="box">';
        echo '<img src="img/' . $row['image'] . '" alt="' . $row['name'] . '" height="200px" width="200px">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<span>Rp' . number_format($row['price'], 0, ',', '.') . '</span>';
        // Tombol untuk menambah item ke keranjang
        echo '<button class="btn add-to-cart" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">Tambahkan</button>';

        echo '</div>';
      }
      ?>
    </div>
  </section>
  <!-- MENU SECTION END -->

  <!-- CONTACT SECTION START -->
  <section class="contact" id="contact">
    <h3 class="sub-heading">Contact Us</h3>

    <div class="row">

      <div class="image">
        <img src="img/ChatGPT Image 12 Apr 2025, 19.12.23.png" alt="Contact Us" />
      </div>

      <form id="contact-form" action="#">
        <div class="inputBox">
          <input type="text" id="nama" placeholder="Nama Anda" required>
          <input type="email" id="email" placeholder="Email Anda" required>
        </div>
        <div class="inputBox">
          <input type="tel" id="telepon" placeholder="Nomor Telepon">
          <input type="text" id="subjek" placeholder="Subjek">
        </div>
        <textarea id="pesan" placeholder="Pesan Anda" cols="30" rows="10" required></textarea>
        <input type="submit" value="Kirim via Whatsapp" class="btn">
      </form>

    </div>
  </section>
  <!-- CONTACT SECTION END -->

  <!-- FOOTER START -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-logo">
        <h3><i class="fas fa-cutlery"></i> Yummy Food</h3>
        <p>Hidangan lezat, pelayanan cepat, dan suasana hangat – semua dalam satu tempat.</p>
      </div>

      <div class="footer-nav">
        <h4>Link Cepat</h4>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>

      <div class="footer-contact">
        <h4>Hubungi Kami</h4>
        <p><i class="fas fa-phone"></i> 0812-3456-7890</p>
        <p><i class="fas fa-envelope"></i> info@yummyfood.com</p>
        <p><i class="fas fa-map-marker-alt"></i> Jl. Lezat No.1, Kota Rasa</p>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Yummy Food. All rights reserved.</p>
    </div>
  </footer>
  <!-- FOOTER END -->



  <!-- JAVASCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/script.js"></script>

</body>

</html>