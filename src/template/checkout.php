<?php
session_start();
require "../logic/getUserData.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
}
$userData = mysqli_fetch_assoc($resuser);
$keranjang_id = $_POST['id'] ?? "";
$total_harga = $_POST['total_harga_dikeranjang'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../style/checkoput.css">
</head>

<body>
    <div class="container">
        <header class="navigation">
            <div class="logo">
                <div class="left">
                    <img src="../../public/logo.png" alt="">
                </div>
                <div class="right">
                    <h1>UMKM<span class="clr-primary">.Batik</span></h1>
                </div>
            </div>
            <nav>
                <form action="">
                    <ul>
                        <li><a href="../beranda.php">Kembali</a></li>
                        <?php
                        if (isset($_SESSION['login'])) { ?>
                            <li>
                                <a href="../template/peringatan.php?tipe=peringatan&pesan=Apakah+anda+yakin+ingin+keluar?&kembali=../beranda.php&lanjut=../logic/logout.php"
                                    class="active" id="logout">
                                    Log Out
                                </a>
                            </li>
                        <?php } else { ?>
                            <li><a href="../login.php" class="active" id="logout" id="login">Log In</a></li>

                        <?php } ?>
                    </ul>
                </form>
            </nav>
        </header>
        <main>
            <div class="top">
                <h1 class="title">Checkout Keranjang</h1>
            </div>
            <form action="../logic/addpesanan.php" class="content-checkout" method="POST">
                <table>
                    <tr class="head-form">
                        <th colspan="3">
                            <h2>Data Pengirim</h2>
                        </th>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td colspan="2">
                            : <input type="text" name="fullname" value="<?= $userData['nama_lengkap'] ?>"
                                placeholder="Nama Lengkap">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Alamat
                        </th>
                        <td colspan="2">
                            : <input type="text" name="addres" value="<?= $userData['alamat'] ?>" placeholder="Alamat">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            No. HP
                        </th>
                        <td colspan="2">
                            : <input type="number" name="no_hp" value="<?= $userData['no_hp'] ?>" placeholder="0855..">
                        </td>
                    </tr>
                    <tr class="head-form">
                        <th colspan="3">
                            <h2>Metode Pembayaran</h2>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 20px;">
                            <select name="metode" required
                                style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px;">
                                <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                                <option value="transfer">Transfer Bank (BCA/Mandiri)</option>
                                <option value="cod">COD (Bayar Ditempat)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="btm-tbl">
                            <p>Total: Rp. <?= number_format($total_harga, 0, ',', '.') ?></p>
                        </td>
                    </tr>
                </table>
                <input hidden name="total_pesanan" value="<?= $total_harga ?>" type="number">
                <input hidden name="id" value="<?= $keranjang_id ?>" type="number">
                <div class="flex">
                    <button type="submit">Buat Pesanan</button>
                </div>
            </form>
        </main>
        <footer>
            <div class="left">
                <div class="logo">
                    <div class="icon">
                        <img src="../public/logo.png" alt="">
                    </div>
                    <div class="desc">
                        <h2>UMKM Batik Indonesia</h2>
                        <p class="sub">
                            Melestarikan Warisan Budaya Indonesia Melalui Karya Batik Berkualitas dan Penuh Makna
                        </p>
                    </div>
                </div>

            </div>
            <div class="right">
                <h3>Navigasi</h3>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">Produk</a></li>
                    <li><a href="">Tentang Kami</a></li>
                </ul>
            </div>
            <div class="end">
                <h3>Creator</h3>
                <ul>
                    <li><a href="">Handika Rado Arganata</a></li>
                    <li><a href="">Cahyo Saputra</a></li>
                    <li><a href="">Dimas Akbar Maulana</a></li>
                    <li><a href="">Eko Ramadani</a></li>
                </ul>
            </div>
        </footer>
    </div>
    <?php if ($MODE === 'dev') { ?>
        <div class="mode-dev" id="mode-dev">
            <span>Development</span>
        </div>
    <?php } ?>
</body>

</html>