<?php
require 'koneksi.php';

$res = mysqli_query($connect, 'SELECT 
    pesanan.id,
    produk.nama,
    produk.deskrip,
    produk.toko,
    produk.rate,
    produk.gambar,
    pesanan.total_pesanan,
    pesanan.total_harga
FROM pesanan
INNER JOIN produk 
    ON pesanan.id_produk = produk.id;');
if (!$res) {
    die(mysqli_error($connect));
}
// var_dump(mysqli_fetch_assoc($res))
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./global.css">
</head>

<style>
    .content-top-cart {
        font-weight: 600;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0px 20px;
    }

    .accordion {
        width: 100%;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 16px 20px;
        margin: 12px 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }


    .accordion summary {
        list-style: none;
        cursor: pointer;
        /* font-weight: 600; */
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .accordion summary::-webkit-details-marker {
        display: none;
    }

    .accordion summary::after {
        content: "＋";
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .accordion[open] summary::after {
        content: "−";
    }

    .accordion p {
        margin-top: 12px;
        color: #4b5563;
        line-height: 1.6;
    }

    .accordion:hover {
        border-color: #c7d2fe;
    }

    .accordion[open] {
        background: #f9fafb;
    }

    .deskrip {
        font-size: 12px;
        width: 300px;
        height: 200px;
        overflow-y: hidden;
    }


    .item-detail {
        width: 100%;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 16px;
        margin: 12px 0;
        align-items: start;
    }

    .thumb img {
        height: 140px;
        object-fit: cover;
        border-radius: 5px;
    }

    .deskrip {
        max-height: 140px;
        overflow-y: auto;
        font-size: 14px;
        line-height: 1.6;
        color: #4b5563;
        padding-right: 6px;
    }

    .deskrip::-webkit-scrollbar {
        width: 5px;
    }

    .deskrip::-webkit-scrollbar-thumb {
        background: #cbd5f5;
        border-radius: 10px;
    }

    .status {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 14px;
    }

    .location {
        font-weight: 600;
        color: #111827;
    }

    .rate {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .rate img {
        width: 16px;
    }

    .rate span {
        font-weight: 600;
        color: #4b5563;
    }

    .badge {
        background: rgb(255, 179, 0);
        color: white;
        padding: 6px 10px;
        border-radius: 10px;
        font-size: 12px;
        width: fit-content;
    }

    .qty-form {
        width: 220px;
        display: flex;
        gap: 8px;
        margin-top: 6px;
    }

    .qty-form input {
        width: 60px;
        padding: 6px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }

    .qty-form button {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        background: #4f46e5;
        color: white;
        cursor: pointer;
        font-size: 13px;
    }

    .qty-form button:hover {
        background: #4338ca;
    }
</style>

<body>
    <div class="container">
        <div class="navigation">
            <div class="link cart-buy-page">
                <div class="icon">
                    <img src="./images/icon/uil--cart.svg" alt="buy-cart">
                </div>
                <h1>Cart Buy</h1>
            </div>
            <a href="./HALAMAN-9.php" class="back">
                <button class="icon cart-buy back">
                    <img src="./images/icon/mynaui--skip-back-solid.svg" alt="buy-cart" width="100%" height="100%">
                </button>
            </a>
        </div>

        <div class="main hl8 stok">
            <div class="top">
                <h1 class="title">
                    Lihat Semua Pesanan Anda
                </h1>
                <p>Lihat perkembangan setiap pesanan Anda secara real-time, dari konfirmasi hingga pesanan tiba di
                    tujuan.</p>
            </div>

            <div class="content-top-cart">
                <span>Nama Barang</span>
                <span>Harga</span>
                <span style="width: 50px;">Aksi</span>
            </div>
            <?php
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $nama = htmlspecialchars($row['nama']);
                $total_harga = number_format($row['total_harga'], 0, ',', '.');
                $gambar = $row['gambar'];
                $kota = htmlspecialchars($row['toko']);
                $rating = $row['rate'];
                $total_pesanan = $row['total_pesanan'];
                $deskrp = $row['deskrip'];
                ?>
                <details class="accordion">
                    <summary style="position: relative;">
                        <span>
                            <?= $nama ?>
                        </span>
                        <span>
                            Rp<?= $total_harga ?>
                        </span>

                        <form action="del_cart.php" method="POST"
                            style="position: absolute; top: 50%;transform: translateY(-50%); right: 30px;">
                            <input type="text" name="pesanan_id" hidden id="pesanan_id" value="<?= $id ?>">
                            <button type="submit"
                                style="padding: 6px 12px; border-radius: 5px; background: red; color: white;cursor: pointer; ">
                                Hapus
                            </button>
                        </form>
                    </summary>
                    <div style="border-top: 1px solid rgb(112, 112, 112);margin: 10px;display: flex;column-gap: 10px;">
                        <div class="item-detail">
                            <div class="left" style="display: flex;align-items: center; column-gap: 15px;">
                                <div class="thumb">
                                    <img src="<?= $gambar ?>" alt="Batik Parang">
                                </div>

                                <div class="deskrip">
                                    <p>
                                        <?= $deskrp ?>
                                    </p>
                                </div>
                            </div>

                            <div class="status">
                                <p class="location"><?= $kota ?></p>

                                <div class="rate">
                                    <img src="./images/icon/iconamoon--star-fill.svg" alt="star">
                                    <span><?= $rating ?>.0</span>
                                </div>

                                <span class="badge">Dalam Antrian Pemesanan</span>

                                <form class="qty-form" action="up_cart.php" method="POST">
                                    <input type="text" hidden name="pesanan_id" id="pesanan_id" value="<?= $id ?>">
                                    <input type="number" hidden name="harga_lama" id="harga_lama"
                                        value="<?= $row['total_harga'] ?>">
                                    <input type="number" hidden name="pesanan_lama" id="pesanan_lama"
                                        value="<?= $total_pesanan ?>">
                                    <input type="number" name="total_pesanan" value="<?= $total_pesanan ?>" min="1">
                                    <button type="submit">Simpan</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </details>
            <?php } ?>
        </div>
    </div>
</body>

</html>