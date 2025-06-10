<?php
session_start();
require_once 'koneksi.php';

// Cek apakah pengguna sudah login
$is_logged_in = isset($_SESSION['name']); // Periksa apakah sesi 'name' ada

// Cek apakah pengguna sudah login dengan user_id
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari tabel users
$query = "SELECT name, email, phone, Alamat FROM users WHERE user_id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Pastikan ada data pengguna yang ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// Inisialisasi variabel untuk total harga dan berat
$totalHarga = 0;
$totalBerat = 0;
$cartItems = [];

// Periksa apakah ini checkout dari cart atau Buy Now
if (isset($_SESSION['checkout'])) {
    // **Buy Now** logic
    $checkout_data = $_SESSION['checkout'];
    $product_id = $checkout_data['product_id'];
    $quantity = $checkout_data['quantity'];

    // Query produk berdasarkan product_id
    $query = "SELECT name, price, weight, image_url FROM products WHERE product_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Produk tidak ditemukan.");
    }

    $product = $result->fetch_assoc();

    // Hitung total harga dan berat untuk Buy Now
    $totalHarga = $product['price'] * $quantity;
    $totalBerat = $product['weight'] * $quantity;

    // Simpan ke array cartItems agar bisa digunakan di tampilan
    $cartItems[] = [
        'product_id' => $product_id,
        'product_name' => $product['name'],
        'product_price' => $product['price'],
        'weight' => $product['weight'],
        'image_url' => $product['image_url'],
        'quantity' => $quantity,
    ];

} else if (isset($_GET['items'])) {
    // **Cart Checkout** logic
    $selected_items = json_decode(urldecode($_GET['items']), true);

    if (!is_array($selected_items) || empty($selected_items)) {
        echo "Data yang diterima tidak valid.";
        exit();
    }

    // Buat placeholder '?' sesuai jumlah item yang dipilih
    $placeholders = implode(',', array_fill(0, count($selected_items), '?'));
    $query = "SELECT c.cart_id, c.product_id, c.quantity, p.name AS product_name, p.price AS product_price, p.weight, p.image_url 
              FROM cart c 
              JOIN products p ON c.product_id = p.product_id 
              WHERE c.cart_id IN ($placeholders)";
    
    $stmt = $koneksi->prepare($query);

    // Bind parameter
    $params = [];
    $types = '';
    foreach ($selected_items as $item) {
        if (is_numeric($item)) {
            $types .= 'i';
            $params[] = $item;
        } else {
            echo "Data item tidak valid.";
            exit();
        }
    }
    array_unshift($params, $types); // Tambahkan tipe data di awal
    $stmt->bind_param(...$params);

    $stmt->execute();
    $cartItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Hitung total harga dan berat untuk item di cart
    foreach ($cartItems as $item) {
        $totalHarga += $item['product_price'] * $item['quantity'];
        $totalBerat += $item['weight'] * $item['quantity'];
    }
}

// Simpan total harga ke session untuk digunakan di langkah selanjutnya
$_SESSION['total_harga'] = $totalHarga;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="fontawesome-free-6.7.1-web/css/all.css">
    <style>
        /* Kode CSS untuk membuat tampilan sesuai dengan gambar */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #9b59b6;
            color: #fff;
            padding: 1rem;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .user-cart {
            display: flex;
            align-items: center;
        }
        .user-cart a {
            color: #fff;
            text-decoration: none;
        }
        .checkout-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .billing-shipping,
        .order-summary,
        .payment-method {
            background-color: #f5f5f5;
            padding: 1rem;
            border-radius: 5px;
        }
        .address-box {
            background-color: #fff;
            padding: 1rem;
            border-radius: 5px;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-table th,
        .order-table td {
            padding: 0. 5rem;
            border-bottom: 1px solid #ddd;
        }
        .product-image {
            max-width: 80px;
        }
        .shipping-options,
        .payment-options {
            list-style-type: none;
            padding: 0;
        }
        .shipping-options li,
        .payment-options li {
            margin-bottom: 0.5rem;
        }
        .place-order-btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
        }
        .footer {
            background-color: #9b59b6;
            color: #fff;
            padding: 2rem 1rem;
            text-align: center;
        }
        .footer-content {
            display: flex;
            justify-content: space-between;
            max-width: 800px;
            margin: 0 auto;
        }
        .footer-section {
            flex: 1;
            margin: 0 1rem;
        }
        .footer-section h4 {
            margin-bottom: 0.5rem;
        }
        .footer-section ul {
            list-style-type: none;
            padding: 0;
        }
        .footer-section a {
            color: #fff;
            text-decoration: none;
        }
        .footer-bottom {
            margin-top: 2rem;
        }
    </style>
</head>
<body>
<header class="header">
    <div class="logo"><a href="beranda.php">Aspiu Parfume</a></div>
    <div class="user-cart">
        <?php if ($is_logged_in): ?>
                <a href="akun.php">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Sign-in</a>
            <?php endif; ?>
            <a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
