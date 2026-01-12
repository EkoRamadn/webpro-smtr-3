<?php
require "koneksi.php";

$id_pesanan = $_POST['id'];
$foto = $_FILES['bukti_kurir'];

if ($foto['error'] === 4) {
    header("Location: ../mobile_kurir.php");
    exit;
}

$ekstensi = pathinfo($foto['name'], PATHINFO_EXTENSION);
$nama_file_baru = "DELIVERY_" . time() . "_" . $id_pesanan . "." . $ekstensi;

$target_dir = "../../public/img/bukti_kirim/";
$target_file = $target_dir . $nama_file_baru;

if (move_uploaded_file($foto['tmp_name'], $target_file)) {

    $query = "UPDATE pesanan SET 
              status_pesanan = 'Selesai', 
              bukti_pengiriman = '$nama_file_baru' 
              WHERE id = '$id_pesanan'";

    $update = mysqli_query($_CONNEC, $query);

    if ($update) {
        header("Location: ../mobile_kurir.php?status=sukses");
    } else {
        echo "Gagal update database.";
    }

} else {
    echo "Gagal upload gambar.";
}
?>