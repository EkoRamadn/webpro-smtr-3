<?php
session_start();
require "./logic/getpesanan.php";

if (!isset($_SESSION['login'])) {
    header("Location: ./login.php");
}

$status = $_GET['status'] ?? "";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="./style/pesanan.css">
</head>

<body>
    <div class="container">
        <header class="navigation">
            <div class="logo">
                <div class="left">
                    <img src="../public/logo.png" alt="">
                </div>
                <div class="right">
                    <h1>UMKM<span class="clr-primary">.Batik</span></h1>
                </div>
            </div>
            <nav>
                <form action="">
                    <ul>
                        <li><a href="./beranda.php">Kembali</a></li>
                        <?php if (isset($_SESSION['login'])) { ?>

                            <li>
                                <a href="./template/peringatan.php?tipe=peringatan&pesan=Apakah+anda+yakin+ingin+keluar?&kembali=../beranda.php&lanjut=../logic/logout.php"
                                    class="active" id="logout">
                                    Log Out
                                </a>
                            </li>

                        <?php } else { ?>

                            <li><a href="./login.php" class="active" id="logout" id="login">Log In</a></li>

                        <?php } ?>
                    </ul>
                </form>
            </nav>
        </header>
        <main>
            <div class="head">
                <h1>
                    Pesanan List
                </h1>
            </div>
            <div class="content-pesanan">
                <ul>
                    <li class="head"><a href="">
                            <div class="ctn">
                                <div class="left">
                                    <span>
                                        No. Pesanan
                                    </span>
                                </div>
                                <div class="center">
                                    <span>
                                        Status
                                    </span>
                                </div>
                                <div class="right">
                                    <span>
                                        Harga
                                    </span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php while ($row = mysqli_fetch_assoc($respesanan)) { ?>
                        <li>
                            <a href="./template/status-pesanan.php?id=<?= (int) $row['id'] ?>">
                                <div class="ctn">
                                    <div class="left">
                                        <span>
                                            <?= htmlspecialchars($row['no_pesanan']) ?>
                                        </span>
                                    </div>
                                    <div class="center">
                                        <span class="status-pesanan">
                                            <?= htmlspecialchars($row['status_pesanan']) ?>
                                        </span>
                                    </div>
                                    <div class="right">
                                        <span>
                                            Rp <?= number_format($row['total_pesanan'], 0, ',', '.') ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
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