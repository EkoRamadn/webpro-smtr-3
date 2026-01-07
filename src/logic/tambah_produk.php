<?php
require "koneksi.php";

$query_kategori = mysqli_query($_CONNEC, "SELECT * FROM kategori");

if (isset($_POST['simpan'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = $_POST['kategori_id'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar_nama != "") {
        $nama_file_baru = date('dmYHis') . '_' . $gambar_nama;
        move_uploaded_file($gambar_tmp, '../public/img/' . $nama_file_baru);
    } else {
        $nama_file_baru = 'default.png';
    }

    $query_insert = mysqli_query($_CONNEC, "INSERT INTO produk (nama, kategori_id, harga, stok, gambar, deskripsi, created_at) 
                                            VALUES ('$nama', '$kategori', '$harga', '$stok', '$nama_file_baru', '$deskripsi', NOW())");

    if ($query_insert) {
        header("Location: ../data_produk.php");
    } else {

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Produk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../style/dashboard.css" />
</head>

<body>
    <div class="frame_utama">

        <div class="frame_header">
            <div class="home_title">
                <img class="icon" src="/public/icon/material-symbols--menu.png" alt="icon_menu" />
                <p class="title_header">Tambah Produk</p>
            </div>
            <div class="frame_button">
                <a href="#">
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
                <a href="../dashboard.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="/public/icon/material-symbols--dashboard.png" alt="" />
                        <p class="button_text">Dashboard</p>
                    </div>
                </a>
                <a href="data_produk.php">
                    <div class="sidebar_menu_active">
                        <img class="icon" src="/public/icon/gridicons--product.png" alt="" />
                        <p class="button_text">Data Produk</p>
                    </div>
                </a>
                <a href="data_pesanan.php">
                    <div class="sidebar_menu">
                        <img class="icon" src="/public/icon/lets-icons--order.png" alt="" />
                        <p class="button_text">Data Pesanan</p>
                    </div>
                </a>
            </div>

            <div class="content">


                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="label-text">Nama Produk</label>
                        <input type="text" name="nama" class="input-box" placeholder="Contoh: Batik Mega Mendung"
                            required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="label-text">Kategori</label>
                            <select name="kategori_id" class="input-box" required>
                                <option value="">Pilih Kategori</option>
                                <?php while ($row = mysqli_fetch_assoc($query_kategori)): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label-text">Harga (Rp)</label>
                            <input type="number" name="harga" class="input-box" placeholder="150000" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="label-text">Stok Awal</label>
                            <input type="number" name="stok" class="input-box" placeholder="10" required>
                        </div>
                        <div class="form-group">
                            <label class="label-text">Foto Produk</label>
                            <input type="file" name="gambar" class="input-box" accept="image/*" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-text">Deskripsi</label>
                        <textarea name="deskripsi" class="input-box" rows="4"
                            placeholder="Keterangan bahan, ukuran..."></textarea>
                    </div>

                    <div style="display: flex; flex: 1; gap: 10px;">
                        <a href="../data_produk.php" class="btn-actions" style="color: black;">Batal</a>
                        <button type="submit" name="simpan" class="btn-actions" style="color: black;">Simpan
                            Produk</button>
                    </div>

                </form>


            </div>
        </div>
    </div>
</body>

</html>