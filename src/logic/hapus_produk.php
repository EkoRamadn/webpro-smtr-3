<?php
require "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_cek = mysqli_query($_CONNEC, "SELECT gambar FROM produk WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query_cek);
    $gambar = $data['gambar'];

    $hapus = mysqli_query($_CONNEC, "DELETE FROM produk WHERE id='$id'");

    if ($hapus) {
        if ($gambar != "" && $gambar != "default.png" && file_exists("../../public/img/" . $gambar)) {
            unlink("../../public/img/" . $gambar);
        }
    }
}

header("location: ../data_produk.php");
?>