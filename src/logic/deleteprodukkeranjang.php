<?php
// session_start();
require "koneksi.php";


$id = $_GET['id'];


$sql = "DELETE FROM keranjang_produk WHERE id = $id";

$resuser = mysqli_query($_CONNEC, $sql);

if ($resuser) {
    header("Location: ../template/peringatan.php?pesan=Produk berhasil dihapus&lanjut=../keranjang.php&kembali=../keranjang.php");
    exit();
} else {
    header("Location: ../template/peringatan.php?pesan=Produk gagal dihapus&lanjut=../keranjang.php&kembali=../keranjang.php");
    exit();
}