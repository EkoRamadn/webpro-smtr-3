<?php
require "koneksi.php";
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] !== 'kurir') {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: beranda.php");
    }
    exit;
}

$id_pesanan = $_POST['id_pesanan'];

if (isset($_FILES['bukti_foto']) && $_FILES['bukti_foto']['error'] === 0) {

    $nama_file_asli = $_FILES['bukti_foto']['name'];
    $tmp_file = $_FILES['bukti_foto']['tmp_name'];
    $ukuran_file = $_FILES['bukti_foto']['size'];
    $ekstensi = strtolower(pathinfo($nama_file_asli, PATHINFO_EXTENSION));
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];

    if (in_array($ekstensi, $ekstensi_valid)) {
        $nama_baru = "BUKTI-" . $id_pesanan . "-" . time() . "." . $ekstensi;
        $folder_tujuan = "../../public/img/bukti_bayar/";
        $target_file = $folder_tujuan . $nama_baru;

        if (move_uploaded_file($tmp_file, $target_file)) {
            $query = "UPDATE pesanan SET 
                      bukti_pembayaran = '$nama_baru', 
                      status_pesanan = 'Menunggu Verifikasi' 
                      WHERE id = '$id_pesanan'";

            if (mysqli_query($_CONNEC, $query)) {
                header("Location: ../template/status-pesanan.php?id=$id_pesanan");
                exit;
            } else {
                echo "Gagal update database: " . mysqli_error($_CONNEC);
            }

        } else {
            echo "Gagal mengupload gambar. Cek permission folder public/img/bukti_bayar";
        }

    } else {
        echo "Format file tidak didukung! Hanya JPG, JPEG, dan PNG.";
    }

} else {
    header("Location: ../template/status-pesanan.php?id=$id_pesanan&error=nofile");
    exit;
}
?>