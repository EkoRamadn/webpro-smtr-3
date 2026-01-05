<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ./login.php");
}
require "./logic/getkeranjang.php";


$total_harga_dikeranjang = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="stylesheet" href="./style/keranjang.css">
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
        <main>
            <div class="content-keranjang">

                <table>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($res)) {
                        $subtotal = $row["harga"] * $row['total_produk'];
                        $total_harga_dikeranjang += $subtotal;
                        ?>
                        <tr>
                            <td class="prod">
                                <div class="left">
                                    <img src="<?= $row['gambar'] ?>" alt="">
                                </div>
                                <div class="right">
                                    <h3><?= $row["nama"] ?></h3>
                                </div>
                            </td>
                            <td>
                                <p>Rp. <?= number_format($row["harga"], 0, ',', '.') ?></p>
                            </td>
                            <td>
                                <p>
                                    <?= $row['total_produk'] ?>
                                </p>
                            </td>
                            <td>Rp. <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4">
                            <p>Total: Rp. <?= number_format($total_harga_dikeranjang, 0, ',', '.') ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="btn-grub">
                <a href="./beranda.php">Lanjut Belanja</a>
                <button>Checkout</button>
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