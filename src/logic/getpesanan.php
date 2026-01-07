<?php
// session_start();
require "koneksi.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT id,no_pesanan,total_pesanan,status_pesanan FROM pesanan WHERE user_id=$user_id";

$respesanan = mysqli_query($_CONNEC, $sql);