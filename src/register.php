<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: ./beranda.php");
}

$status = $_GET["status"] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./style/login.css">
</head>

<body>
    <div class="container no-select">
        <div class="content-form fade-slide">
            <?php
            if ($status !== '') {
                echo '<p class="notif-gagal">' . $status . '</p>';
            }
            ?>
            <div class="head">
                <h1 class="title">REGISTRASI</h1>
                <p class="subtitle">Bergabunglah dan nikmati pengalaman berbelanja batik dengan pilihan terbaik kami.
                </p>
            </div>

            <form action="./logic/register.php" method="POST">
                <div class="input-grub">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-grub">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" id="fullname">
                </div>
                <div class="input-grub">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <button type="button" class="toggle-password">Show</button>
                </div>
                <div class="input-grub">
                    <label for="addres">Alamat</label>
                    <input type="text" name="addres" id="addres">
                </div>
                <div class="input-grub">
                    <label for="no_tlp">Np. HP</label>
                    <input type="number" name="no_tlp" id="no_tlp">
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p class="sign">Have an account?<a href="./login.php" class="clr-secan">Login Now.</a></p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.input-grub').forEach(group => {
            const input = group.querySelector('input');

            const updateState = () => {
                if (
                    document.activeElement === input ||
                    group.matches(':hover') ||
                    input.value.trim() !== ''
                ) {
                    group.classList.add('active');
                } else {
                    group.classList.remove('active');
                }
            };

            input.addEventListener('focus', updateState);
            input.addEventListener('blur', updateState);
            input.addEventListener('input', updateState);
            group.addEventListener('mouseenter', updateState);
            group.addEventListener('mouseleave', updateState);

            updateState();
        });

        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling;

                if (input.type === 'password') {
                    input.type = 'text';
                    btn.textContent = 'Hide';
                } else {
                    input.type = 'password';
                    btn.textContent = 'Show';
                }

                input.focus();
            });
        });
    </script>

</body>

</html>