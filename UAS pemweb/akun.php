<?php
session_start();
include('koneksi.php');
$is_logged_in = isset($_SESSION['name']);


// Ambil data user berdasarkan sesi login
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $phone = mysqli_real_escape_string($koneksi, $_POST['phone']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];
    $Alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $update_query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', password = '$password', Alamat= '$Alamat' WHERE user_id = '$user_id'";
    if (mysqli_query($koneksi, $update_query)) {
        $_SESSION['name'] = $name; // Update nama di sesi
        $success_message = "Data berhasil diperbarui!";
    } else {
        $error_message = "Gagal memperbarui data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.7.1-web/css/all.css">
</head>
<body style="background-color : white">
<header class="header">
        <div class="logo"><a href="beranda.php">Aspiu Parfume</a></div>
        <div class="search-bar">
            <input type="text" placeholder="Search for products">
        </div>
        <div class="user-cart">
        <?php if ($is_logged_in): ?>
                <a href="akun.php">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Sign-in</a>
            <?php endif; ?>
                <a href="keranjang.php">Cart</a>
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
<div class="container mt-5" style="background-color : white">
    <div class="card shadow" style="width: 24rem; background-color: #ffffff;">
        <div class="card-body">
            <h2 class="mb-4 text-center">Informasi Akun</h2>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
</div>
        <form method="POST" action="">
            <!-- Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>

            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

             <!-- Alamat -->
             <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $user['Alamat']; ?>"required>
            </div>


            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>
