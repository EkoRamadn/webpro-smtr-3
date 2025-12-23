<?php

$host = 'mysql';
$user = 'root';
$password = 'root';
$db = 'batik';

$connect = mysqli_connect($host, $user, $password, $db);
if (!$connect) {
    die('gagal' . mysqli_connect_error());
}