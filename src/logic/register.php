<?php
require "./koneksi.php";
session_start();

if (
    empty($_POST['username']) ||
    empty($_POST['fullname']) ||
    empty($_POST['password']) ||
    empty($_POST['addres']) ||
    empty($_POST['no_tlp'])
) {
    echo "<p class='popup-error'>Semua field wajib diisi</p>";
    exit;
}


$username = trim($_POST['username']);
$fullname = trim($_POST['fullname']);
$password_plain = $_POST['password'];
$address = trim($_POST['addres']);
$no_tlp = trim($_POST['no_tlp']);

$sql = "INSERT INTO user 
(username, password, nama_lengkap, alamat, no_hp, role) 
VALUES 
('$username', '$password_plain', '$fullname', '$address', '$no_tlp', 'user')";

$res = mysqli_query($_CONNEC, $sql);

if ($res) {
    $user_id = mysqli_insert_id($_CONNEC);

    session_regenerate_id(true);
    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'user';

    header("Location: ../beranda.php");
    exit;

} else {
    echo "Gagal menyimpan data  : " . mysqli_error($_CONNEC);
}
