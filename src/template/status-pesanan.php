<?php
session_start();
require "../logic/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Pesanan tidak ditemukan ";
    exit;
}

$id_pesanan = (int) $_GET['id'];
// echo $id_pesanan;

$sql = "SELECT id,no_pesanan,user_id,total_pesanan,status_pesanan,pembayaran,alamat,nama,no_hp,created_at FROM pesanan WHERE id=$id_pesanan";
$res = mysqli_query($_CONNEC, $sql);


if (!$res || mysqli_num_rows($res) === 0) {
    echo "pesanan tidak ditemukan ";
    exit;
}

$pesanan = mysqli_fetch_assoc($res);


$st = $pesanan['status_pesanan'];
$statuses = ['pendding', 'pay', 'procces', 'deliver', 'complate'];

$pendding = false;
$pay = false;
$procces = false;
$deliver = false;
$complate = false;

$index = array_search($st, $statuses);

if ($index !== false) {
    $pendding = $index >= 0;
    $pay = $index >= 1;
    $procces = $index >= 2;
    $deliver = $index >= 3;
    $complate = $index >= 4;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="../style/status-pesanan.css">
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
            <div class="head">
                <h1>Status</h1>
            </div>
            <div class="content-status">
                <div class="top">
                    <h2> <span class="bold">No. Pesanan</span>: <?= $pesanan['no_pesanan'] ?></h2>
                    <span><span class="bold">Tanggal:</span>
                        <?= date('d-m-Y', strtotime($pesanan['created_at'])) ?></span>
                </div>
                <div class="bottom">
                    <span class="bold">Total: <span class="gren">
                            Rp
                            <?= number_format($pesanan['total_pesanan'], 0, ',', '.') ?></span></span>
                    <div class="step-container">
                        <div class="container-step">
                            <!-- <a target="_blank" href="https://www.youtube.com/watch?v=WW6fEuheuas">
                                <h1 class="text-center">Step Progress Bar (Video)</h1>
                            </a> -->
                            <div id="stepProgressBar">
                                <div class="step">
                                    <div class="bullet  <?= ($pendding) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/pendding.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Menuggu</p>
                                </div>
                                <div class="step">
                                    <div class="bullet  <?= ($pendding && $pay) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/pay.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Pembayaran</p>
                                </div>
                                <div class="step">
                                    <div class="bullet  <?= ($pendding && $pay && $procces) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/package-proces.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Diproses</p>
                                </div>
                                <div class="step">
                                    <div
                                        class="bullet  <?= ($pendding && $pay && $procces && $deliver) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/package-send.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Dikirim</p>
                                </div>
                                <div class="step">
                                    <div
                                        class="bullet  <?= ($pendding && $pay && $procces && $deliver && $complate) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/package-rearchive.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Selesai</p>
                                </div>
                            </div>

                        </div>
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