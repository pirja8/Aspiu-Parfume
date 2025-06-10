<?php
require_once 'koneksi.php';

$id_transaksi = $_GET['id_transaksi'] ?? null;

if (!$id_transaksi) {
    echo "ID transaksi tidak ditemukan.";
    exit();
}

$query = "SELECT t.*, u.name, u.phone, u.Alamat 
          FROM transaksi t
          JOIN users u ON t.user_id = u.user_id
          WHERE t.id_transaksi = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$transaksi = $stmt->get_result()->fetch_assoc();

if (!$transaksi) {
    echo "Data transaksi tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .nota-container { margin: 20px auto; max-width: 600px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .nota-header { text-align: center; margin-bottom: 20px; }
        .nota-header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <h2>Nota Transaksi</h2>
            <p>INV/<?php echo date("Ymd", strtotime($transaksi['tanggal_transaksi'])); ?>/<?php echo $transaksi['id_transaksi']; ?></p>
        </div>

        <div>
            <h3>Detail Pembeli</h3>
            <p><strong><?php echo htmlspecialchars($transaksi['name']); ?></strong></p>
            <p><?php echo htmlspecialchars($transaksi['phone']); ?></p>
            <p><?php echo htmlspecialchars($transaksi['Alamat']); ?></p>
        </div>

        <div>
            <h3>Detail Transaksi</h3>
            <table>
                <tr>
                    <th>Tanggal</th>
                    <td><?php echo date("d-m-Y H:i", strtotime($transaksi['tanggal_transaksi'])); ?></td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td><?php echo htmlspecialchars($transaksi['metode_pembayaran']); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($transaksi['status_transaksi']); ?></td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td class="total">Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>