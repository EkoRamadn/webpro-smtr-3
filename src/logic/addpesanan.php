<?php
session_start();
require "koneksi.php";

$keranjang_id = $_POST['id'];
$total_pesanan = $_POST['total_pesanan'];
$user_id = $_SESSION['user_id'];
$fullname = $_POST['fullname'];
$alamat = $_POST['addres'];
$no_hp = $_POST['no_hp'];
$pembayaran = $_POST['metode'];
date_default_timezone_set('Asia/Jakarta');
$created_at = date('Y-m-d H:i:s');

$sql = "SELECT kp.*, p.nama, p.harga, p.gambar, p.stok
        FROM keranjang k
        INNER JOIN keranjang_produk kp ON k.id = kp.keranjang_id
        INNER JOIN produk p ON kp.produk_id = p.id
        WHERE k.id = $keranjang_id";

$resdata1 = mysqli_query($_CONNEC, $sql) or die("SQL Error: " . mysqli_error($_CONNEC));

// if (mysqli_num_rows($resdata1) === 0) {
//     die("Keranjang kosong");
// }

$stok_tidak_cukup = [];
$produk_data = [];

while ($row = mysqli_fetch_assoc($resdata1)) {
    $produk_data[] = $row;
    if ($row['stok'] < $row['total_produk']) {
        $stok_tidak_cukup[] = $row['nama'];
    }
}


if (count($stok_tidak_cukup) > 0) {
    $pesan = "Stok tidak cukup untuk produk: " . implode(", ", $stok_tidak_cukup) . "pesanan gagal dibuat";
    // die($pesan); 
    header("Location: ../template/peringatan.php?pesan=$pesan&lanjut=../keranjang.php&kembali=../keranjang.php");
    exit();
}


$no_pesanan = "PC00" . $user_id . $keranjang_id;

if ($pembayaran == 'cod') {
    $status_awal = 'Menunggu Konfirmasi';
} else {
    $status_awal = 'Menunggu Pembayaran';
}

$sql1 = "INSERT INTO pesanan
        (no_pesanan, user_id, total_pesanan, status_pesanan, pembayaran, nama, alamat, no_hp, created_at)
        VALUES
        ('$no_pesanan', '$user_id', '$total_pesanan', '$status_awal', '$pembayaran', '$fullname', '$alamat', '$no_hp','$created_at')";

$respesanan = mysqli_query($_CONNEC, $sql1) or die("SQL Error: " . mysqli_error($_CONNEC));
$pesanan_id = mysqli_insert_id($_CONNEC);


foreach ($produk_data as $row) {

    $produk_id = $row['produk_id'];
    $produk_nama = $row['nama'];
    $jumlah = $row['total_produk'];
    $harga = $row['harga'];
    $subtotal = $jumlah * $harga;

    $insert_produk = "INSERT INTO pesanan_produk 
        (pesanan_id, produk_id, produk_nama, produk_harga, total_produk, total_harga)
        VALUES 
        ('$pesanan_id', '$produk_id', '$produk_nama', '$harga', '$jumlah', '$subtotal')";

    mysqli_query($_CONNEC, $insert_produk) or die("SQL Error: " . mysqli_error($_CONNEC));

    $stok_baru = $row['stok'] - $jumlah;
    $update_stok = "UPDATE produk SET stok = $stok_baru WHERE id = $produk_id";
    mysqli_query($_CONNEC, $update_stok) or die("SQL Error: " . mysqli_error($_CONNEC));
}

$sql_cleanup = "UPDATE keranjang SET status = 'checkout', updated_at = NOW() WHERE id = $keranjang_id";
mysqli_query($_CONNEC, $sql_cleanup) or die("Gagal update keranjang: " . mysqli_error($_CONNEC));

header("Location: ../template/status-pesanan.php?id=$pesanan_id");
exit;
