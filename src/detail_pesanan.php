<?php
require "./logic/koneksi.php";

$id_pesanan = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id_pesanan)) {
    header("Location: data_pesanan.php");
    exit;
}

$query_detail = mysqli_query($_CONNEC, "SELECT * FROM pesanan WHERE id = '$id_pesanan'");
$data = mysqli_fetch_assoc($query_detail);

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
    <title>Detail Pesanan #
        <?= $data['no_pesanan'] ?>
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./style/dashboard.css" />
</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title">
                <img class="icon" src="../public/icon/material-symbols--menu.png">
                <p class="title_header">Dashboard</p>
            </div>
            <div class="frame_button">
                <a href="#">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--store.png">
                        <p class="button_text">Store</p>
                    </div>
                </a>
                <a href="index.php">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--logout.png">
                        <p class="button_text">Logout</p>
                    </div>
                </a>
            </div>
        </div>

        <hr style="width: 100%; color: #3f3f3f" />

        <div class="frame_tengah">
            <div class="sidebar">
                <a href="index.php">
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

                if ($status_sekarang == 'Menunggu Pembayaran'):
                    ?>

                    <div
                        style="background-color: #151419; border: 1px solid #3f3f3f; border-radius: 12px; padding: 40px; color: white;">

                        <div style="text-align: center; margin-bottom: 40px;">
                            <img src="../public/icon/mingcute--warning-line.png"
                                style="width: 60px; filter: invert(1); opacity: 0.8; margin-bottom: 15px;">
                            <h3 style="margin: 0; font-size: 20px;">Pesanan Masuk Perlu Konfirmasi</h3>
                            <p style="color: #a1a1aa; margin-top: 5px;">Pastikan pembayaran sudah diterima sebelum
                                memproses.</p>
                        </div>

                        <div
                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-top: 1px solid #27272a; border-bottom: 1px solid #27272a; padding: 20px 0; margin-bottom: 30px;">
                            <div>
                                <p style="color: #a1a1aa; font-size: 13px;">No. Pesanan</p>
                                <p style="font-weight: 600;">#
                                    <?= $data['no_pesanan'] ?>
                                </p>
                            </div>
                            <div>
                                <p style="color: #a1a1aa; font-size: 13px;">Total Bayar</p>
                                <p style="font-weight: 600; color: #4ade80;">Rp
                                    <?= number_format($data['total_pesanan'], 0, ',', '.') ?>
                                </p>
                            </div>
                            <div>
                                <p style="color: #a1a1aa; font-size: 13px;">Pemesan</p>
                                <p style="font-weight: 600;">
                                    <?= $data['nama'] ?>
                                </p>
                            </div>
                            <div>
                                <p style="color: #a1a1aa; font-size: 13px;">Metode</p>
                                <p style="font-weight: 600;">
                                    <?= $data['pembayaran'] ?>
                                </p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; justify-content: flex-end;">
                            <form action="logic/update_status_pesanan.php" method="POST">
                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                <input type="hidden" name="status_baru" value="Dibatalkan">
                                <button type="submit" class="btn-cancel" style="border-color: #f87171; color: #f87171;"
                                    onclick="return confirm('Yakin tolak pesanan?')">Tolak Pesanan</button>
                            </form>

                            <form action="logic/update_status_pesanan.php" method="POST">
                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">
                                <input type="hidden" name="status_baru" value="Dikonfirmasi"> <button type="submit"
                                    class="btn-save">Terima & Konfirmasi</button>
                            </form>
                        </div>
                    </div>

                    <?php
                else:
                    $urutan_status = ['Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai'];
                    $current_index = array_search($status_sekarang, $urutan_status);
                    if ($status_sekarang === 'Selesai') {
                        $current_index = count($urutan_status) - 1;
                    }

                    if ($current_index === false)
                        $current_index = 0;

                    $next_status = "";
                    $btn_text = "";
                    if ($current_index < 3) {
                        $next_status = $urutan_status[$current_index + 1];
                        if ($status_sekarang == 'Dikonfirmasi')
                            $btn_text = "Proses Pesanan (Packing)";
                        elseif ($status_sekarang == 'Diproses')
                            $btn_text = "Kirim Barang";
                        elseif ($status_sekarang == 'Dikirim')
                            $btn_text = "Selesaikan Pesanan";
                    }
                    ?>

                    <div style="
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:20px;
  padding-bottom:20px;
  margin-bottom:30px;
  border-bottom:1px solid #27272a;
