<?php
session_start();
require "koneksi.php";

$keranjang_id = $_POST['id'];
$total_pesanan = $_POST['total_pesanan'];
$user_id = $_SESSION['user_id'];
$fullname = $_POST['fullname'];
$alamat = $_POST['addres'];
$no_hp = $_POST['no_hp'];
$pembayaran = $_POST['metode'];
$created_at = date('Y-m-d');

$sql = "SELECT kp.*, p.nama, p.harga, p.gambar
        FROM keranjang k
        INNER JOIN keranjang_produk kp 
            ON k.id = kp.keranjang_id
        INNER JOIN produk p
            ON kp.produk_id = p.id
        WHERE k.id= $keranjang_id";

$resdata1 = mysqli_query($_CONNEC, $sql);

$no_pesanan = "PC00" . $user_id . $keranjang_id;

$sql1 = "INSERT INTO pesanan
        (no_pesanan, user_id, total_pesanan, status_pesanan, pembayaran, nama, alamat, no_hp,created_at)
        VALUES
        ('$no_pesanan', '$user_id', '$total_pesanan', 'pay', '$pembayaran', '$fullname', '$alamat', '$no_hp','$created_at')";

$respesanan = mysqli_query($_CONNEC, $sql1);


$pesanan_id = mysqli_insert_id($_CONNEC);

while ($row = mysqli_fetch_assoc($resdata1)) {

    $produk_id = $row['produk_id'];
    $produk_nama = $row['nama'];
    $jumlah = $row['total_produk'];   
    $harga = $row['harga'];
    $subtotal = $jumlah * $harga;

    $insert_produk = "INSERT INTO pesanan_produk 
        (pesanan_id, produk_id, produk_nama, produk_harga, total_produk, total_harga)
        VALUES 
        ('$pesanan_id', '$produk_id', '$produk_nama', '$harga', '$jumlah', '$subtotal')";

    mysqli_query($_CONNEC, $insert_produk) or die("SQL Error: " . mysqli_error($_CONNEC));
}

mysqli_query($_CONNEC, "DELETE FROM keranjang_produk WHERE keranjang_id = $keranjang_id");
mysqli_query($_CONNEC, "DELETE FROM keranjang WHERE id = $keranjang_id");

header("Location: ../template/status-pesanan.php?id=$pesanan_id");
