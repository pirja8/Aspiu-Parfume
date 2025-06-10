<?php
session_start();
$namaUser = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lihat Semua - Under 800k</title>
  <link rel="stylesheet" href="fontawesome-free-6.7.1-web/css/all.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #af7ac5;
      color: white;
      padding: 20px;
      flex-wrap: wrap;
    }
    .header .logo a {
      color: white;
      text-decoration: none;
      font-size: 24px;
      font-weight: bold;
    }
    .search-bar {
      width: 100%;
      max-width: 500px;
      flex-grow: 1;
      margin: 10px;
    }
    .search-bar form {
      display: flex;
      align-items: center;
      background-color: white;
      border-radius: 10px;
      padding: 8px 16px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      width: 100%;
    }
    .search-bar i {
      color: #888;
      font-size: 18px;
      margin-right: 10px;
    }
    .search-bar input[type="text"] {
      border: none;
      outline: none;
      font-size: 16px;
      background: transparent;
      width: 100%;
    }
    .user-cart a {
      color: white;
      margin-left: 15px;
      text-decoration: none;
      font-weight: 600;
    }
    .user-cart a:hover {
      text-decoration: underline;
    }
    h2 {
      text-align: center;
      margin: 30px 0 20px;
      color: #9b59b6;
      font-size: 28px;
      font-weight: bold;
    }
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      padding: 0 20px 40px;
      max-width: 1200px;
      margin: 0 auto;
    }
    .product-card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
      position: relative;
      cursor: pointer;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .product-card img {
      max-width: 100%;
      height: 180px;
      object-fit: contain;
      margin-bottom: 12px;
      border-radius: 6px;
    }
    .product-card h3 {
      font-size: 18px;
      margin-bottom: 8px;
      color: #6b44a1;
    }
    .description {
      font-size: 14px;
      color: #555;
      margin-bottom: 12px;
      min-height: 40px;
    }
    .old-price {
      font-size: 14px;
      color: gray;
      text-decoration: line-through;
      margin-right: 10px;
    }
    .new-price {
      font-size: 16px;
      color: #e63946;
      font-weight: bold;
    }
    .unique-discount {
      position: absolute;
      background: red;
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      top: 10px;
      left: 10px;
    }
    .btn-detail {
      color: inherit;
      text-decoration: none;
      display: block;
      height: 100%;
    }
    @media (max-width: 600px) {
      .product-card img {
        height: 140px;
      }
    }
  </style>
</head>
<body>

<header class="header">
  <div class="logo"><a href="beranda.php">Aspiu Parfume</a></div>
  <div class="search-bar">
    <form onsubmit="return false;">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="search-input" placeholder="Search for products" />
    </form>
  </div>
  <div class="user-cart">
    <?php if ($namaUser && $namaUser !== 'Guest'): ?>
      <a href="akun.php">Welcome, <?= $namaUser ?>!</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="signin.php">Sign In</a>
    <?php endif; ?>
    <a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a>
  </div>
</header>

<h2>Semua Produk New Arrival</h2>

<div class="product-grid" id="product-grid">
  <!-- Produk 1 -->
  <div class="product-card">
    <span class="unique-discount">-45%</span>
    <a href="product_detail.php?product_id=13" class="btn-detail">
      <img src="Asset/11.jpg" alt="Dior Addict 100ml EDP">
      <h3>Dior Addict 100ml EDP</h3>
      <p class="description">An oriental scent that radiates warmth and luxury</p>
      <p><span class="old-price">Rp 4.400.000</span><span class="new-price">Rp 1.400.000</span></p>
    </a>
  </div>

  <!-- Produk 2 -->
  <div class="product-card">
    <span class="unique-discount">-35%</span>
    <a href="product_detail.php?product_id=14" class="btn-detail">
      <img src="Asset/12.jpg" alt="Gucci Guilty Pour Homme">
      <h3>Gucci Guilty Pour Homme 90ml EDT</h3>
      <p class="description">A woody fragrance with a bold and masculine character</p>
      <p><span class="old-price">Rp 6.000.000</span><span class="new-price">Rp 1.100.000</span></p>
    </a>
  </div>

  <!-- Produk 3 -->
  <div class="product-card">
    <span class="unique-discount">-25%</span>
    <a href="product_detail.php?product_id=15" class="btn-detail">
      <img src="Asset/13.jpg" alt="Versace Dylan Blue">
      <h3>Versace Dylan Blue 100ml EDT</h3>
      <p class="description">A fresh fragrance with citrus and aquatic notes</p>
      <p><span class="old-price">Rp 3.210.000</span><span class="new-price">Rp 980.000</span></p>
    </a>
  </div>

  <!-- Produk 4 -->
  <div class="product-card">
    <span class="unique-discount">-40%</span>
    <a href="product_detail.php?product_id=16" class="btn-detail">
      <img src="Asset/14.jpg" alt="Lancôme La Vie Est Belle">
      <h3>Lancôme La Vie Est Belle 75ml EDP</h3>
      <p class="description">A floral fragrance representing joy and beauty</p>
      <p><span class="old-price">Rp 4.290.000</span><span class="new-price">Rp 1.300.000</span></p>
    </a>
  </div>

  <!-- Produk 5 -->
  <div class="product-card">
    <span class="unique-discount">-60%</span>
    <a href="product_detail.php?product_id=17" class="btn-detail">
      <img src="Asset/15.jpg" alt="Montblanc Explorer">
      <h3>Montblanc Explorer 100ml EDP</h3>
      <p class="description">A woody fragrance for the modern adventurer</p>
      <p><span class="old-price">Rp 1.110.000</span><span class="new-price">Rp 890.000</span></p>
    </a>
  </div>
</div>

<script>
  document.getElementById('search-input').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    const products = document.querySelectorAll('.product-card');

    products.forEach(product => {
      const name = product.querySelector('h3').textContent.toLowerCase();
      const desc = product.querySelector('.description').textContent.toLowerCase();

      if (name.includes(filter) || desc.includes(filter)) {
        product.style.display = '';
      } else {
        product.style.display = 'none';
      }
    });
  });
</script>

</body>
</html>
