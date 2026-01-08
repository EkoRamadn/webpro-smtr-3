<?php
require "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = $_POST['kategori_id'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $gambar = $_POST['gambar'];

    if (empty($gambar)) {
        $gambar = "https://placehold.co/400?text=No+Image";
    }

    $harga_raw = $_POST['harga'];
    $harga = str_replace('.', '', $harga_raw);

    $query = "INSERT INTO produk (nama, kategori_id, harga, stok, deskripsi, gambar) VALUES ('$nama', '$kategori', '$harga', '$stok', '$deskripsi', '$gambar')";

    mysqli_query($_CONNEC, $query);

    header("location: ../data_produk.php");
}
?>