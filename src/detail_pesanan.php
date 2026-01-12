<?php
require "./logic/koneksi.php";

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ./login.php");
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./beranda.php");
    exit;
}

$id_pesanan = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id_pesanan)) {
    header("Location: data_pesanan.php");
    exit;
}

$query_detail = mysqli_query($_CONNEC, "SELECT * FROM pesanan WHERE id = '$id_pesanan'");
$data = mysqli_fetch_assoc($query_detail);

$query_produk = mysqli_query($_CONNEC, "SELECT * FROM pesanan_produk WHERE pesanan_id = '$id_pesanan'");

if (!$data) {
    echo "Pesanan tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Pesanan #<?php echo $data['no_pesanan'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./style/dashboard.css" />
    <style>
        .detail-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .card-box {
            background-color: #151419;
            border: 1px solid #27272a;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .header-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-item span:first-child {
            display: block;
            color: #a1a1aa;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .info-item span:last-child {
            display: block;
            color: white;
            font-weight: 500;
        }

        .img-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px dashed #3f3f3f;
            cursor: zoom-in;
            transition: 0.2s;
        }

        @media (max-width: 1024px) {
            .detail-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title">
                <img class="icon" src="../public/icon/material-symbols--menu.png">
                <p class="title_header">Detail Pesanan</p>
            </div>
            <div class="frame_button">
                <a href="beranda.php">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--store.png">
                        <p class="button_text" style="white-space: nowrap;">Kunjungi Toko</p>
                    </div>
                </a>
                <a href="./logic/logout.php">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--logout.png">
                        <p class="button_text">Logout</p>
                    </div>
                </a>
            </div>
        </div>

        <hr style="width: 100%; color: #3f3f3f" />

        <div class="frame_tengah">
            <div class="sidebar">
                <a href="dashboard.php">
                    <div class="sidebar_menu"><img class="icon" src="../public/icon/material-symbols--dashboard.png">
                        <p class="button_text">Dashboard</p>
                    </div>
                </a>
                <a href="data_produk.php">
                    <div class="sidebar_menu"><img class="icon" src="../public/icon/gridicons--product.png">
                        <p class="button_text">Data Produk</p>
                    </div>
                </a>
                <a href="data_pesanan.php">
                    <div class="sidebar_menu_active"><img class="icon" src="../public/icon/lets-icons--order.png">
                        <p class="button_text">Data Pesanan</p>
                    </div>
                </a>
            </div>

            <div class="content">

                <?php
                $status_sekarang = $data['status_pesanan'];

                if ($status_sekarang == 'pending'):
                    ?>
                    <div class="card-box" style="text-align: center; padding: 60px;">
                        <img src="../public/icon/mingcute--warning-line.png"
                            style="width: 60px; filter: invert(1); opacity: 0.8; margin-bottom: 15px;">
                        <h3 style="margin: 0; font-size: 24px; color:white;">Pesanan Masuk</h3>
                        <p style="color: #a1a1aa; margin-top: 5px; margin-bottom: 30px;">
                            #<?= $data['no_pesanan'] ?> • Rp <?= number_format($data['total_pesanan'], 0, ',', '.') ?>
                        </p>

                        <div style="display: flex; gap: 15px; justify-content: center;">
                            <form action="logic/update_status_pesanan.php" method="POST">
                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                <input type="hidden" name="status_baru" value="Dibatalkan">
                                <button type="submit" class="btn-cancel" style="border-color: #f87171; color: #f87171;"
                                    onclick="return confirm('Yakin tolak pesanan?')">Tolak</button>
                            </form>
                            <form action="logic/update_status_pesanan.php" method="POST">
                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                <input type="hidden" name="status_baru" value="pay">
                                <button type="submit" class="btn-save">Terima Pesanan</button>
                            </form>
                        </div>
                    </div>

                <?php else:
                    $status_db = $data['status_pesanan'];

                    $current_index = 0;

                    if ($status_db == 'Menunggu Verifikasi' || $status_db == 'Menunggu Konfirmasi' || $status_db == 'pay') {
                        $current_index = 0;
                    } elseif ($status_db == 'Dikemas' || $status_db == 'procces') {
                        $current_index = 1;
                    } elseif ($status_db == 'Dikirim' || $status_db == 'deliver') {
                        $current_index = 2;
                    } elseif ($status_db == 'Selesai' || $status_db == 'complete') {
                        $current_index = 3;
                    }

                    $label_admin = ['Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai'];
                    ?>

                    <div class="detail-container">

                        <div class="left-column">

                            <div class="header-detail">
                                <div>
                                    <h2 style="color:white; font-size: 24px; margin:0;">#<?= $data['no_pesanan'] ?></h2>
                                    <span style="color:#a1a1aa; font-size:13px;">
                                        <?= date('d F Y, H:i', strtotime($data['created_at'])) ?> WIB
                                    </span>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size:13px; color:#a1a1aa;">Total Tagihan</span>
                                    <h2 style="font-size: 24px; margin:0; color:#4ade80;">
                                        Rp <?= number_format($data['total_pesanan'], 0, ',', '.') ?>
                                    </h2>
                                </div>
                            </div>

                            <div class="card-box">
                                <h4
                                    style="color:white; margin-bottom: 20px; border-bottom: 1px solid #27272a; padding-bottom: 10px;">
                                    Status Pesanan</h4>

                                <div class="stepper-wrapper">
                                    <?php
                                    $total_step = 3;
                                    $progress_width = ($current_index / $total_step) * 100;
                                    ?>

                                    <div class="progress-line" style="width: <?= $progress_width ?>%;"></div>

                                    <?php foreach ($label_admin as $key => $label): ?>
                                        <div class="stepper-item <?= $key <= $current_index ? 'active' : '' ?>">
                                            <div class="step-counter">
                                                <?= $key + 1 ?>
                                            </div>
                                            <div class="step-name"><?= $label ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="card-box">
                                <h4
                                    style="color:white; margin-bottom: 20px; border-bottom: 1px solid #27272a; padding-bottom: 10px;">
                                    Informasi Pengiriman</h4>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span>Nama Penerima</span>
                                        <span style="text-transform: capitalize;"><?php echo $data['nama'] ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span>Nomor HP</span>
                                        <span><?php echo $data['no_hp'] ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span>Metode Pembayaran</span>
                                        <span>
                                            <?php
                                            if ($data['pembayaran'] == 'cod') {
                                                echo 'Bayar Ditempat (COD)';
                                            } else {
                                                echo ucfirst($data['pembayaran']);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="info-item" style="grid-column: span 2;">
                                        <span>Alamat Lengkap</span>
                                        <span style="text-transform: capitalize;"><?php echo $data['alamat'] ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span>Kurir Pengiriman</span>
                                        <span style="text-transform: capitalize;">
                                            <?php
                                            if (!empty($data['nama_kurir'])) {
                                                echo $data['nama_kurir'];
                                            } else {
                                                echo '<span>Belum Ada</span>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-box">

                                <div class="rounded-border">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th style="text-align: center;">Jumlah Item</th>
                                                <th style="text-align: right;">Harga Satuan</th>
                                                <th style="text-align: right;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($prod = mysqli_fetch_assoc($query_produk)): ?>
                                                <tr>
                                                    <td>
                                                        <div style="font-weight: 500;"><?= $prod['produk_nama'] ?></div>
                                                    </td>
                                                    <td style="text-align: center; color: #a1a1aa;">
                                                        x<?= $prod['total_produk'] ?></td>
                                                    <td style="text-align: right; color:#a1a1aa;">
                                                        Rp <?= number_format($prod['produk_harga'], 0, ',', '.') ?>
                                                    </td>
                                                    <td style="text-align: right; color: #4ade80;">
                                                        Rp <?= number_format($prod['total_harga'], 0, ',', '.') ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                        <div class="right-column">

                            <div class="card-box">
                                <h4 style="color:white; margin-bottom: 15px;">Bukti Pembayaran</h4>

                                <?php if (!empty($data['bukti_pembayaran'])): ?>
                                    <a href="../public/img/bukti_bayar/<?= $data['bukti_pembayaran'] ?>" target="_blank">
                                        <img src="../public/img/bukti_bayar/<?= $data['bukti_pembayaran'] ?>"
                                            class="img-preview" title="Klik untuk memperbesar">
                                    </a>
                                <?php elseif ($data['pembayaran'] == 'transfer'): ?>
                                    <div
                                        style="padding: 20px; text-align: center; border: 1px dashed #ef4444; border-radius: 8px;">
                                        <p style="color: #ef4444; font-size:13px;">Belum ada bukti upload</p>
                                    </div>
                                <?php else: ?>
                                    <div
                                        style="padding: 20px; text-align: center; border: 1px dashed #a1a1aa; border-radius: 8px;">
                                        <p style="color: #a1a1aa; font-size:13px;">Pembayaran COD</p>
                                    </div>
                                <?php endif; ?>

                                <div style="margin-top: 24px; border-top: 1px solid #27272a; padding-top: 20px;">
                                    <?php if ($status_sekarang != 'complete' && $status_sekarang != 'Dibatalkan'): ?>

                                        <?php if ($status_sekarang == 'Menunggu Verifikasi'): ?>
                                            <form action="logic/update_status_pesanan.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                                <input type="hidden" name="status_baru" value="Dikemas">
                                                <button type="submit" class="btn-actions"
                                                    style="color: black; width: 100%; justify-content: center">
                                                    Konfirmasi & Packing
                                                </button>
                                            </form>
                                        <?php elseif ($status_sekarang == 'Menunggu Konfirmasi'): ?>
                                            <form action="logic/update_status_pesanan.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                                <input type="hidden" name="status_baru" value="Dikemas">
                                                <button type="submit" class="btn-save" style="width:100%; justify-content: center;">
                                                    Terima Order COD
                                                </button>
                                            </form>
                                        <?php elseif ($status_sekarang == 'Dikemas'): ?>
                                            <form action="logic/update_status_pesanan.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                                <input type="hidden" name="status_baru" value="Dikirim">
                                                <button type="submit" class="btn-save" style="width:100%; justify-content: center;">
                                                    Kirim Barang
                                                </button>
                                            </form>
                                        <?php elseif ($status_sekarang == 'Dikirim'): ?>
                                            <button class="btn-actions"
                                                style="width:100%; background: #27272a; color: #a1a1aa; cursor: default; justify-content: center;"
                                                disabled>
                                                Menunggu Kurir
                                            </button>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <button class="btn-save"
                                            style="width:100%; background: #27272a; color: #4ade80; cursor: default; border:none; justify-content: center;"
                                            disabled>
                                            <?= $status_sekarang == 'complete' ? '&#10003; Selesai' : 'Dibatalkan' ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-box" style="margin-top: 24px;">
                                <h4 style="color:white; margin-bottom: 15px;">Bukti Pengiriman Kurir</h4>

                                <?php if ($status_sekarang == 'complete' || $status_sekarang == 'Selesai'): ?>

                                    <?php if (!empty($data['bukti_pengiriman'])): ?>
                                        <a href="../public/img/bukti_kirim/<?= $data['bukti_pengiriman'] ?>" target="_blank">
                                            <img src="../public/img/bukti_kirim/<?= $data['bukti_pengiriman'] ?>"
                                                class="img-preview" title="Klik untuk memperbesar"
                                                style="border: 1px dashed #52525b">
                                        </a>
                                    <?php else: ?>
                                        <div
                                            style="padding: 20px; text-align: center; border: 1px dashed #52525b; border-radius: 8px;">
                                            <p style="color: #a1a1aa; font-size: 12px;">Tidak ada foto bukti</p>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <div
                                        style="padding: 30px 20px; text-align: center; border: 1px dashed #27272a; border-radius: 8px; background: #18181b;">
                                        <img src="../public/icon/mdi--courier-fast.png"
                                            style="width: 32px; opacity: 0.2; margin-bottom: 10px">
                                        <p style="color: #52525b; font-size: 13px;">
                                            Menunggu kurir menyelesaikan pengiriman
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</body>

</html>