<?php
session_start();
require_once 'koneksi.php';

$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data['cart_id'];

    if ($cart_id) {
        try {
            $stmt = $koneksi->prepare("DELETE FROM cart WHERE cart_id = ?");
            $stmt->bind_param("i", $cart_id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Produk berhasil dihapus dari keranjang.';
            } else {
                $response['message'] = 'Gagal menghapus produk dari keranjang.';
            }
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
