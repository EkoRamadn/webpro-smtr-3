<?php
require "koneksi.php";

$sql = "SELECT id,name FROM kategori";
$kategorires = mysqli_query($_CONNEC, $sql);