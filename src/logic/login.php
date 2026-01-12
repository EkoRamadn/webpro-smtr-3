<?php
require "./koneksi.php";

session_start();

if (
    empty($_POST['username']) ||
    empty($_POST['password'])
) {
    header("Location: ../login.php?status=Username dan password wajib diisi.");
    // echo "<p class='popup-error'>Username dan password wajib diisi</p>";
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

$sql = "SELECT id, username, password, role, nama_lengkap 
        FROM user 
        WHERE username = '$username'
        LIMIT 1";

$res = mysqli_query($_CONNEC, $sql);

if (mysqli_num_rows($res) === 1) {

    $user = mysqli_fetch_assoc($res);

    if ($password === $user['password']) {

        session_regenerate_id(true);
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if (!empty($user['nama_lengkap'])) {
            $_SESSION['nama_kurir'] = $user['nama_lengkap'];
        } else {
            $_SESSION['nama_kurir'] = $user['username'];
        }

        if ($user['role'] == 'admin') {
            header("Location: ../dashboard.php");
        } elseif ($user['role'] == 'kurir') {
            header("Location: ../mobile_kurir.php");
        } else {
            header("Location: ../beranda.php");
        }
        exit;

    } else {
        // echo "<p class='popup-error'>Password salah </p>";
        header("Location: ../login.php?status=Password Salah.");
    }

} else {
    // echo "<p class='popup-error'>Username tidak ditemukan </p>";
    header("Location: ../login.php?status=Username tidak ditemukan.");
}
