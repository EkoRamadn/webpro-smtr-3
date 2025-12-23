<?php
require "koneksi.php";

$res = mysqli_query($connect, 'SELECT * FROM produk');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="global.css">
</head>

<body>
    <div class="container">
        <div class="top">
            <h1 style="text-align: center;font-size: 20px;margin: 70px 0 10px;">Tambah Produk Batik</h1>
        </div>
        <div class="ctn" style="display: flex;justify-content: center;align-items: center;column-gap: 5px;">
            <div class="content-form">
                <form class="add-product" action="./add_produk.php" method="POST">
                    <div class="input-grub">
                        <label for="">Nama Batik</label>
                        <input type="text" placeholder="nama batlk" name="nama">
                    </div>
                    <div class="input-grub">
                        <label for="">Deskripsi</label>
                        <input type="text" placeholder="deskripsi" name="deskripsi">
                    </div>
                    <div class="input-grub">
                        <label for="">Harga</label>
                        <input type="number" name="harga" id="harga" placeholder="harga">
                    </div>
                    <div class="input-grub">
                        <label for="">Image Url</label>
                        <input type="text" name="gambar" id="image" placeholder="url image">
                    </div>
                    <div class="input-grub">
                        <label for="">Toko</label>
                        <input type="text" name="toko" id="toko" placeholder="toko">
                    </div>
                    <div class="input-grub">
                        <label for="">Reting</label>
                        <input type="number" name="rate" id="rate" placeholder="rating" min="1" max="5">
                    </div>
                    <div class="btn-grub">
                        <a href="./HALAMAN-9.php">
                            Kembali
                        </a>
                        <button type="submit">Tambah</button>
                    </div>
                </form>
            </div>

            <div class="right" style="width: 300px; height: 470px;  border-radius: 8px;">
                <h2>List Produk</h2>
                <ul style="margin-top: 10px;list-style: none; display:flex; flex-direction: column;gap:10px;">
                    <?php
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $nama = htmlspecialchars($row['nama']);
                        $harga = number_format($row['harga'], 0, ',', '.');
                        $gambar = $row['gambar'];
                        $kota = htmlspecialchars($row['toko']);
                        $rating = $row['rate'];
                        ?>
                        <li>
                            <div class="content-prod"
                                style="display: flex; align-items: center;gap: 10px;justify-content: space-between;">
                                <div class="left" style="display: flex;align-items: center; gap: 5px;">

                                    <div class="cvr"
                                        style="width: 50px; height: 30px;background: #000;margin-right: 5px; overflow: hidden;">
                                        <img src="<?= $gambar ?>" alt=""
                                            style="object-fit: cover;height: 100%;width: 100%;">
                                    </div>

                                    <span><?= $nama ?></span>

                                </div>
                                <div class="right5">
                                    <form action="./del_produk.php" method="POST">
                                        <input type="number" name="id" id="produk_id" hidden value="<?= $id ?>">
                                        <button type="submit"
                                            style="background: #ef4444;padding: 5px 10px;border-radius: 5px;color: white;">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    </div>
</body>

</html>