<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Login Terlebih Dahulu."]);
    exit;
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "parfume";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$koneksi) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'] ?? null;
$quantity = $data['quantity'] ?? 1;

if (!isset($product_id) || !is_numeric($product_id) || $quantity <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

// Cek produk dan stok
$query_product = "SELECT stock, price FROM products WHERE product_id = ?";
$stmt_product = mysqli_prepare($koneksi, $query_product);
mysqli_stmt_bind_param($stmt_product, "i", $product_id);
mysqli_stmt_execute($stmt_product);
$result_product = mysqli_stmt_get_result($stmt_product);

if (mysqli_num_rows($result_product) === 0) {
    echo json_encode(["success" => false, "message" => "Product not found"]);
    exit;
}

$product = mysqli_fetch_assoc($result_product);
if ($product['stock'] < $quantity) {
    echo json_encode(["success" => false, "message" => "Insufficient stock"]);
    exit;
}

// Kurangi stok
$new_stock = $product['stock'] - $quantity;
$stmt_update_stock = mysqli_prepare($koneksi, "UPDATE products SET stock = ? WHERE product_id = ?");
mysqli_stmt_bind_param($stmt_update_stock, "ii", $new_stock, $product_id);
mysqli_stmt_execute($stmt_update_stock);

// Cek apakah produk sudah ada di keranjang, jika ya update quantity
$user_id = $_SESSION['user_id'];
$query_check_cart = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt_check_cart = mysqli_prepare($koneksi, $query_check_cart);
mysqli_stmt_bind_param($stmt_check_cart, "ii", $user_id, $product_id);
mysqli_stmt_execute($stmt_check_cart);
$result_check_cart = mysqli_stmt_get_result($stmt_check_cart);

if (mysqli_num_rows($result_check_cart) > 0) {
    $row = mysqli_fetch_assoc($result_check_cart);
    $new_quantity = $row['quantity'] + $quantity;
    $stmt_update_cart = mysqli_prepare($koneksi, "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    mysqli_stmt_bind_param($stmt_update_cart, "iii", $new_quantity, $user_id, $product_id);
    mysqli_stmt_execute($stmt_update_cart);
} else {
    $stmt_cart = mysqli_prepare($koneksi, "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt_cart, "iii", $user_id, $product_id, $quantity);
    mysqli_stmt_execute($stmt_cart);
}

// Hitung total keranjang
$total_items = 0;
$total_price = 0;
$query_total = "SELECT c.quantity, p.price FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?";
$stmt_total = mysqli_prepare($koneksi, $query_total);
mysqli_stmt_bind_param($stmt_total, "i", $user_id);
mysqli_stmt_execute($stmt_total);
$result_total = mysqli_stmt_get_result($stmt_total);

while ($row = mysqli_fetch_assoc($result_total)) {
    $total_items += $row['quantity'];
    $total_price += $row['quantity'] * $row['price'];
}

echo json_encode([
    'success' => true,
    'message' => 'Produk berhasil ditambahkan ke keranjang',
    'cart_count' => $total_items,
    'total_price' => $total_price
]);

mysqli_close($koneksi);
?>
