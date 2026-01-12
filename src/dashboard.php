<?php
require "./logic/koneksi.php";

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ./login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./beranda.php");
    exit;
}

$admin_id = $_SESSION['user_id'] ?? 0;
$nama_admin = "Admin";

if ($admin_id != 0) {
    $query_admin = mysqli_query($_CONNEC, "SELECT nama_lengkap FROM user WHERE id = '$admin_id'");
    if ($row_admin = mysqli_fetch_assoc($query_admin)) {
        $nama_admin = $row_admin['nama_lengkap'];
    }
}

$query_pemasukan = mysqli_query($_CONNEC, "SELECT SUM(total_pesanan) as total FROM pesanan WHERE status_pesanan = 'Selesai'");
$data_pemasukan = mysqli_fetch_assoc($query_pemasukan);
$total_pemasukan = $data_pemasukan['total'];

if ($total_pemasukan == null) {
    $total_pemasukan = 0;
}

$query_pending = mysqli_query($_CONNEC, "SELECT COUNT(*) as total FROM pesanan WHERE status_pesanan IN ('Menunggu Pembayaran', 'Menunggu Verifikasi', 'Menunggu Konfirmasi', 'Dikemas', 'Dikirim')");
$data_pending = mysqli_fetch_assoc($query_pending);
$total_pending = $data_pending['total'];

$query_stok = mysqli_query($_CONNEC, "SELECT COUNT(*) as total FROM produk WHERE stok <= 10");
$data_stok = mysqli_fetch_assoc($query_stok);
$jumlah_stok_tipis = $data_stok['total'];

$query_produk = mysqli_query($_CONNEC, "SELECT COUNT(*) as total FROM produk");
$data_produk = mysqli_fetch_assoc($query_produk);
$total_produk = $data_produk['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="./style/dashboard.css" />
</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title">
                <img class="icon" src="../public/icon/material-symbols--menu.png" alt="icon_menu" />
                <p class="title_header">Dashboard</p>
            </div>
            <div class="frame_button">
                <a href="./beranda.php">
                    <div class="button_header">
                        <img class="icon" src="../public/icon/material-symbols--store.png" alt="icon_store" />
                        <p class="button_text" style="white-space: nowrap;">Kunjungi Toko</p>
                    </div>
                </a>
                <a href="./logic/logout.php">
                    <div class="button_header">
                        <img class="icon" src="../public/icon/material-symbols--logout.png" alt="icon_logout" />
                        <p class="button_text">Logout</p>
                    </div>
                </a>
            </div>
        </div>

        <hr style="width: 100%; color: #3f3f3f" />

        <div class="frame_tengah">
            <div class="sidebar">
                <a href="index.php">
                    <div class="sidebar_menu_active">
                        <img class="icon" src="../public/icon/material-symbols--dashboard.png" alt="icon_dashboard" />
                        <p class="button_text">Dashboard</p>
                    </div>
                </a>
                <a href="data_produk.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="../public/icon/gridicons--product.png" alt="icon_data_produk" />
                        <p class="button_text">Data Produk</p>
                    </div>
                </a>
                <a href="data_pesanan.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="../public/icon/lets-icons--order.png" alt="icon_data_pesanan" />
                        <p class="button_text">Data Pesanan</p>
                    </div>
                </a>
            </div>
            <div class="content">
                <div class="banner-container">
                    <div class="banner-text">
                        <h1 style="text-transform: capitalize;">Selamat Datang,
                            <?php echo htmlspecialchars($nama_admin); ?>!
                        </h1>
                        <p>Pantau performa penjualan batikmu hari ini. Kelola pesanan masuk, cek konfirmasi pembayaran,
                            dan pastikan stok produk unggulan selalu tersedia untuk pelanggan.</p>
                    </div>
                    <img src="/banner.jpg" alt="Banner Dashboard">
                </div>
                <div class="frame_card">
                    <div class="card">
                        <p class="button_text">Total Pemasukan</p>
                        <img src="../public/icon/tdesign--money.png" alt="" style="width: 80px; height: 80px" />
                        <p>Rp <?php echo number_format($total_pemasukan, 0, ',', '.') ?></p>
                    </div>
                    <div class="card">
                        <p>Pesanan Perlu Diproses</p>
                        <img src="../public/icon/material-symbols--pending-actions.png" alt="icon_total_pesanan"
                            style="width: 80px; height: 80px" />
                        <p><?php echo $total_pending ?> Pesanan</p>
                    </div>
                    <div class="card">
                        <p class="button_text">Stok Menipis</p>
                        <img src="../public/icon/mingcute--warning-line.png" alt="icon_stok_menipis"
                            style="width: 80px; height: 80px" />
                        <p>
                            <?php echo $jumlah_stok_tipis ?> Item
                        </p>
                    </div>
                    <div class="card">
                        <p class="button_text">Total Produk</p>
                        <img src="../public/icon/gridicons--product.png" alt="icon_total_produk"
                            style="width: 80px; height: 80px" />
                        <p>
                            <?php echo $total_produk ?> Item
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>