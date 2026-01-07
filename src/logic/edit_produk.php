<?php
require "koneksi.php";

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query_edit = mysqli_query($_CONNEC, "SELECT * FROM produk WHERE id = '$id_produk'");
    $query_kategori = mysqli_query($_CONNEC, "SELECT * FROM kategori");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../style/dashboard.css" />
</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title">
                <img class="icon" src="/public/icon/material-symbols--menu.png" alt="icon_menu" />
                <p class="title_header">Dashboard</p>
            </div>
            <div class="frame_button">
                <a href="">
                    <div class="button_header">
                        <img class="icon" src="/public/icon/material-symbols--store.png" alt="icon_store" />
                        <p class="button_text">Store</p>
                    </div>
                </a>
                <a href="index.php">
                    <div class="button_header">
                        <img class="icon" src="/public/icon/material-symbols--logout.png" alt="icon_logout" />
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
                        <img class="icon" src="/public/icon/material-symbols--dashboard.png" alt="icon_dashboard" />
                        <p class="button_text">Dashboard</p>
                    </div>
                </a>
                <a href="data_produk.php">
                    <div class="sidebar_menu_active">
                        <img class="icon" src="/public/icon/gridicons--product.png" alt="icon_data_produk" />
                        <p class="button_text">Data Produk</p>
                    </div>
                </a>
                <a href="data_pesanan.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="/public/icon/lets-icons--order.png" alt="icon_data_pesanan" />
                        <p class="button_text">Data Pesanan</p>
                    </div>
                </a>
            </div>

            <div class="content">
                <form action="update_produk.php" method="POST" enctype="multipart/form-data">
                    <?php
                    if ($show = mysqli_fetch_assoc($query_edit)) {
                        $id = $show['id'];
                        $nama = $show['nama'];
                        $kategori_terpilih = $show['kategori_id'];
                        $harga = $show['harga'];
                        $stok = $show['stok'];
                        $gambar = $show['gambar'];
                        $deskripsi = $show['deskripsi'];
                    }
                    ?>

                    <div style="display: grid; grid-template-columns: 240px 1fr 1fr; gap: 30px; align-items: stretch;">

                        <div style="display: flex; flex-direction: column;">
                            <div class="image-upload-container" onclick="triggerUpload()">
                                <div class="upload-icon">+</div>
                                <img id="preview" src="../public/img/<?= $gambar; ?>" alt="Preview">
                            </div>
                            <input type="file" name="gambar" id="fileInput" accept="image/*"
                                onchange="gantiGambar(this)">
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="label-text">Nama Produk</label>
                                <input type="text" name="nama" class="input-box" value="<?= $nama ?>" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="label-text">Kategori</label>
                                <select name="kategori_id" class="input-box" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php while ($kat = mysqli_fetch_assoc($query_kategori)): ?>
                                        <option value="<?= $kat['id'] ?>" <?= ($kat['id'] == $show['kategori_id']) ? 'selected' : '' ?>>
                                            <?= $kat['name'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="label-text">Harga (Rp)</label>
                                    <input type="number" name="harga" class="input-box" value="<?= $harga ?>" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="label-text">Stok</label>
                                    <input type="number" name="stok" class="input-box" value="<?= $stok ?>" required>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column;">
                            <label class="label-text">Deskripsi</label>
                            <textarea name="deskripsi" class="input-box"
                                style="flex: 1; resize: none;"><?= htmlspecialchars($deskripsi) ?></textarea>
                        </div>

                    </div>

                    <div
                        style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 30px; border-top: 1px solid #3f3f3f; padding-top: 20px;">
                        <a href="../data_produk.php" class="btn-actions"
                            style="background: black; padding: 12px 20px; border-radius: 6px; color: white; text-decoration: none; font-weight: 600;">Batal</a>
                        <button type="submit" name="simpan" class="btn-actions"
                            style="background: white; padding: 12px 20px; border-radius: 6px; color: black; border: none; font-weight: 600; cursor: pointer;">Simpan
                            Perubahan</button>
                    </div>

                </form>


            </div>
        </div>
    </div>

    <script>
        function triggerUpload() { document.getElementById('fileInput').click(); }
        function gantiGambar(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) { preview.src = e.target.result; }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>