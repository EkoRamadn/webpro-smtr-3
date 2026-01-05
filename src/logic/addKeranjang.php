<?php
require "koneksi.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../template/peringatan.php?pesan=Login Terlebih Dahulu&kembali=../login.html&lanjut=../login.html&tipe=link");
    exit;
}

$user_id = $_SESSION["user_id"];
$produk_id = $_POST["produk_id"];
$total_produk = $_POST["total_produk"];
$oks = $_POST["oks"];

$sql = "SELECT id FROM keranjang 
        WHERE user_id = $user_id 
        AND status = 'aktif' 
        LIMIT 1";

$res = mysqli_query($_CONNEC, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $keranjang_id = $row["id"];
} else {
    $sql1 = "INSERT INTO keranjang (user_id, status) 
             VALUES ($user_id, 'aktif')";

    $insert = mysqli_query($_CONNEC, $sql1);

    if ($insert) {
        $keranjang_id = mysqli_insert_id($_CONNEC);
    } else {
        // die("Gagal membuat keranjang baru");
        header("Location: $oks?status=gagal");
    }
}

$sqlCheck = "SELECT id, total_produk FROM keranjang_produk 
             WHERE keranjang_id = $keranjang_id 
             AND produk_id = $produk_id
             LIMIT 1";

$checkRes = mysqli_query($_CONNEC, $sqlCheck);

if ($checkRes && mysqli_num_rows($checkRes) > 0) {
    $row = mysqli_fetch_assoc($checkRes);
    $newTotal = $row["total_produk"] + $total_produk;

    $sqlUpdate = "UPDATE keranjang_produk 
                  SET total_produk = $newTotal 
                  WHERE id = " . $row["id"];

    mysqli_query($_CONNEC, $sqlUpdate);

    // echo "UPDATE: jumlah produk sekarang = $newTotal";
    header("Location: $oks?status=berhasil");

} else {
    $sqlInsert = "INSERT INTO keranjang_produk (keranjang_id, produk_id, total_produk) 
                  VALUES ($keranjang_id, $produk_id, $total_produk)";
    mysqli_query($_CONNEC, $sqlInsert);

    // echo "INSERT: produk baru ditambahkan ke keranjang";
    header("Location: $oks?status=berhasil");
}
?>