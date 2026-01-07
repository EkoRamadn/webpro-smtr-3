<?php
require "koneksi.php";
$id = $_POST['id'];
$status = $_POST['status_baru'];

mysqli_query($_CONNEC, "UPDATE pesanan SET status_pesanan = '$status' WHERE id = '$id'");

if ($status == 'Dikonfirmasi') {
    header("Location: ../detail_pesanan.php?id=" . $id);
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
?>