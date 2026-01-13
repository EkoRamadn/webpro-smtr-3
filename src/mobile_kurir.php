<?php
require "./logic/koneksi.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'kurir') {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: beranda.php");
    }
    exit;
}

$id_kurir = $_SESSION['user_id'];

$query = mysqli_query($_CONNEC, "SELECT * FROM pesanan WHERE status_pesanan = 'Dikirim' ORDER BY (kurir_id = '$id_kurir') DESC, created_at ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Kurir</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/style/mobile_kurir.css">
</head>

<body>
    <div class="mobile-header">
        <div class="app-title">
            <span>Dashboard Kurir</span>
        </div>
        <button id="themeToggle" class="badge-mode" onclick="toggleTheme()">Indoor Mode</button>
    </div>

    <div class="container">
        <div class="section-label">Daftar Pengiriman</div>

        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <?php
                $is_mine = ($row['kurir_id'] == $id_kurir);
                $is_free = empty($row['kurir_id']);

                $nama_user = $row['nama'];
                $order_id = $row['no_pesanan'];
                $alamat_user = $row['alamat'];

                $template_chat = "Halo Kak *$nama_user*, \n\n";
                $template_chat .= "Saya Kurir yang akan mengantar paket Anda:\n";
                $template_chat .= "*No. Pesanan: #$order_id*\n";
                $template_chat .= "Alamat: $alamat_user\n\n";
                $template_chat .= "Apakah ada orang di rumah? Saya segera meluncur. Terima kasih! 🙏";

                $link_wa = "https://wa.me/" . $row['no_hp'] . "?text=" . urlencode($template_chat);
                ?>
                <div class="kurir-card" style="text-transform: capitalize;">
                    <div class="card-top">
                        <span class="order-number">#<?= $row['no_pesanan'] ?></span>

                        <?php if ($row['pembayaran'] == 'cod'): ?>
                            <span class="tag-status tag-cod">COD: Rp
                                <?= number_format($row['total_pesanan'], 0, ',', '.') ?></span>
                        <?php else: ?>
                            <span class="tag-status tag-lunas">LUNAS</span>
                        <?php endif; ?>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Penerima</span>
                        <div class="info-value"><?= $row['nama'] ?></div>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Alamat Pengiriman</span>
                        <div class="info-address"><?= $row['alamat'] ?></div>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Kontak</span>
                        <div class="info-value"><?= $row['no_hp'] ?></div>
                    </div>

                    <div class="action-grid">
                        <a href="<?= $link_wa ?>" class="btn-icon" target="_blank">
                            WhatsApp
                        </a>

                        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($row['alamat']) ?>"
                            class="btn-icon" target="_blank">
                            Maps
                        </a>

                        <?php if ($is_mine): ?>
                            <button onclick="bukaModal('<?= $row['id'] ?>', '<?= $row['no_pesanan'] ?>')"
                                class="btn-icon btn-primary">
                                Upload Bukti Pengiriman
                            </button>

                        <?php elseif ($is_free): ?>
                            <form action="logic/kurir_ambil.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn-icon btn-primary">
                                    Ambil Paket Ini
                                </button>
                            </form>

                        <?php else: ?>
                            <button disabled class="btn-icon"
                                style="background: #3f3f46; color: #a1a1aa; cursor: not-allowed; border:none; width: 100%;">
                                Diambil Kurir Lain
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <h3 style="font-size:16px; margin-bottom:5px; color:var(--text-main); font-weight:600;">Belum ada tugas
                    pengiriman</h3>
                <p style="font-size:13px; margin:0; opacity:0.8;">Tunggu admin menetapkan pesanan baru ya.</p>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <div id="modalSelesai" class="modal-overlay" onclick="tutupModal(event)">
        <div class="modal-sheet" onclick="event.stopPropagation()">

            <h3 class="modal-title">Selesaikan Pesanan</h3>
            <p id="modalOrderId" class="modal-sub">#PC-000</p>

            <form action="logic/kurir_upload_bukti.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="inputIdPesanan">

                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                    <input type="file" name="bukti_kurir" id="fileInput" accept="image/*" style="display:none"
                        onchange="previewImage(this)">

                    <div id="placeholderText">
                        <img src="../public/icon/solar--gallery-bold.png" class="icon-img" alt="Kamera">

                        <p style="font-size:13px; margin:0;">Tap untuk Foto / Galeri</p>
                    </div>

                    <img id="imgPreview" style="max-width:100%; border-radius:8px; display:none; margin: 0 auto;">
                </div>

                <button type="submit" class="btn-submit">
                    Selesaikan Pengiriman
                </button>
            </form>
        </div>
    </div>

    <script>
        const currentTheme = localStorage.getItem('theme');
        const btn = document.getElementById('themeToggle');
        const body = document.documentElement;

        if (currentTheme === 'dark') {
            body.setAttribute('data-theme', 'dark');
            btn.innerHTML = 'Outdoor Mode';
        } else {
            body.setAttribute('data-theme', 'light');
            btn.innerHTML = 'Indoor Mode';
        }

        function toggleTheme() {
            if (body.getAttribute('data-theme') === 'dark') {
                body.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                btn.innerHTML = 'Indoor Mode';
            } else {
                body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                btn.innerHTML = 'Outdoor Mode';
            }
        }

        function bukaModal(id, no_pesanan) {
            document.getElementById('modalSelesai').style.display = 'flex';
            document.getElementById('inputIdPesanan').value = id;
            document.getElementById('modalOrderId').innerText = '#' + no_pesanan;
            document.getElementById('imgPreview').style.display = 'none';
            document.getElementById('placeholderText').style.display = 'block';
            document.getElementById('fileInput').value = '';
        }

        function tutupModal(event) {
            if (event.target.id === 'modalSelesai') {
                document.getElementById('modalSelesai').style.display = 'none';
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('imgPreview').src = e.target.result;
                    document.getElementById('imgPreview').style.display = 'block';
                    document.getElementById('placeholderText').style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function tutupModal(event) {
            if (event.target.id === 'modalSelesai') {
                document.getElementById('modalSelesai').style.display = 'none';
            }
        }
    </script>
</body>

</html>