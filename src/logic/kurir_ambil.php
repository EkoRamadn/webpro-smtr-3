<?php
require "koneksi.php";
session_start();

$id_pesanan = $_POST['id'];
$nama_kurir = $_SESSION['username'];

$query = "UPDATE pesanan SET nama_kurir = '$nama_kurir' WHERE id = '$id_pesanan'";

if (mysqli_query($_CONNEC, $query)) {
    header("Location: ../mobile_kurir.php");
} else {
    echo "Gagal database";
}
?>