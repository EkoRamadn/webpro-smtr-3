<?php
require "koneksi.php";

$id = $_POST['id'];
$status = $_POST['status_baru'];

$update = mysqli_query($_CONNEC, "UPDATE pesanan SET status_pesanan = '$status' WHERE id = '$id'");

if ($update) {
    header("Location: ../detail_pesanan.php?id=$id");
} else {
    header("Location: ../data_pesanan.php");
}
?>