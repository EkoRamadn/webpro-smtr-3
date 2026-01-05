<?php
require "koneksi.php";
session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT kp.*, p.nama, p.harga, p.gambar
        FROM keranjang k
        INNER JOIN keranjang_produk kp 
            ON k.id = kp.keranjang_id
        INNER JOIN produk p
            ON kp.produk_id = p.id
        WHERE k.user_id = $user_id 
        AND k.status = 'aktif'";



$res = mysqli_query($_CONNEC, $sql);