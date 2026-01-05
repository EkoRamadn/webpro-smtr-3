<?php
session_start();
require "./logic/koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <link rel="stylesheet" href="./style/tentang-kami.css">
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
                        <li><a href="./produk.php">Produk</a></li>
                        <li><a href="./tentang-kami.php" class="active">Tentang Kami</a></li>
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
        <main>
            <div class="thumbnail">
                <div class="left">

                    <h1 class="title">Tentang UMKM<span class="clr-primary">.Batik</span></h1>
                    <p class="subtitle">UMKM Batik merupakan usaha lokal yang menghadirkan batik khas
                        Nusantara
                        dengan mengutamakan kualitas dan nilai budaya. Setiap produk dibuat oleh pengrajin lokal dengan
                        penuh ketelatenan, menggabungkan tradisi dan sentuhan modern. Kami berkomitmen melestarikan
                        batik
                        sekaligus mendukung perekonomian pengrajin Indonesia.</p>
                </div>
                <div class="right">
                    <div class="logo">
                        <img src="../public/logo.png" alt="">
                    </div>
                </div>
                <!-- <img src="../public/img/thumb.jpg" alt="thumbnail"> -->
            </div>
            <div class="grub">
                <h2 class="title">Anggota Kelompok</h2>
                <div class="container-grub">
                    <ul>
                        <li>
                            <div class="anggota">
                                <div class="top">
                                    <img src="../public/img/team/cahyo.webp" alt="">
                                </div>
                                <div class="btm">
                                    <table>
                                        <tr>
                                            <th>Nama</th>
                                            <td>: Cahyo </td>
                                        </tr>
                                        <tr>
                                            <th>Nis</th>
                                            <td>: 24104410087</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: Bence, Garum</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="anggota">
                                <div class="top">
                                    <img src="../public/img/team/arga.webp" alt="">
                                </div>
                                <div class="btm">
                                    <table>
                                        <tr>
                                            <th>Nama</th>
                                            <td>: Rado Arganata</td>
                                        </tr>
                                        <tr>
                                            <th>Nis</th>
                                            <td>: 24104410087</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: Bence, Garum</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="anggota">
                                <div class="top">
                                    <img src="../public/img/team/dimas.webp" alt="">
                                </div>
                                <div class="btm">
                                    <table>
                                        <tr>
                                            <th>Nama</th>
                                            <td>: Dimas </td>
                                        </tr>
                                        <tr>
                                            <th>Nis</th>
                                            <td>: 24104410087</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: Bence, Garum</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="anggota">
                                <div class="top">
                                    <img src="../public/img/team/eko.webp" alt="">
                                </div>
                                <div class="btm">
                                    <table>
                                        <tr>
                                            <th>Nama</th>
                                            <td>: Eko Ramadani</td>
                                        </tr>
                                        <tr>
                                            <th>Nis</th>
                                            <td>: 24104410087</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: Bence, Garum</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>
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
    <?php } else {
        echo "";
    } ?>
</body>

</html>