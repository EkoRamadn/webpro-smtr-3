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

$query_pesanan = mysqli_query($_CONNEC, "SELECT * FROM pesanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./style/dashboard.css" />

    <style>
        .no-data-message {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #151419;
            border: 1px solid #27272a;
            border-radius: 12px;
            margin-top: 20px;
            color: #a1a1aa;
        }
    </style>
</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title">
                <img class="icon" src="../public/icon/material-symbols--menu.png">
                <p class="title_header">Data Pesanan</p>
            </div>
            <div class="frame_button">
                <a href="./beranda.php">
                    <div class="button_header">
                        <img class="icon" src="../public/icon/material-symbols--store.png">
                        <p class="button_text">Store</p>
                    </div>
                </a>
                <a href="./logic/logout.php">
                    <div class="button_header">
                        <img class="icon" src="../public/icon/material-symbols--logout.png" alt="icon_logout" />
                        <p class="button_text">Logout</p>
                    </div>
                </a>
            </div>
        </div>

        <hr style="width: 100%; color: #3f3f3f" />

        <div class="frame_tengah">
            <div class="sidebar">
                <a href="dashboard.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="../public/icon/material-symbols--dashboard.png">
                        <p class="button_text">Dashboard</p>
                    </div>
                </a>
                <a href="data_produk.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="../public/icon/gridicons--product.png">
                        <p class="button_text">Data Produk</p>
                    </div>
                </a>
                <a href="data_pesanan.php">
                    <div class="sidebar_menu_active">
                        <img class="icon" src="../public/icon/lets-icons--order.png">
                        <p class="button_text">Data Pesanan</p>
                    </div>
                </a>
            </div>

            <div class="content">
                <div class="header-tools">
                    <div class="search-group">
                        <input type="text" id="inputSearch" class="input-search" placeholder="Cari No Pesanan / Nama"
                            style="text-transform: capitalize;">
                        <button type="button" class="btn-cari" id="searchBtn">
                            <img id="searchIcon" class="icon" src="../public/icon/mdi--magnify.png">
                        </button>
                    </div>

                </div>

                <div class="rounded-border" id="tableContainer">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabelPesanan">
                            <?php while ($row = mysqli_fetch_assoc($query_pesanan)): ?>
                                <tr class="data-row">
                                    <td class="col-invoice" style="font-family: monospace; color: #a1a1aa;">
                                        #<?= $row['no_pesanan'] ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    <td class="col-nama"><?= $row['nama'] ?></td>
                                    <td style="font-weight: 600;">Rp
                                        <?= number_format($row['total_pesanan'], 0, ',', '.') ?>
                                    </td>

                                    <td>
                                        <?php
                                        $statusClass = strtolower(explode(' ', $row['status_pesanan'])[0]);
                                        ?>
                                        <span class="status-text status-<?= $statusClass ?>">
                                            <?= $row['status_pesanan'] ?>
                                        </span>
                                    </td>

                                    <td style="text-align: center;">
                                        <div class="action-dropdown">
                                            <button onclick="toggleDropdown('menu-<?= $row['id'] ?>')" class="btn-kebab">
                                                <img src="../public/icon/lucide--ellipsis.png" class="icon-action">
                                            </button>

                                            <div id="menu-<?= $row['id'] ?>" class="dropdown-menu">

                                                <a href="detail_pesanan.php?id=<?= $row['id'] ?>" class="dropdown-item">
                                                    <img src="../public/icon/mdi--magnify.png" style="width: 16px;">
                                                    Lihat Detail
                                                </a>

                                                <?php if ($row['status_pesanan'] == 'Menunggu Pembayaran'): ?>
                                                    <button class="dropdown-item" onclick="bukaModalKonfirmasi(
                    '<?= $row['id'] ?>', 
                    '<?= htmlspecialchars($row['nama']) ?>',
                    '<?= number_format($row['total_pesanan'], 0, ',', '.') ?>'
                )">
                                                        <img src="../public/icon/tabler--check.png" style="width: 16px;">
                                                        Konfirmasi
                                                    </button>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div id="noDataMessage" class="no-data-message">
                    <img src="../public/icon/mdi--magnify.png" style="width: 48px; opacity: 0.3; margin-bottom: 10px;">
                    <p>Pesanan tidak ditemukan</p>
                </div>

            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalKonfirmasi" style="z-index:2000;">
        <div class="form-card" style="max-width:480px; text-align:center;" onclick="event.stopPropagation()">

            <div style="margin-bottom:20px;">
                <img src="../public/icon/mingcute--warning-line.png" style="width:44px;">
                <h3 style="margin:12px 0 6px;">Konfirmasi Pesanan</h3>
                <p style="color:#a1a1aa; font-size:13px">
                    Pastikan pembayaran sudah diterima sebelum melanjutkan.
                </p>
            </div>

            <hr style="border:0;border-top:1px solid #27272a;margin:16px 0;">

            <div style="margin-bottom:24px; text-align:left;">
                <div id="infoSingkatPesanan"></div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button onclick="tutupKonfirmasi()" class="btn-cancel">
                    Batal
                </button>

                <form action="logic/update_status_pesanan.php" method="POST">
                    <input type="hidden" name="id" id="confirm_id">
                    <input type="hidden" name="status_baru" value="Dikonfirmasi">
                    <button type="submit" class="btn-save">
                        Terima & Konfirmasi
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const inputSearch = document.getElementById('inputSearch');
        const iconSearch = document.getElementById('searchIcon');
        const btnSearchAction = document.getElementById('searchBtn');
        const rows = document.querySelectorAll('#tabelPesanan tr');
        const noDataMsg = document.getElementById('noDataMessage');
        const tableContainer = document.getElementById('tableContainer');

        inputSearch.addEventListener('keyup', function () {
            const val = this.value.toLowerCase();
            let visibleCount = 0;

            if (val.length > 0) {
                iconSearch.src = "../public/icon/material-symbols--close.png";
                btnSearchAction.style.cursor = "pointer";
                btnSearchAction.onclick = () => {
                    inputSearch.value = '';
                    inputSearch.dispatchEvent(new Event('keyup'));
                };
            } else {
                iconSearch.src = "../public/icon/mdi--magnify.png";
                btnSearchAction.style.cursor = "default";
                btnSearchAction.onclick = null;
            }

            rows.forEach(row => {
                const invoice = row.querySelector('.col-invoice').innerText.toLowerCase();
                const nama = row.querySelector('.col-nama').innerText.toLowerCase();

                if (invoice.includes(val) || nama.includes(val)) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            if (visibleCount === 0) {
                tableContainer.style.display = 'none';
                noDataMsg.style.display = 'flex';
            } else {
                tableContainer.style.display = 'block';
                noDataMsg.style.display = 'none';
            }
        });

        function cekStatusPesanan(id, status, no, total, nama, alamat, hp) {
            if (status === 'Menunggu Pembayaran') {
                document.getElementById('confirm_id').value = id;

                document.getElementById('infoSingkatPesanan').innerHTML = `
        <div style="margin-bottom:20px; text-align:left;">
            <p style="margin-bottom:10px;">
                Data Pengiriman
            </p>

            <div style="display:grid; grid-template-columns:120px auto; gap:8px 16px;">
                <span style="color:#a1a1aa;">Nama</span>
                <span>${nama}</span>

                <span style="color:#a1a1aa;">Alamat</span>
                <span>${alamat}</span>

                <span style="color:#a1a1aa;">No. HP</span>
                <span>${hp}</span>
            </div>
        </div>

        <hr style="border:0;border-top:1px solid #27272a;margin:16px 0;">

        <!-- PRODUK DIPESAN -->
        <div style="text-align:left;">
    <p style="font-size:13px;font-weight:600;margin-bottom:10px;">
        Produk Dipesan
    </p>

    <div class="rounded-border" style="margin:0;">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Harga</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- CONTOH -->
                <tr>
                    <td>Nama Produk</td>
                    <td style="text-align:center;">1</td>
                    <td style="text-align:right;">Rp 100.000</td>
                    <td style="text-align:right;">Rp 100.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

        <hr style="border:0;border-top:1px solid #27272a;margin:16px 0;">

        <!-- TOTAL -->
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:600;">
                Total Pesanan
            </span>
            <span style="font-size:15px; font-weight:700">
                Rp ${total}
            </span>
        </div>
        `;

                document.getElementById('modalKonfirmasi').style.display = 'flex';
            } else {
                window.location.href = `detail_pesanan.php?id=${id}`;
            }
        }

        function tutupKonfirmasi() {
            document.getElementById('modalKonfirmasi').style.display = 'none';
        }

        const modal = document.getElementById('modalKonfirmasi');

        modal.addEventListener('click', function () {
            tutupKonfirmasi();
        });

        // 1. Fungsi Toggle Dropdown (Wajib Ada)
        function toggleDropdown(id) {
            const allMenus = document.getElementsByClassName("dropdown-menu");
            for (let i = 0; i < allMenus.length; i++) {
                if (allMenus[i].id !== id) {
                    allMenus[i].classList.remove('show');
                }
            }
            document.getElementById(id).classList.toggle("show");
        }

        // 2. Tutup Dropdown kalau klik di luar
        window.onclick = function (event) {
            if (!event.target.closest('.btn-kebab')) {
                const allMenus = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < allMenus.length; i++) {
                    allMenus[i].classList.remove('show');
                }
            }
            // Logic tutup modal konfirmasi juga bisa ditaruh sini
            const modal = document.getElementById('modalKonfirmasi');
            if (event.target == modal) {
                tutupKonfirmasi();
            }
        }

        // 3. Fungsi Buka Modal Konfirmasi (Simpel & Bersih)
        function bukaModalKonfirmasi(id, nama, total) {
            document.getElementById('confirm_id').value = id;

            // Tampilkan info ringkas aja (Nama & Total)
            document.getElementById('infoSingkatPesanan').innerHTML = `
        <div style="text-align: center; margin-bottom: 20px;">
            <p style="color: #a1a1aa; font-size: 13px;">Pelanggan</p>
            <p style="font-weight: 600; font-size: 16px; margin-bottom: 10px; color: white;">${nama}</p>
            
            <p style="color: #a1a1aa; font-size: 13px;">Total Tagihan</p>
            <p style="font-weight: 700; font-size: 20px; color: #4ade80;">Rp ${total}</p>
        </div>
        <p style="text-align: center; color: #a1a1aa; font-size: 12px;">
            (Klik "Lihat Detail" di menu untuk cek produk lengkap)
        </p>
    `;

            document.getElementById('modalKonfirmasi').style.display = 'flex';
        }

        function tutupKonfirmasi() {
            document.getElementById('modalKonfirmasi').style.display = 'none';
        }
    </script>
</body>

</html>