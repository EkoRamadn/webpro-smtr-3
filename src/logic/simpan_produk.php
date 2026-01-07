<?php
require "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori_id'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar != "") {
        move_uploaded_file($tmp, "../../public/img/" . $gambar);
    } else {
        $gambar = "";
    }

    mysqli_query($_CONNEC, "INSERT INTO produk (nama, kategori_id, harga, stok, deskripsi, gambar) VALUES ('$nama', '$kategori', '$harga', '$stok', '$deskripsi', '$gambar')");

    header("location: ../data_produk.php");
}
?>