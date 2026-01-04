<?php

$_DB_HOST = "mysql";
$_DB_NAME = "app_db";
$_DB_USERNAME = "root";
$_DB_PASSWORD = "root";

$_CONNEC = mysqli_connect(
    $_DB_HOST,
    $_DB_USERNAME,
    $_DB_PASSWORD,
    $_DB_NAME
);

if ($_CONNEC) {
    // echo "Koneksi DATABASE berhasil 💖";
} else {
    echo "<p class='popup-error'>Koneksi gagal DATABASE : " . mysqli_connect_error() . "</p>";
}
