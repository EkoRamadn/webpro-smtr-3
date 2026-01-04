<?php
require "koneksi.php";

$sql = "SELECT id,nama,harga,gambar,kategori_id FROM produk";
$res = mysqli_query($_CONNEC, $sql);