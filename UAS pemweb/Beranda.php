<?php
session_start();
$is_logged_in = isset($_SESSION['name']); // Periksa apakah user sudah login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspiu Parfume</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.7.1-web/css/all.css">
</head>
<body>
    <header class="header">
        <div class="logo">Aspiu Parfume</div>
        <br>
        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Search for products">
        </div>

        <div class="user-cart">
        <?php if ($is_logged_in): ?>
                <a href="akun.php">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Sign-in</a>
            <?php endif; ?>
                <a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
        </div>
    </header>
    
    <nav class="navbar">
    <ul class="menu">
        <li class="menu-item">
            <a href="#">Men</a>
            <ul class="dropdown">
                <li><a href="#">For Men</a></li>
                <li><a href="#">Eau De Parfum</a></li>
                <li><a href="#">Eau De Toilette</a></li>
                <li><a href="#">Perfume</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#">Women</a>
            <ul class="dropdown">
                <li><a href="#">For Women</a></li>
                <li><a href="#">Eau De Parfum</a></li>
                <li><a href="#">Eau De Toilette</a></li>
            </ul>
        </li>
        <li class="menu-item"><a href="#">Best Sellers</a></li>
        <li class="menu-item"><a href="#">Sale</a></li>
        <li class="menu-item">
            <a href="#">Shop By Categories</a>
            <ul class="dropdown">
                <li><a href="#">Notes</a></li>
                <li><a href="#">Shop by Brands</a></li>
                <li><a href="#">Value Buy</a></li>
            </ul>
        </li>
        <li class="menu-item"><a href="#">New Arrivals</a></li>
        <li class="menu-item"><a href="#">Blogs</a></li>
        <li class="menu-item"><a href="#">Order Status</a></li>
        <li class="menu-item"><a href="#">EN</a></li>
    </ul>
