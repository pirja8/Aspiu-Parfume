<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "Anda harus login terlebih dahulu.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $metode_pembayaran = $_POST['payment_method'] ?? null;
    $shipping_cost = $_POST['shipping'] ?? 0;
    $insurance_cost = $_POST['insurance'] ?? 0;
    $total_harga = $_SESSION['total_harga'] + $shipping_cost + $insurance_cost;

    if (!$metode_pembayaran) {
        echo "Pilih metode pembayaran.";
        exit();
    }

    $tanggal_transaksi = date('Y-m-d H:i:s');
    $status_transaksi = "Menunggu Pembayaran"; // Default status

    // Simpan transaksi
    $query = "INSERT INTO transaksi (user_id, tanggal_transaksi, total_harga, status_transaksi, metode_pembayaran) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("isdss", $user_id, $tanggal_transaksi, $total_harga, $status_transaksi, $metode_pembayaran);

    if ($stmt->execute()) {
        $id_transaksi = $stmt->insert_id;

        // Masukkan item ke tabel detail transaksi (opsional jika diperlukan)
        if (isset($_SESSION['cart_items'])) {
            foreach ($_SESSION['cart_items'] as $item) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];

                $detail_query = "INSERT INTO transaksi_detail (id_transaksi, product_id, quantity) VALUES (?, ?, ?)";
                $detail_stmt = $koneksi->prepare($detail_query);
                $detail_stmt->bind_param("iii", $id_transaksi, $product_id, $quantity);
                $detail_stmt->execute();
            }
        }

        echo "Transaksi berhasil disimpan. ID Transaksi Anda: " . $id_transaksi;
        // Redirect ke halaman sukses
        header("Location: nota.php?id_transaksi=$id_transaksi");
        exit();
    } else {
        echo "Gagal menyimpan transaksi.";
    }
}
