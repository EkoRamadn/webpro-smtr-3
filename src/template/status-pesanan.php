<?php
session_start();
require "../logic/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Pesanan tidak ditemukan ";
    exit;
}

$id_pesanan = (int) $_GET['id'];

$sql = "SELECT p.*, k.nama_lengkap AS nama_kurir 
        FROM pesanan p
        LEFT JOIN user k ON p.kurir_id = k.id 
        WHERE p.id = $id_pesanan";
$res = mysqli_query($_CONNEC, $sql);


if (!$res || mysqli_num_rows($res) === 0) {
    echo "pesanan tidak ditemukan ";
    exit;
}

$pesanan = mysqli_fetch_assoc($res);

$status_db = $pesanan['status_pesanan'];

$posisi = 0;

// Cek Status Database
if ($status_db == 'pending' || $status_db == 'Menunggu Pembayaran' || $status_db == 'Menunggu Konfirmasi') {
    $posisi = 0;
} elseif ($status_db == 'pay' || $status_db == 'Menunggu Verifikasi') {
    $posisi = 1;
} elseif ($status_db == 'procces' || $status_db == 'Dikemas') {
    $posisi = 2;
} elseif ($status_db == 'deliver' || $status_db == 'Dikirim') {
    $posisi = 3;
} elseif ($status_db == 'complete' || $status_db == 'Selesai') {
    $posisi = 4;
} elseif ($status_db == 'Dibatalkan') {
    $posisi = -1;
}

// Boolean
$pending = ($posisi >= 0);
$pay = ($posisi >= 1);
$procces = ($posisi >= 2);
$deliver = ($posisi >= 3);
$complete = ($posisi >= 4);
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
                    <div style="margin: 20px 0;">

                        <?php if ($pesanan['pembayaran'] == 'transfer' && $pesanan['status_pesanan'] == 'Menunggu Pembayaran'): ?>
                            <div
                                style="background: #fff3cd; border: 1px solid #ffeeba; padding: 15px; border-radius: 8px; color: #856404;">
                                <h3 style="margin-bottom: 8px;">Menunggu Pembayaran</h3>
                                <p style="margin-bottom: 10px;">Silakan transfer <strong>Rp
                                        <?= number_format($pesanan['total_pesanan'], 0, ',', '.') ?>
                                    </strong> ke rekening BCA 123-456-789.</p>

                                <form action="../logic/kirim_bukti.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>">
                                    <input type="file" name="bukti_foto" required accept="image/*"
                                        style="margin-bottom: 10px;">
                                    <br>
                                    <button type="submit"
                                        style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                                        Kirim Bukti Transfer
                                    </button>
                                </form>
                            </div>

                        <?php elseif ($pesanan['status_pesanan'] == 'Menunggu Verifikasi'): ?>
                            <div
                                style="background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 8px; color: #0c5460;">
                                <h4>Bukti Terkirim!</h4>
                                <p>Admin sedang memverifikasi pembayaranmu. Mohon tunggu sebentar.</p>
                            </div>

                        <?php elseif ($pesanan['status_pesanan'] == 'Menunggu Konfirmasi'): ?>
                            <div
                                style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; color: #155724;">
                                <h4>Pesanan COD Diterima</h4>
                                <p>Admin akan segera memproses pesananmu. Siapkan uang tunai saat kurir datang ya!</p>
                            </div>

                        <?php endif; ?>

                    </div>
                    <?php if ($pesanan['status_pesanan'] == 'Dikirim' || $pesanan['status_pesanan'] == 'Selesai'): ?>
                        <div
                            style="background: #f8f9fa; border: 1px solid #e9ecef; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                            <h3 style="margin-bottom: 10px; color: #343a40; font-size: 16px;">Info Pengiriman</h3>

                            <div style="font-size: 14px; color: #495057;">
                                <span style="color: #868e96;">Nama Kurir:</span> <br>
                                <span style="text-transform: capitalize; font-weight: 600; font-size: 15px;">
                                    <?= !empty($pesanan['nama_kurir']) ? $pesanan['nama_kurir'] : 'Sedang menuju lokasi...' ?>
                                </span>
                            </div>

                            <?php if ($pesanan['status_pesanan'] == 'Selesai' && !empty($pesanan['bukti_pengiriman'])): ?>
                                <div style="margin-top: 15px; border-top: 1px dashed #ced4da; padding-top: 10px;">
                                    <span style="display:block; color: #868e96; font-size: 13px; margin-bottom: 8px;">Bukti
                                        Paket Diterima:</span>

                                    <a href="/public/img/bukti_kirim/<?= $pesanan['bukti_pengiriman'] ?>" target="_blank">
                                        <img src="/public/img/bukti_kirim/<?= $pesanan['bukti_pengiriman'] ?>" alt="Bukti Paket"
                                            style="width: 100%; max-width: 100%; border-radius: 8px; border: 1px solid #dee2e6;">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="step-container">
                        <div class="container-step">
                            <!-- <a target="_blank" href="https://www.youtube.com/watch?v=WW6fEuheuas">
                                <h1 class="text-center">Step Progress Bar (Video)</h1>
                            </a> -->
                            <div id="stepProgressBar">
                                <div class="step">
                                    <div class="bullet  <?= ($pending) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/pending.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Menuggu</p>
                                </div>
                                <div class="step">
                                    <div class="bullet  <?= ($pending && $pay) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/pay.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Pembayaran</p>
                                </div>
                                <div class="step">
                                    <div class="bullet  <?= ($pending && $pay && $procces) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/package-proces.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Diproses</p>
                                </div>
                                <div class="step">
                                    <div
                                        class="bullet  <?= ($pending && $pay && $procces && $deliver) ? "completed" : "" ?>">
                                        <div class="icon">
                                            <img src="../../public/icon/package-send.png" alt="">
                                        </div>
                                    </div>
                                    <p class="step-text">Dikirim</p>
                                </div>
                                <div class="step">
                                    <div
                                        class="bullet  <?= ($pending && $pay && $procces && $deliver && $complete) ? "completed" : "" ?>">
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