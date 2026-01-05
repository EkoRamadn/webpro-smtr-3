<?php
mysqli_report(MYSQLI_REPORT_OFF); //garis besar

$_DB_HOST_1 = "sql100.infinityfree.com";
$_DB_NAME_1 = "if0_40805394_batik_db";
$_DB_USERNAME_1 = "if0_40805394";
$_DB_PASSWORD_1 = "5AkRyVR1BGwtZ";

$_DB_HOST_2 = "mysql";
$_DB_NAME_2 = "app_db";
$_DB_USERNAME_2 = "root";
$_DB_PASSWORD_2 = "root";

$_CONNEC = @mysqli_connect(
    $_DB_HOST_1,
    $_DB_USERNAME_1,
    $_DB_PASSWORD_1,
    $_DB_NAME_1
);
$MODE = "";

if (!$_CONNEC) {

    $_CONNEC = @mysqli_connect($_DB_HOST_2, $_DB_USERNAME_2, $_DB_PASSWORD_2, $_DB_NAME_2);

    if (!$_CONNEC) {
        $KONEKSI_MESSAGE = " Semua koneksi gagal: " . mysqli_connect_error();
        $MODE = "err";
    } else {
        $KONEKSI_MESSAGE = " Koneksi utama gagal, memakai koneksi cadangan.";
        $MODE = "dev";
    }
}