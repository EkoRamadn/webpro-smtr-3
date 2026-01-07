<?php
require "koneksi.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori_id'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar != "") {
        move_uploaded_file($tmp, "../../public/img/" . $gambar);
        mysqli_query($_CONNEC, "UPDATE produk SET nama='$nama', kategori_id='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$id'");
    } else {
        mysqli_query($_CONNEC, "UPDATE produk SET nama='$nama', kategori_id='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id='$id'");
    }

    header("location: ../data_produk.php");
}
?>