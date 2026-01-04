<?php
require "koneksi.php";

$sql = "SELECT name FROM ";
$kategorires = mysqli_query($_CONNEC, $sql);
