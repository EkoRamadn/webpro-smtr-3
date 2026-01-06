<?php
session_start();
require "./logic/product.php";
require "./logic/getkategori.php";

if (!isset($_SESSION['login'])) {
    header("Location: ./login.php");
}

$kategori = $_GET['kategori'] ?? "0";
$found = false;
$search = strtolower(str_replace(' ', '', $_GET['src'] ?? ""));

$status = $_GET['status'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="./style/produk.css">
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
                        <li><a href="./beranda.php">Home</a></li>
                        <li><a href="./produk.php" class="active">Produk</a></li>
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
                            <li><a href="./login.php" class="active" id="logout" id="login">Log In</a></li>
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
            <div class="left">
                <div class="kategory">
                    <a href="?kategori=0">
                        <h3>Kategori</h3>
                    </a>
                    <?php while ($row = mysqli_fetch_assoc($kategorires)) { ?>
                        <ul>
                            <li><a href="?kategori=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
            <div class="right">
                <div class="top">
                    <h2 class="title">Produk List</h2>
                    <form action="#" method="GET">
                        <input type="text" placeholder="Search" name="src">
                        <button type="submit">Cari</button>
                    </form>
                </div>
                <div class="btm">
                    <div class="product">
                        <div class="container-card">
                            <?php
                            while ($row = mysqli_fetch_assoc($res)) {
                                $clrname = strtolower(str_replace(' ', '', $row['nama']));
                                $matchKategori = ($kategori == '0' || $kategori == $row['kategori_id']);
                                $matchSearch = ($search === "" || strpos($clrname, $search) !== false);
                                if ($matchKategori && $matchSearch) {
                                    $found = true;
                                    ?>
                                    <div class="product-card">
                                        <img src="<?= $row['gambar']; ?>" alt="Produk" class="product-img">

                                        <div class="product-info">
                                            <div class="left">
                                                <h4 class="product-name"><?= $row['nama']; ?></h4>
                                                <p class="product-price">
                                                    Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                                </p>
                                            </div>
                                            <div class="right">
                                                <a href="./template/produk-detail.php?id=<?= $row['id']; ?>" class="icon">
                                                    <img src="../public/icon/arr-visit.png" alt="">
                                                </a>
                                                <form action="./logic/addkeranjang.php" method="POST">
                                                    <input hidden type="number" name="produk_id" id="produk_id"
                                                        value="<?= $row['id'] ?>" />
                                                    <input hidden type="text" name="oks" value="../produk.php">
                                                    <input hidden type="number" name="total_produk" id="total_produk"
                                                        value="1" />
                                                    <button href="" class="icon">
                                                        <img src="../public/icon/cart2.png" alt="">
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            if (!$found) {
                                echo "<p>Produk tidak ditemukan </p>";
                            }
                            ?>

                        </div>
                    </div>
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