<?php
$pesan = isset($_GET["pesan"]) ? $_GET["pesan"] : "Pesan tidak tersedia";
$kembali = isset($_GET["kembali"]) ? $_GET["kembali"] : "#";
$lanjut = isset($_GET["lanjut"]) ? $_GET["lanjut"] : "#";
$tipe = isset($_GET["tipe"]) ? $_GET["tipe"] : "peringatan";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link rel="stylesheet" href="../style/popup.css">
</head>

<body>
    <div class="content-popup fade-slide <?= $tipe ?>">
        <div class="icon">

        </div>
        <h1 class="title"><?= ucfirst($tipe) ?></h1>
        <p><?= htmlspecialchars($pesan) ?></p>

        <form action="<?= htmlspecialchars($lanjut) ?>" method="POST">
            <div class="btn-grub">
                <a href="<?= htmlspecialchars($kembali) ?>" class="btn-back">Kembali</a>
                <?php if ($tipe === 'link') { ?>
                    <a href="<?= htmlspecialchars($kembali) ?>" class="btn-back">Kembali</a>
                <?php } else { ?>
                    <button type="submit" class="btn-next">Lanjut</button>
                <?php } ?>
            </div>
        </form>
    </div>
</body>

</html>