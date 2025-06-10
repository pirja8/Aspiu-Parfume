<?php
session_start();
require_once 'koneksi.php';

// Menangkap parameter product_id dari URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

// Validasi agar product_id ada
if (!$product_id) {
    die("Product ID tidak ditemukan.");
}

// Query untuk mengambil data produk
$query = "SELECT name, price, description, image_url FROM products WHERE product_id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produk tidak ditemukan.");
}

$product = $result->fetch_assoc();

// Proses jika tombol Add to Cart dan Buy Now ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['quantity'] ?? 1;
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        if (isset($_POST['add_to_cart'])) {
            // Masukkan item ke dalam cart
            $cart_id = $user_id; // Anggap cart_id sama dengan user_id
            $stmt = $koneksi->prepare("INSERT INTO cart (cart_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
            if ($stmt->execute()) {
                header("Location: keranjang.php");
                exit();
            } else {
                echo "Gagal menambahkan produk ke keranjang.";
            }
        }

        if (isset($_POST['buy_now'])) {
            $_SESSION['checkout'] = [
                'product_id' => $product_id,
                'quantity' => $quantity,
            ];
            header("Location: checkout.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome-free-6.7.1-web/css/all.css">
    <style>
        .header { display: flex; justify-content: space-between; padding: 10px 20px; background-color: #9b59b6; color: white; }
        .logo { font-size: 24px; font-weight: bold; }
        .logo a { text-decoration: none; color: white; }
        .footer { background-color: #9b59b6; color: white; padding: 20px; text-align: center; }
        .footer-content { display: flex; justify-content: space-around; flex-wrap: wrap; }
        .footer-section { margin: 10px; }
        .footer-section h4 { font-size: 18px; margin-bottom: 10px; }
        .footer-section p, .footer-section ul { font-size: 14px; }
        .footer-section ul { list-style-type: none; padding: 0; }
        .footer-section ul li { margin: 5px 0; }
        .footer-section a { color: white; text-decoration: none; }
        .footer-section a:hover { text-decoration: underline; }
        .footer-bottom { margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
<header class="header">
    <div class="logo"><a href="beranda.php">Aspiu Parfume</a></div>
</header>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid p-3">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                            <p class="text-muted text-decoration-line-through">Rp799,000</p>
                            <p class="fw-bold fs-4 text-danger">Rp<?= number_format($product['price'], 0, ',', '.'); ?></p>
                            <p class="text-muted"><?= htmlspecialchars($product['description']); ?></p>

                            <!-- Form dengan pengecekan user login via JavaScript -->
                            <form method="POST" id="productForm" data-user-id="<?= $_SESSION['user_id'] ?? '' ?>">
                                <div class="d-flex align-items-center mb-3">
                                    <label for="quantity" class="me-3">Quantity</label>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="decrease">-</button>
                                    <input type="number" name="quantity" id="quantity" class="form-control form-control-sm mx-2" value="1" min="1" style="width: 60px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="increase">+</button>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary flex-fill" type="submit" name="add_to_cart">Add to Cart</button>
                                    <button class="btn btn-success flex-fill" type="submit" name="buy_now">Buy Now</button>
                                </div>
                            </form>

                            <p class="mt-3 text-muted"><i class="bi bi-truck"></i> Enjoy Free Shipping</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quantityInput = document.getElementById("quantity");
        const decreaseButton = document.getElementById("decrease");
        const increaseButton = document.getElementById("increase");
        const form = document.getElementById("productForm");
        const userId = form.dataset.userId;

        decreaseButton.addEventListener("click", function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        increaseButton.addEventListener("click", function () {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        form.addEventListener("submit", function (event) {
            if (!userId) {
                event.preventDefault();
                alert("Anda harus login terlebih dahulu.");
            }
        });
    });
</script>
</body>
</html>
