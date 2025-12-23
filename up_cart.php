<?php
require "koneksi.php";
$total_pesanan_baru = $_POST["total_pesanan"];
$id = $_POST["pesanan_id"];
$pesanan_lama = $_POST["pesanan_lama"];
$harga_lama = $_POST["harga_lama"];

$harga_baru = ($harga_lama / $pesanan_lama) * $total_pesanan_baru;

$update = mysqli_query($connect, "UPDATE pesanan SET total_pesanan=$total_pesanan_baru,total_harga=$harga_baru WHERE id=$id");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .alert {
            background: #fff;
            padding: 30px 40px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
            text-align: center;
            width: 360px;
        }

        .alert.success {
            border-top: 6px solid #2247A1;
        }

        .alert.error {
            border-top: 6px solid #ef4444;
        }

        .alert h2 {
            margin-bottom: 10px;
        }

        .alert.success h2 {
            color: #2247A1;
        }

        .alert.error h2 {
            color: #dc2626;
        }

        .alert p {
            color: #4b5563;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: 600;
        }

        .btn.success {
            background: #2247A1;
        }

        .btn.error {
            background: #ef4444;
        }

        .btn:hover {
            opacity: .9;
        }
    </style>
</head>

<body>

    <?php if ($update): ?>
        <div class="alert success">
            <h2>Berhasil</h2>
            <p>Pesanam berhasil diupdate dari keranjang.</p>
            <a href="./HALAMAN-10.php" class="btn success">Kembali ke Stok Batik</a>
        </div>
    <?php else: ?>
        <div class="alert error">
            <h2>Gagal</h2>
            <p>Terjadi kesalahan saat megupdate pesanan.</p>
            <a href="./HALAMAN-10.php" class="btn error">Coba Lagi</a>
        </div>
    <?php endif; ?>

</body>

</html>