</nav>

    <main class="main-content">
        <div class="banner">
            <div class="banner-text">
                <h1>Free Shipping!</h1>
                <p>Shop your favorite perfume now. Shipping costs? On us!</p>
            </div>
            <div class="banner-image">
                <img src="Asset/driver.jpg" alt="Delivery Illustration">
            </div>
        </div>
    </main>

    <div class="ajakan">
      <div>
        <h4>100% ORIGINAL</h4>
        <p>Shop with confidence with guaranteed authentic products</p>
      </div>
      <div>
        <h4>FREE DELIVERY</h4>
        <p>Enjoy FREE delivery with minimum purchase</p>
      </div>
      <div>
        <h4>GET FREE GIFTS</h4>
        <p>Receive complimentary gifts with each purchase</p>
      </div>
    </div>
    

    <div class="shop-by-notes">
      <h3>Shop By Notes</h3>
      <div class="notes-container">
        <div class="note">
          <img src="Asset/oriental.jpg" alt="Oriental Notes">
          <span>Oriental Notes</span>
        </div>
        <div class="note">
          <img src="Asset/cendana.jpg" alt="Woody Notes">
          <span>Woody Notes</span>
        </div>
        <div class="note">
          <img src="Asset/fresh.jpg" alt="Fresh Notes">
          <span>Fresh Notes</span>
        </div>
        <div class="note">
          <img src="Asset/floral.jpg" alt="Floral Notes">
          <span>Floral Notes</span>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="carousel-wrapper">
        <h2 class="carousel-title">Best Deals</h2>
        <div class="carousel">
          <div class="carousel-track-container">
            <div class="carousel-track">
              <!-- Card Items -->
              <div class="card">
              <span class="discount">-63%</span>
             <img src="Asset/4.jpg" alt="Armaf Club De Nuit">
              <h3>Armaf Club De Nuit EDP Set For Women</h3>
                 <p class="old-price">Rp 1.490.000</p>
               <p class="new-price">Rp 550.000</p>
                   <button class="add-to-cart-btn" data-product-id="2">Add to Cart</button> 
                   <br>
                   <a href="product_detail.php?product_id=2" class="btn btn-primary">View Details</a>
              </div>

              <div class="card">
              <span class="discount">-67%</span>
             <img src="Asset/5.jpg" alt="Clinique Happy">
              <h3>Clinique Happy For Men 100ml EDT</h3>
                 <p class="old-price">Rp 1.500.000</p>
               <p class="new-price">Rp 900.000</p>
                   <button class="add-to-cart-btn" data-product-id="4">Add to Cart</button> 
                   <br>
                   <a href="product_detail.php?product_id=4" class="btn btn-primary">View Details</a>
              </div>

    
              <div class="card">
              <span class="discount">-10%</span>
             <img src="Asset/2.jpg" alt="Carven Dans Ma Bulle De Fleurs EDT 100 ml">
              <h3>Carven Dans Ma Bulle De Fleurs EDT 100 ml</h3>
                 <p class="old-price">Rp 1.000.000</p>
               <p class="new-price"> Rp1.200.000</p>
                   <button class="add-to-cart-btn" data-product-id="5">Add to Cart</button> 
                   <br>
                   <a href="product_detail.php?product_id=5" class="btn btn-primary">View Details</a>
              </div>

              <div class="card">
              <span class="discount">-30%</span>
             <img src="Asset/3.jpg" alt="Avicenna La Femme (New) EDP 100 ml">
              <h3>Avicenna La Femme (New) EDP 100 ml</h3>
                 <p class="old-price">Rp 7.000.000</p>
               <p class="new-price">Rp 3.500.000</p>
                   <button class="add-to-cart-btn" data-product-id="6">Add to Cart</button> 
                   <br>
                   <a href="product_detail.php?product_id=6" class="btn btn-primary">View Details</a>
              </div>

              <div class="card">
              <span class="discount">-30%</span>
             <img src="Asset/6.jpg" alt="Avicenna Starburst EDP 100 ml">
              <h3>Avicenna Starburst EDP 100 ml</h3>
                 <p class="old-price">Rp 2.000.000</p>
               <p class="new-price">Rp 1.300.000</p>
                   <button class="add-to-cart-btn" data-product-id="7">Add to Cart</button> 
                   <br>
                   <a href="product_detail.php?product_id=7" class="btn btn-primary">View Details</a>
              </div>

            
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="cart.js"></script>

  <div class="unique-container">
    <h2 class="unique-section-title">Under 800k</h2>
    <div class="unique-carousel">
      <!-- Navigation Buttons -->
      <div class="unique-carousel-wrapper">
        <div class="unique-carousel-track">
          <!-- Card Items -->
          <div class="unique-card">
            <span class="unique-discount">-45%</span>
          <a href="product_detail.php?product_id=8" class="btn btn-primary"> gfgh<img src="Asset/1.jpg" alt="Abercrombie & Fitch Authentic Night" >
            <h3>Abercrombie & Fitch Authentic Night For Men 100ml EDP</h3>
            <p class="unique-description">A fragrance for the man who thrives on living life with unapologetic</p>
            <p class="unique-old-price">Rp 1.400.000</p>
            <p class="unique-new-price">Rp 770.000</p>
            </a>
          </div>

          <div class="unique-card">
            <span class="unique-discount">-35%</span>
          <a href="product_detail.php?product_id=9" class="btn btn-primary"> gfgh<img src="Asset/7.jpg" alt="" >
            <h3>Yves Saint Laurent Black Opium 90ml EDP</h3>
            <p class="unique-description">Perfume with a warm and exotic oriental scent</p>
            <p class="unique-old-price">Rp 1.000.000</p>
            <p class="unique-new-price">Rp 799.000</p>
            </a>
          </div>

          <div class="unique-card">
            <span class="unique-discount">-25%</span>
          <a href="product_detail.php?product_id=10" class="btn btn-primary"> gfgh<img src="Asset/8.jpg" alt="" >
            <h3>Tom Ford Oud Wood 50ml EDP</h3>
            <p class="unique-description">A woody fragrance with unique depth and masculinity</p>
            <p class="unique-old-price">Rp 2.000.000</p>
            <p class="unique-new-price">Rp 610.000</p>
            </a>
          </div>
          <div class="unique-card">
            <span class="unique-discount">-40%</span>
          <a href="product_detail.php?product_id=11" class="btn btn-primary"> gfgh<img src="Asset/9.jpg" alt="" >
            <h3>Dolce & Gabbana Light Blue 100ml EDT</h3>
            <p class="unique-description">A fresh, bright, and energetic fragrance</p>
            <p class="unique-old-price">Rp 1.110.000</p>
            <p class="unique-new-price">Rp 530.000</p>
            </a>
          </div>
          <div class="unique-card">
            <span class="unique-discount">-60%</span>
          <a href="product_detail.php?product_id=12" class="btn btn-primary"> gfgh<img src="Asset/10.jpg" alt="" >
            <h3>Chanel No.5 100ml EDP</h3>
            <p class="unique-description">A floral fragrance embodying elegance and femininity</p>
            <p class="unique-old-price">Rp 2.410.000</p>
            <p class="unique-new-price">Rp 545.000</p>
            </a>
          </div>
        </div>
      </div>
    </div>
    <button class="unique-view-all-btn" onclick="window.location.href='lihat_semua_under800k.php'">Lihat Semua</button>
  </div>

  <div class="unique-container">
    <h2 class="unique-section-title">New Arival</h2>
    <div class="unique-carousel">
      <div class="unique-carousel-wrapper">
        <div class="unique-carousel-track">

          <!-- Card Items -->
          <div class="unique-card">
            <span class="unique-discount">-45%</span>
          <a href="product_detail.php?product_id=13" class="btn btn-primary"> gfgh<img src="Asset/11.jpg" alt="Abercrombie & Fitch Authentic Night" >
            <h3>Dior Addict 100ml EDP</h3>
            <p class="unique-description">An oriental scent that radiates warmth and luxury</p>
            <p class="unique-old-price">Rp 4.400.000</p>
            <p class="unique-new-price">Rp 1.400.000</p>
            </a>
          </div>

          <div class="unique-card">
            <span class="unique-discount">-35%</span>
          <a href="product_detail.php?product_id=14" class="btn btn-primary"> gfgh<img src="Asset/12.jpg" alt="" >
            <h3>Gucci Guilty Pour Homme 90ml EDT</h3>
            <p class="unique-description">A woody fragrance with a bold and masculine character</p>
            <p class="unique-old-price">Rp 6.000.000</p>
            <p class="unique-new-price">Rp 1.100.000</p>
            </a>
          </div>

          <div class="unique-card">
            <span class="unique-discount">-25%</span>
          <a href="product_detail.php?product_id=15" class="btn btn-primary"> gfgh<img src="Asset/13.jpg" alt="" >
            <h3>Versace Dylan Blue 100ml EDT</h3>
            <p class="unique-description">A fresh fragrance with citrus and aquatic notes</p>
            <p class="unique-old-price">Rp 3.210.000</p>
            <p class="unique-new-price">Rp 980.000</p>
            </a>
          </div>

          <div class="unique-card">
            <span class="unique-discount">-40%</span>
          <a href="product_detail.php?product_id=16" class="btn btn-primary"> gfgh<img src="Asset/14.jpg" alt="" >
            <h3>Lancôme La Vie Est Belle 75ml EDP</h3>
            <p class="unique-description">A floral fragrance representing joy and beauty</p>
            <p class="unique-old-price">Rp 4.290.000</p>
            <p class="unique-new-price">Rp 1.300.000</p>
            </a>
          </div>

          <div class="unique-card">
            <span class="unique-discount">-60%</span>
          <a href="product_detail.php?product_id=17" class="btn btn-primary"> gfgh<img src="Asset/15.jpg" alt="" >
            <h3>Montblanc Explorer 100ml EDP</h3>
            <p class="unique-description">A woody fragrance for the modern adventurer</p>
            <p class="unique-old-price">Rp 1.110.000</p>
            <p class="unique-new-price">Rp 890.000</p>
            </a>
          </div> 
        </div>
      </div>
    </div>
    <button class="unique-view-all-btn" onclick="window.location.href='lihat_semua_newarival.php'">Lihat Semua</button>
  </div>


  <footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h4>About Us</h4>
            <p>Learn more about our story and the perfumes we offer.</p>
        </div>
        <div class="footer-section">
            <h4>Customer Service</h4>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Order Status</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Shipping Info</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Follow Us</h4>
            <ul>
                <li><a href="#"><i class="fa-brands fa-facebook"></i></a>
               <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-pinterest"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Aspiu Parfume. All rights reserved.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartTotalElement = document.querySelector('.cart-total table tr:last-child td:last-child');
    const cartSummaryElement = document.querySelector('#cartSummary');
    const searchInput = document.getElementById('searchInput');
    const productCards = document.querySelectorAll('.card, .unique-card');

    function formatToIDR(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
    }

    // Event untuk fitur pencarian
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            productCards.forEach(card => {
                const productNameElement = card.querySelector('h3');
                const productName = productNameElement ? productNameElement.textContent.toLowerCase() : '';
                card.style.display = productName.includes(query) ? '' : 'none';
            });
        });
    }
});
</script>

    </html>
