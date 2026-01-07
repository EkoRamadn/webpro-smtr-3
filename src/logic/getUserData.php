<?php
// session_start();
require "koneksi.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT nama_lengkap,password,alamat,no_hp FROM user WHERE id=$user_id";

$resuser = mysqli_query($_CONNEC, $sql);

// var_dump(mysqli_fetch_assoc($res));