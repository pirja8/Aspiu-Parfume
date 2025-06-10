<?php
session_start();
include('koneksi.php');
$is_logged_in = isset($_SESSION['name']);

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $remember = isset($_POST['remember']); // Menangkap opsi "Ingat Saya"

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];

            // Set cookie jika "Ingat Saya" diaktifkan
            if ($remember) {
                setcookie('email', $email, time() + (86400 * 30), "/"); // Cookie selama 30 hari
            }

            header('Location: beranda.php');
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aspiu Parfume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #ffffff;">
<header class="header">
<div class="logo"><a href="beranda.php">Aspiu Parfume</a></div>
        <div class="user-cart">
                <a href="login.php">Sign-in</a>
                <a href="keranjang.php">Cart</a>
            </div>
        </div>
    </header>

    <div class="container mt-5 d-flex justify-content-center" style="background-color: #ffffff;">
        <div class="card shadow" style="width: 24rem; background-color: #ffffff;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>

                <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
                <p class="text-center mt-3">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>    

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
