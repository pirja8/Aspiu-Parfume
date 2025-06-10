<?php
session_start();
require_once 'koneksi.php';

$is_logged_in = isset($_SESSION['name']);
if (!$is_logged_in) {
    header("Location: login.php");
    exit();
}

// Ambil data produk dari tabel `cart`
$cartItems = [];
try {
    $stmt = $koneksi->prepare("
        SELECT c.cart_id, c.product_id, c.quantity, p.name AS product_name, p.price AS product_price, p.image_url 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id
    ");
    $stmt->execute();
    $cartItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Proses POST: hapus massal dan checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hapus produk yang dipilih (massal)
    if (isset($_POST['delete_selected'])) {
        $selectedItems = $_POST['selected_items'] ?? [];
        if (!empty($selectedItems)) {
            // Siapkan placeholder dan tipe parameter untuk bind_param
            $placeholders = implode(',', array_fill(0, count($selectedItems), '?'));
            $types = str_repeat('i', count($selectedItems));
            try {
                $stmt = $koneksi->prepare("DELETE FROM cart WHERE cart_id IN ($placeholders)");
                // bind_param membutuhkan parameter by reference, jadi kita gunakan trik ini
                $stmt_params = [];
                $stmt_params[] = & $types;
                foreach ($selectedItems as $key => $value) {
                    $stmt_params[] = & $selectedItems[$key];
                }
                call_user_func_array([$stmt, 'bind_param'], $stmt_params);
                $stmt->execute();
                header("Location: keranjang.php");
                exit();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                exit();
            }
        } else {
            echo "<script>alert('Pilih minimal satu produk untuk dihapus.');</script>";
        }
    }

    // Proses checkout
    if (isset($_POST['checkout'])) {
        $selectedItems = $_POST['selected_items'] ?? [];
        if (!empty($selectedItems)) {
            header("Location: checkout.php?items=" . urlencode(json_encode($selectedItems)));
            exit();
        } else {
            echo "<script>alert('Pilih minimal satu produk untuk melanjutkan checkout.');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Keranjang Belanja</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="fontawesome-free-6.7.1-web/css/all.css" />
<style>
    .header { display: flex; justify-content: space-between; padding: 10px 20px; background-color: #9b59b6; color: white; }
    .cart-title { text-align: center; color: #9b59b6; font-size: 24px; margin-top: 20px; }
    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background-color: #f9f9f9; }
    .btn { padding: 10px 20px; background-color: #9b59b6; color: white; border: none; cursor: pointer; margin-right: 10px; }
    .btn:hover { background-color: #6b44a1; }
    .product-image { width: 50px; height: 50px; object-fit: cover; }
    .cart-total { text-align: right; padding: 10px 20px; font-weight: bold; }
    .cart-actions { padding: 10px 20px; text-align: left; }

</style>
</head>
<body>
<header class="header">
    <div class="logo"><a href="beranda.php" style="color: white; text-decoration: none;">Aspiu Parfume</a></div>
    <br />
    <div class="search-bar">
        <i class="fa-solid fa-magnifying-glass">
            <input type="text" id="search-input" placeholder="Search for products" />
        </i>
    </div>
    <div class="user-cart">
        <a href="akun.php">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</a>
        <a href="logout.php">Logout</a>
        <a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a>
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

<main>
    <h2 class="cart-title">RINGKASAN KERANJANG BELANJA</h2>
    <form action="keranjang.php" method="POST" onsubmit="return validateSelectedProducts();">
        <table>
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="cart-body">
                <?php foreach ($cartItems as $item): 
                    $subtotal = $item['product_price'] * $item['quantity']; 
                ?>
                <tr>
                    <td>
                        <input 
                            type="checkbox" 
                            class="select-product" 
                            name="selected_items[]" 
                            value="<?=$item['cart_id'];?>"
                            data-price="<?= $item['product_price']; ?>" 
                            data-quantity="<?= $item['quantity']; ?>" 
                            onchange="updateTotal();"
                        >
                    </td>
                    <td>
                        <img src="<?= $item['image_url']; ?>" alt="<?= $item['product_name']; ?>" width="100" class="product-image">
                    </td>
                    <td><?= $item['product_name']; ?></td>
                    <td>IDR <?= number_format($item['product_price'], 0, ',', '.'); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td class="product-subtotal">IDR <?= number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            <h3>Total: <span id="total-price">IDR 0</span></h3>
        </div>

        <div class="cart-actions">
            <button type="submit" class="btn" name="delete_selected" onclick="return confirmDeleteSelected();">Hapus</button>
            <button type="submit" class="btn" name="checkout">Lanjutkan Checkout</button>
        </div>
    </form>
</main>

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
                <li>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Aspiu Parfume. All rights reserved.</p>
    </div>
</footer>

<script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.select-product:checked').forEach(item => {
            const price = parseFloat(item.getAttribute('data-price'));
            const quantity = parseInt(item.getAttribute('data-quantity'));
            total += price * quantity;
        });
        document.getElementById('total-price').textContent = 'IDR ' + total.toLocaleString('id-ID');
    }

    function validateSelectedProducts() {
        const checkboxes = document.querySelectorAll('.select-product:checked');
        if (checkboxes.length === 0) {
            alert('Pilih minimal satu produk untuk melanjutkan.');
            return false;
        }
        return true;
    }

    function confirmDeleteSelected() {
        const checked = document.querySelectorAll('.select-product:checked');
        if (checked.length === 0) {
            alert('Pilih minimal satu produk untuk dihapus.');
            return false;
        }
        return confirm('Apakah yakin ingin menghapus produk yang dipilih dari keranjang?');
    }

    // Fungsi filter search bar
    document.getElementById('search-input').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#cart-body tr');

        rows.forEach(row => {
            // Ambil nama produk di kolom Deskripsi (index 2)
            const productName = row.cells[2].textContent.toLowerCase();
            if (productName.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        updateTotal();
    });
</script>


</body>
</html>