</header>
<main>
    <div class="checkout-container">
        <div class="billing-shipping">
            <h3>Alamat Pengiriman</h3>
            <br>
            <div class="address-box">
                <p><strong><?php echo htmlspecialchars($user['name']); ?></strong><br>
                <?php echo htmlspecialchars($user['phone']); ?><br>
                <?php echo htmlspecialchars($user['Alamat']); ?></p>
            </div>
            <input type="checkbox" id="dropship" name="shipping_method">
            <label for="dropship">Kirim Sebagai Dropshipper</label>
        </div>
        <br>
        <br>
        <div class="order-summary">
            <h3>Produk Dipesan</h3>
            <br>
            <table class="order-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cartItems as $item) {
                        $image_url = $item['image_url'];
                        $product_name = $item['product_name'];
                        $product_price = $item['product_price'];
                        $quantity = $item['quantity'];
                        $subtotal = $product_price * $quantity;
                        echo "
                        <tr>
                            <td>
                                <img src='$image_url' alt='$product_name' class='product-image'>
                            </td>
                            <td>
                                <div>$product_name</div>
                            </td>
                            <td>
                                <div>{$quantity} pcs</div>
                            </td>
                            <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <table>
            
            <tfoot>
                <tr> <td>Shipping</td></tr>
                        <tr>
                            <td>
                                <ul class="shipping-options">
                                    <li><input type="radio" name="shipping" value="10000" onclick="updateTotal()"> JNE REG 1-3 hari - Rp 10,000</li>
                                    <li><input type="radio" name="shipping" value="18000" onclick="updateTotal()"> JNE YES 1 hari - Rp 18,000</li>
                                    <li><input type="radio" name="shipping" value="15000" onclick="updateTotal()"> SICEPAT REGULAR - Rp 15,000</li>
                                    <li><input type="radio" name="shipping" value="20000" onclick="updateTotal()"> SICEPAT BEST 1 hari - Rp 20,000</li>
                                    <li><input type="checkbox" name="insurance" value="5000" onclick="updateTotal()"> Tambahkan Asuransi - Rp 5,000</li>
                                </ul>
                            </td>
                        </tr>
    
                        <tr>
                             <td>Total</td>
                        </tr>
                        <tr>
                           <strong><td id="totalPrice">Rp <?php echo number_format($totalHarga + 0, 0, ',', '.'); ?></td></strong> 
                        </tr>
                    </tfoot>
            </table>
    </div>
    <br>
    <div class="payment-method">
        <h3>Pilih Metode Pembayaran</h3>
        <form action="place_order.php" method="POST">
    <?php foreach ($cartItems as $item): ?>
        <input type="hidden" name="cart_items[]" value='<?php echo json_encode($item); ?>'>
    <?php endforeach; ?>
    <input type="hidden" name="total_harga" value="<?php echo $totalHarga; ?>">
    <input type="hidden" name="shipping" id="hiddenShipping" value="0">
    <input type="hidden" name="insurance" id="hiddenInsurance" value="0">
    <ul class="payment-options">
                <li><input type="radio" name="payment_method" value="bni"> Bank Transfer - BNI</li>
                <li><input type="radio" name="payment_method" value="bri"> Bank Transfer - BRI</li>
                <li><input type="radio" name="payment_method" value="bca"> Bank Transfer - BCA</li>
                <li><input type="radio" name="payment_method" value="mandiri"> Bank Transfer - Mandiri</li>
            </ul>
    <button type="submit" class="place-order-btn">Tempatkan Pesanan</button>
</form>
    </div>
</main>

<script>
// Fungsi untuk mengupdate harga total setelah memilih pengiriman atau asuransi
function updateTotal() {
    var shippingCost = 0;
    var insuranceCost = 0;

    // Ambil harga pengiriman yang dipilih
    var shippingOptions = document.getElementsByName('shipping');
    for (var i = 0; i < shippingOptions.length; i++) {
        if (shippingOptions[i].checked) {
            shippingCost = parseInt(shippingOptions[i].value);
            break;
        }
    }

    // Cek apakah asuransi dipilih
    var insuranceCheckbox = document.getElementsByName('insurance')[0];
    if (insuranceCheckbox.checked) {
        insuranceCost = parseInt(insuranceCheckbox.value);
    }

    // Total harga produk
    var totalHarga = <?php echo $totalHarga; ?>;

    // Update harga total
    var total = totalHarga + shippingCost + insuranceCost;
    document.getElementById('totalPrice').innerHTML = "Rp " + total.toLocaleString();
}

     function updateHiddenInputs() {
        var shippingCost = 0;
        var insuranceCost = 0;

        // Ambil harga pengiriman yang dipilih
        var shippingOptions = document.getElementsByName('shipping');
        for (var i = 0; i < shippingOptions.length; i++) {
            if (shippingOptions[i].checked) {
                shippingCost = parseInt(shippingOptions[i].value);
                break;
            }
        }

        // Cek apakah asuransi dipilih
        var insuranceCheckbox = document.getElementsByName('insurance')[0];
        if (insuranceCheckbox.checked) {
            insuranceCost = parseInt(insuranceCheckbox.value);
        }

        // Update hidden fields
        document.getElementById('hiddenShipping').value = shippingCost;
        document.getElementById('hiddenInsurance').value = insuranceCost;
    }

    // Attach updateHiddenInputs to relevant events
    document.querySelectorAll('input[name="shipping"], input[name="insurance"]').forEach(function (element) {
        element.addEventListener('change', updateHiddenInputs);
    });
</script>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h4>Tentang Kami</h4>
            <p>Pelajari lebih lanjut tentang cerita kami dan parfum yang kami tawarkan.</p>
        </div>
        <div class="footer-section">
            <h4>Layanan Pelanggan</h4>
            <ul>
                <li><a href="#">Hubungi Kami</a></li>
                <li><a href="#">Status Pesanan</a></li>
                <li><a href="#">Pengembalian</a></li>
                <li><a href="#">Info Pengiriman</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Ikuti Kami</h4>
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Pinterest</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Aspiu Parfume. Semua hak dilindungi.</p>
    </div>
</footer>
</body>
</html>