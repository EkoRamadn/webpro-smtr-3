<?php
session_start();
require "./logic/product.php";

$status = $_GET['status'] ?? "";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="./style/beranda.css">
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
                        <li><a href="./beranda.php" class="active">Home</a></li>
                        <li><a href="./produk.php">Produk</a></li>
                        <li><a href="./tentang-kami.php">Tentang Kami</a></li>
                        <li><a href="./keranjang.php">Keranjang</a></li>
                        <?php
                        if (isset($_SESSION['login'])) { ?>

                            <li>
                                <a href="./template/peringatan.php?tipe=peringatan&pesan=Apakah+anda+yakin+ingin+keluar?&kembali=../beranda.php&lanjut=../logic/logout.php"
                                    class="active" id="logout">
                                    Log Out
                                </a>
                            </li>

                        <?php } else { ?>

                            <li><a href="./login.html" class="active" id="logout" id="login">Log In</a></li>

                        <?php } ?>
                    </ul>
                </form>
            </nav>
        </header>
        <?php
        if ($status === 'berhasil') {
            echo '<p class="notif-sukses">Berhasil: Produk Ditambahkan.</p>';
        } elseif ($status === 'gagal') {
            echo '<p class="notif-gagal">Gagal: Produk Gagal Ditambahkan</p>';
        }
        ?>
        <main>
            <div class="thumbnail">
                <h1 class="title">Selamat Datang Di UMKM Batik </h1>
                <p class="subtitle">Kami memproduksi batik berkualitas dengan mengutamakan keaslian motif, nilai budaya,
                    dan pemberdayaan pengrajin lokal.</p>
                <a class="go-buy">
                    <div class="icon">
                        <img src="../public/icon/cart.png" alt="cart">
                    </div>
                    <span>
                        Mulai Belanja
                    </span>
                </a>
            </div>
            <div class="product">

                <div class="container-card">
                    <?php
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <div class="product-card">
                            <img src="<?= $row["gambar"] ?>" alt="Produk" class="product-img">

                            <div class="product-info">
                                <div class="left">
                                    <h4 class="product-name"><?= $row["nama"] ?></h4>
                                    <p class="product-price">Rp <?= number_format($row["harga"], 0, ',', '.') ?></p>
                                </div>
                                <div class="right">
                                    <a href="./template/produk-detail.php?id=<?= $row['id'] ?>" class="icon">
                                        <img src="../public/icon/arr-visit.png" alt="">
                                    </a>
                                    <form action="./logic/addkeranjang.php" method="POST">
                                        <input hidden type="number" name="produk_id" id="produk_id"
                                            value="<?= $row['id'] ?>" />
                                        <input hidden type="text" name="oks" value="../beranda.php">
                                        <input hidden type="number" name="total_produk" id="total_produk" value="1" />
                                        <button href="" class="icon">
                                            <img src="../public/icon/cart2.png" alt="">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
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
                    <li><a href="">Rado Arganata</a></li>
                    <li><a href="">Cahyo</a></li>
                    <li><a href="">Dimas Surga</a></li>
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