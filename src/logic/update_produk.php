<?php
require "koneksi.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
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

    $query = "UPDATE produk SET 
              nama='$nama', 
              kategori_id='$kategori', 
              harga='$harga', 
              stok='$stok', 
              deskripsi='$deskripsi', 
              gambar='$gambar' 
              WHERE id='$id'";

    mysqli_query($_CONNEC, $query);

    header("location: ../data_produk.php");
}
?>