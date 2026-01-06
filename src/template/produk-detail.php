<?php
session_start();
require "../logic/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Produk tidak ditemukan ";
    exit;
}

$id_produk = (int) $_GET['id'];

$sql = "SELECT id,nama,harga,gambar,deskripsi,stok FROM produk WHERE id=$id_produk";
$res = mysqli_query($_CONNEC, $sql);


if (!$res || mysqli_num_rows($res) === 0) {
    echo "Produk tidak ditemukan ";
    exit;
}

$produk = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="../style/produk-detail.css">
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
                        <li><a href="../keranjang.php">Keranjang</a></li>
                        <!-- <li><a href="./beranda.html">Kembali</a></li> -->
                        <?php
                        if (isset($_SESSION['login'])) { ?>

                            <li>
                                <a href="../template/peringatan.php?tipe=peringatan&pesan=Apakah+anda+yakin+ingin+keluar?&kembali=../beranda.php&lanjut=../logic/logout.php"
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
            <div class="left">
                <div class="img-produk">
                    <img src="<?= $produk['gambar'] ?>" alt="">
                </div>
            </div>
            <div class="right">
                <div class="dtl">
                    <div class="grub-dtl">
                        <h3 class="nama"><?= $produk['nama'] ?></h3>
                        <p class="harga">Rp.
                            <?= number_format($produk["harga"], 0, ',', '.') ?>
                        </p>
                    </div>
                    <div class="grub-dtl">
                        <h3 class="dsc">Deskripsi</h3>
                        <p class="dsc-dtl"><?= $produk['deskripsi'] ?></p>
                    </div>

                    <div class="ent">
                        <form action="../logic/addkeranjang.php" method="POST">
                            <input type="number" name="" hidden id="">
                            <div class="grub-input">
                                <input hidden type="number" name="produk_id" id="produk_id"
                                    value="<?= $produk['id'] ?>" />
                                <label for="total-barang">Total: </label>
                                <input value="1" maxlength="99" type="number" name="total_produk" id="total_produk">
                            </div>
                            <button type="submit">Tambah Keranjang</button>
                        </form>
                    </div>
                    <div class="btn-kembali">
                        <a href="../beranda.php">Kembali</a>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="left">
                <div class="logo">
                    <div class="icon">
                        <img src="../../public/logo.png" alt="">
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