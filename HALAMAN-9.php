<?php
require 'koneksi.php';

$res = mysqli_query($connect, 'SELECT * FROM produk');
if (!$res) {
    die(mysqli_error($connect));
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Batik</title>
    <link rel="stylesheet" href="./global.css">
</head>

<body>
    <div class="container">
        <div class=" navigation">
            <div class="link">
                <a href="HALAMAN-1.html">Beranda</a>
                <a href="HALAMAN-2.html">Profil Kelompok</a>
                <a href="HALAMAN-3.html">Contoh UMKM</a>
                <a href="HALAMAN-4.html">Batik</a>
                <a href="HALAMAN-5.html">Kontak</a>
                <a href="HALAMAN-6.html">Berita</a>
                <a href="./HALAMAN-7.html">Galeri</a>
                <a href="./HALAMAN-8.html">Data UMKM terdaftar</a>
                <a href="./HALAMAN-9.html" class="active">Stok Batik</a>
            </div>

            <a href="./HALAMAN-10.php">
                <button class="icon cart-buy">
                    <img src="./images/icon/uil--cart.svg" alt="buy-cart">
                </button>
            </a>
        </div>


        <div class="main hl8 stok">
            <div class="btnadd">

                <a type="submit" class="btn-add-produk" href="./HALAMAN-11.php">
                    <div class="icon" style="width: 20px;height: 20px;">
                        <img src="./images/icon/ic--round-plus.svg" alt="plus" width="100%" height="100%">
                    </div>
                    <span>Tambah Produk</span>
                </a>
            </div>
            <div class="top">
                <h1 class="title">
                    Mulai Belanja Batik Favorite Anda
                </h1>
                <p>Temukan beragam koleksi batik favorit dengan desain autentik, kualitas terbaik, dan nyaman dikenakan
                    untuk berbagai acara.</p>
            </div>
            <div class="stock-content">
                <?php
                while ($row = mysqli_fetch_assoc($res)) {

                    $id = $row['id'];
                    $nama = htmlspecialchars($row['nama']);
                    $harga = number_format($row['harga'], 0, ',', '.');
                    $gambar = $row['gambar'];
                    $kota = htmlspecialchars($row['toko']);
                    $rating = $row['rate'];
                    ?>
                    <div class="card stok">
                        <div class="top" style="width: 100%; height: 100px; overflow:hidden;">
                            <img src="<?= $gambar ?>" alt="<?= $nama ?>" width="100%">
                        </div>

                        <div class="body">
                            <span style="font-size:14px;display:block;margin-bottom:8px;">
                                <?= $nama ?>
                            </span>

                            <h1>Rp<?= $harga ?></h1>

                            <div class="shrt-info">
                                <div class="rate">
                                    <div class="icon">
                                        <img src="./images/icon/iconamoon--star-fill.svg" alt="star rate" width="100%"
                                            height="100%">
                                    </div>
                                    <span><?= $rating ?>.0 - 100rb Terjual</span>
                                </div>

                                <div class="shop">
                                    <span><?= $kota ?></span>
                                </div>
                            </div>

                            <div class="btn-grub">

                                <?php
                                $q = mysqli_query($connect, "SELECT 1 FROM pesanan WHERE id_produk = $id LIMIT 1");
                                $ada = mysqli_num_rows($q);
                                ?>

                                <?php if ($ada): ?>
                                    <form action="add_cart.php" method="POST">
                                        <input type="hidden" name="produk_id" value="<?= $id ?>">
                                        <input type="hidden" name="harga" value="<?= $harga ?>">
                                        <button class="btn-add-cart" disabled style="opacity:0.6;cursor:not-allowed;">
                                            Remove Cart
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="add_cart.php" method="POST">
                                        <input type="hidden" name="produk_id" value="<?= $id ?>">
                                        <input type="hidden" name="harga" value="<?= $row['harga'] ?>">
                                        <button class="btn-add-cart" type="submit">
                                            <div class="icon">
                                                <img src="./images/icon/ic--round-plus.svg" alt="add cart">
                                            </div>
                                            <span>Add Cart</span>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</body>

</html>