">

                        <div style="display:flex; flex-direction:column; gap:6px;">
                            <div style="font-size:14px;">
                                <span style="color:#a1a1aa;">No. Pesanan:</span>
                                <strong>#
                                    <?= $data['no_pesanan'] ?>
                                </strong>
                            </div>

                            <div style="font-size:13px; color:#a1a1aa;">
                                Tanggal:
                                <?= date('d M Y', strtotime($data['created_at'])) ?>
                            </div>
                        </div>

                        <div style="text-align:right;">
                            <div style="font-size:13px; color:#a1a1aa;">Total</div>
                            <div style="font-size:20px; font-weight:700">
                                Rp
                                <?= number_format($data['total_pesanan'], 0, ',', '.') ?>
                            </div>
                        </div>

                    </div>


                    <div class="stepper-wrapper">
                        <?php
                        $total_step = count($urutan_status) - 1;

                        if ($status_sekarang === 'Selesai') {
                            $progress_width = 100;
                        } else {
                            $progress_width = ($current_index / $total_step) * 100;
                        }

                        ?>

                        <div class="progress-line <?= $status_sekarang === 'Selesai' ? 'done' : '' ?>"
                            style="width: <?= $progress_width ?>%;"></div>

                        <?php foreach ($urutan_status as $key => $label): ?>
                            <div class="stepper-item <?= $key <= $current_index ? 'active' : '' ?>">
                                <div class="step-counter">
                                    <?= $key + 1 ?>
                                </div>
                                <div class="step-name">
                                    <?= $label ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="color:white; margin-top:40px; max-width:100%;">

                        <div style="margin-bottom:40px;">
                            <h4 style="margin-bottom:16px; border-bottom:1px solid #27272a; padding-bottom:10px;">
                                Data Pengiriman
                            </h4>

                            <div style="display:grid; grid-template-columns:160px auto; gap:12px 24px;">
                                <span style="color:#a1a1aa;">Nama Penerima</span>
                                <span>
                                    <?= $data['nama'] ?>
                                </span>

                                <span style="color:#a1a1aa;">No. HP</span>
                                <span>
                                    <?= $data['no_hp'] ?>
                                </span>

                                <span style="color:#a1a1aa;">Alamat</span>
                                <span>
                                    <?= $data['alamat'] ?>
                                </span>
                            </div>
                        </div>

                        <div
                            style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #3f3f3f; padding-top:20px;">

                            <form action="logic/update_status_pesanan.php" method="POST">
                                <input type="hidden" name="id" value="<?= $id_pesanan ?>">

                                <?php if ($status_sekarang !== 'Selesai' && $status_sekarang !== 'Dibatalkan'): ?>
                                    <input type="hidden" name="status_baru" value="<?= $next_status ?>">
                                <?php endif; ?>

                                <button type="submit" class="btn-save" <?= ($status_sekarang === 'Selesai' || $status_sekarang === 'Dibatalkan') ? 'disabled' : '' ?>> <?php
                                            if ($status_sekarang === 'Selesai') {
                                                echo 'Pesanan Selesai';
                                            } elseif ($status_sekarang === 'Dibatalkan') {
                                                echo 'Pesanan Dibatalkan';
                                            } else {
                                                echo $btn_text;
                                            }
                                            ?> </button>
                            </form>

                        </div>


                    </div>


                <?php endif; ?>

            </div>
        </div>
    </div>

</body>

</html>