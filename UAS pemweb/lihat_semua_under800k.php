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
    /* Reset dan dasar font */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #af7ac5 ;
      color: white;
      padding: 20px 0px 20px 20px;
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
      margin: 0 10px;
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

    /* Responsive */
    @media (max-width: 600px) {
      .header {
        flex-direction: column;
        align-items: flex-start;
      }
      .search-bar {
        margin: 10px 0;
        max-width: 100%;
      }
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
    <form action="" method="get" onsubmit="return false;">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="search-input" placeholder="Search for products" aria-label="Search for products" />
    </form>
  </div>
  <div class="user-cart">
    <?php if ($namaUser && $namaUser !== 'Guest'): ?>
      <a href="akun.php">Welcome, <?= $namaUser ?>!</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="signin.php">Sign In</a>
    <?php endif; ?>
    <a href="keranjang.php" aria-label="Cart"><i class="fa-solid fa-cart-shopping"></i></a>
  </div>
</header>

<h2>Semua Produk Under 800k</h2>

<div class="product-grid" id="product-grid">
  <div class="product-card">
    <span class="unique-discount">-45%</span>
    <a href="product_detail.php?product_id=8" class="btn-detail" aria-label="Detail Abercrombie & Fitch Authentic Night">
      <img src="Asset/1.jpg" alt="Abercrombie & Fitch Authentic Night" />
      <h3>Abercrombie & Fitch Authentic Night For Men 100ml EDP</h3>
      <p class="description">A fragrance for the man who thrives on living life with unapologetic</p>
      <p>
        <span class="old-price">Rp 1.400.000</span>
        <span class="new-price">Rp 770.000</span>
      </p>
    </a>
  </div>

  <div class="product-card">
    <span class="unique-discount">-35%</span>
    <a href="product_detail.php?product_id=9" class="btn-detail" aria-label="Detail Yves Saint Laurent Black Opium">
      <img src="Asset/7.jpg" alt="YSL Black Opium" />
      <h3>Yves Saint Laurent Black Opium 90ml EDP</h3>
      <p class="description">Perfume with a warm and exotic oriental scent</p>
      <p>
        <span class="old-price">Rp 1.000.000</span>
        <span class="new-price">Rp 799.000</span>
      </p>
    </a>
  </div>

  <div class="product-card">
    <span class="unique-discount">-25%</span>
    <a href="product_detail.php?product_id=10" class="btn-detail" aria-label="Detail Tom Ford Oud Wood">
      <img src="Asset/8.jpg" alt="Tom Ford Oud Wood" />
      <h3>Tom Ford Oud Wood 50ml EDP</h3>
      <p class="description">A woody fragrance with unique depth and masculinity</p>
      <p>
        <span class="old-price">Rp 2.000.000</span>
        <span class="new-price">Rp 610.000</span>
      </p>
    </a>
  </div>

  <div class="product-card">
    <span class="unique-discount">-40%</span>
    <a href="product_detail.php?product_id=11" class="btn-detail" aria-label="Detail Dolce & Gabbana Light Blue">
      <img src="Asset/9.jpg" alt="D&G Light Blue" />
      <h3>Dolce & Gabbana Light Blue 100ml EDT</h3>
      <p class="description">A fresh, bright, and energetic fragrance</p>
      <p>
        <span class="old-price">Rp 1.110.000</span>
        <span class="new-price">Rp 530.000</span>
      </p>
    </a>
  </div>

  <div class="product-card">
    <span class="unique-discount">-60%</span>
    <a href="product_detail.php?product_id=12" class="btn-detail" aria-label="Detail Chanel No.5">
      <img src="Asset/10.jpg" alt="Chanel No.5" />
      <h3>Chanel No.5 100ml EDP</h3>
      <p class="description">A floral fragrance embodying elegance and femininity</p>
      <p>
        <span class="old-price">Rp 1.200.000</span>
        <span class="new-price">Rp 480.000</span>
      </p>
    </a>
  </div>
</div>

<script>
  document.getElementById('search-input').addEventListener('input', function() {
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
