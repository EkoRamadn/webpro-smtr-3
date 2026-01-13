<?php
require "koneksi.php";
session_start();

if ($_SESSION['role'] !== 'kurir') {
    header("Location: ../login.php");
    exit;
}

$id_pesanan = $_POST['id'];
$id_kurir = $_SESSION['user_id'];
$nama_kurir = $_SESSION['username'];

$query = "UPDATE pesanan 
          SET kurir_id = '$id_kurir', nama_kurir = '$nama_kurir' 
          WHERE id = '$id_pesanan' AND (kurir_id IS NULL OR kurir_id = '')";

mysqli_query($_CONNEC, $query);

if (mysqli_affected_rows($_CONNEC) > 0) {
    header("Location: ../mobile_kurir.php");
} else {
    echo "<script>
        alert('Maaf, paket sudah diambil kurir lain!');
        window.location.href = '../mobile_kurir.php';
    </script>";
}