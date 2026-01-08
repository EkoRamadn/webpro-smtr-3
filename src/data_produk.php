<?php
require "./logic/koneksi.php";

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ./login.php");
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./beranda.php");
    exit;
}

$query_produk = mysqli_query($_CONNEC, "SELECT produk.*, kategori.name as nama_kategori 
                              FROM produk 
                              JOIN kategori ON produk.kategori_id = kategori.id 
                              ORDER BY produk.id DESC");
$query_kategori_list = mysqli_query($_CONNEC, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./style/dashboard.css" />

    <style>
        .no-data-message {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #151419;
            border: 1px solid #27272a;
            border-radius: 12px;
            margin-top: 20px;
            color: #a1a1aa;
        }
    </style>

</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title"><img class="icon" src="../public/icon/material-symbols--menu.png">
                <p class="title_header">Data Produk</p>
            </div>
            <div class="frame_button">
                <a href="beranda.php">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--store.png">
                        <p class="button_text">Store</p>
                    </div>
                </a>
                <a href="./logic/logout.php">
                    <div class="button_header">
                        <img class="icon" src="../public/icon/material-symbols--logout.png" alt="icon_logout" />
                        <p class="button_text">Logout</p>
                    </div>
                </a>
            </div>
        </div>

        <hr style="width: 100%; color: #3f3f3f" />

        <div class="frame_tengah">
            <div class="sidebar">
                <a href="dashboard.php">
                    <div class="sidebar_menu"><img class="icon" src="../public/icon/material-symbols--dashboard.png">
                        <p class="button_text">Dashboard</p>
                    </div>
                </a>
                <a href="data_produk.php">
                    <div class="sidebar_menu_active"><img class="icon" src="../public/icon/gridicons--product.png">
                        <p class="button_text">Data Produk</p>
                    </div>
                </a>
                <a href="data_pesanan.php">
                    <div class="sidebar_menu"><img class="icon" src="../public/icon/lets-icons--order.png">
                        <p class="button_text">Data Pesanan</p>
                    </div>
                </a>
            </div>

            <div class="content">
                <div class="header-tools">
                    <div class="search-group">
                        <input type="text" id="inputSearch" class="input-search" placeholder="Cari Produk / Kategori"
                            style="text-transform: capitalize;">
                        <button type="button" class="btn-cari" id="searchBtn">
                            <img id="searchIcon" class="icon" src="../public/icon/mdi--magnify.png">
                        </button>
                    </div>

                    <button onclick="bukaModalTambah()" class="btn-actions">
                        <img class="icon" src="../public/icon/material-symbols--add-ad-outline.png">
                        <span>Tambah Produk</span>
                    </button>
                </div>

                <div class="rounded-border" id="tableContainer">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabelProduk">
                            <?php while ($row = mysqli_fetch_assoc($query_produk)): ?>
                                <tr>
                                    <td>
                                        <?php $img = $row['gambar'] ? $row['gambar'] : 'https://placehold.co/50'; ?>
                                        <img src="<?= $img ?>" onclick="bukaModalImage(this.src)"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; cursor: pointer; transition: 0.2s;"
                                            onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">
                                    </td>
                                    <td class="col-nama"><?= $row['nama']; ?></td>
                                    <td class="col-kategori"><?= $row['nama_kategori']; ?></td>
                                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td><?= $row['stok']; ?> pcs</td>

                                    <td style="text-align: center;">
                                        <div class="action-dropdown">
                                            <button onclick="toggleDropdown('menu-<?= $row['id'] ?>')" class="btn-kebab">
                                                <img src="../public/icon/lucide--ellipsis.png" style="width: 20px">
                                            </button>

                                            <div id="menu-<?= $row['id'] ?>" class="dropdown-menu">

                                                <button class="dropdown-item" onclick="bukaModal(
                                                '<?= $row['id'] ?>',
                                                '<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>',
                                                '<?= $row['kategori_id'] ?>',
                                                '<?= $row['harga'] ?>',
                                                '<?= $row['stok'] ?>',
                                                '<?= htmlspecialchars($row['gambar'], ENT_QUOTES) ?>', 
                                                `<?= str_replace('`', '\`', htmlspecialchars($row['deskripsi'], ENT_QUOTES)) ?>`
                                                )">
                                                    <img src="../public/icon/tabler--edit.png">
                                                    Edit
                                                </button>

                                                <button class="dropdown-item"
                                                    onclick="konfirmasiHapus('<?= $row['id']; ?>')">
                                                    <img src="../public/icon/tabler--trash.png">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div id="noDataMessage" class="no-data-message" style="display: none;">
                    <img src="../public/icon/mdi--magnify.png" style="width: 48px; opacity: 0.3; margin-bottom: 10px;">
                    <p>Data tidak ditemukan</p>
                </div>

            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalEdit">
        <div class="form-card" style="width: 800px; max-width: 95%;">
            <h2
                style="margin-top: 0; margin-bottom: 25px; font-size: 20px; font-weight: 600; border-bottom: 1px solid #3f3f3f; padding-bottom: 15px;">
                Form Produk</h2>

            <form id="formProduk" action="logic/update_produk.php" method="POST">
                <input type="hidden" name="id" id="edit_id">

                <div style="display: grid; grid-template-columns: 220px 1fr; gap: 30px; align-items: start;">

                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div
                            style="width: 100%; aspect-ratio: 1/1; background: #202024; border-radius: 8px; border: 1px dashed #3f3f3f; overflow: hidden; position: relative; display: flex; align-items: center; justify-content: center;">
                            <img id="preview" src="" alt=""
                                style="width: 100%; height: 100%; object-fit: cover; display: none;">

                            <div id="placeholderIcon"
                                style="text-align: center; color: #71717a; display: flex; flex-direction: column; align-items: center;">
                                <img src="../public/icon/material-symbols--image-outline.png"
                                    style="width: 48px; opacity: 0.5;">
                                <p style="font-size: 12px; margin-top: 8px;">Preview Image</p>
                            </div>
                        </div>

                        <div class="form-group" style="margin:0;">
                            <label class="label-text">Link Gambar (URL)</label>
                            <input type="text" name="gambar" id="fileInput" class="input-box"
                                placeholder="Paste link https://..." oninput="previewGambar(this)" autocomplete="off">
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 20px;">

                        <div class="form-group" style="margin:0;">
                            <label class="label-text">Nama Produk</label>
                            <input type="text" name="nama" id="edit_nama" class="input-box"
                                placeholder="Contoh: Kemeja Batik" required>
                        </div>

                        <div class="form-group" style="margin:0;">
                            <label class="label-text">Kategori</label>

                            <select name="kategori_id" id="edit_kategori" class="input-box" required
                                style="cursor: pointer;"
                                onchange="this.classList.toggle('has-value', this.value !== '')">
                                <option value="" style="color: #a1a1aa;">Pilih Kategori</option>
                                <?php mysqli_data_seek($query_kategori_list, 0);
                                while ($kat = mysqli_fetch_assoc($query_kategori_list)): ?>
                                    <option value="<?= $kat['id'] ?>">
                                        <?= $kat['name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group" style="margin:0;">
                                <label class="label-text">Harga (Rp)</label>
                                <input type="text" name="harga" id="edit_harga" class="input-box" placeholder="0"
                                    required onkeyup="formatRupiah(this)">
                            </div>
                            <div class="form-group" style="margin:0;">
                                <label class="label-text">Stok</label>
                                <input type="number" name="stok" id="edit_stok" class="input-box" placeholder="0"
                                    required>
                            </div>
                        </div>

                        <div class="form-group" style="margin:0;">
                            <label class="label-text">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="input-box"
                                style="height: 120px; resize: none; line-height: 1.5;"
                                placeholder="Tulis deskripsi produk di sini..."></textarea>
                        </div>

                    </div>
                </div>

                <div
                    style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 30px; padding-top: 20px; border-top: 1px solid #3f3f3f;">
                    <button type="button" class="btn-actions" onclick="tutupModal()" style="background-color: black;">
                        Batal
                    </button>
                    <button type="button" class="btn-actions" onclick="konfirmasiSimpan()" style="color: black">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalImageZoom" style="z-index: 1000; backdrop-filter: blur(5px);"
        onclick="tutupModalImage()">
        <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;">
            <img id="imgFullPreview" src=""
                style="max-width: 90%; max-height: 90vh; object-fit: contain; border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); cursor: zoom-out;">
        </div>
    </div>

    <div class="modal-overlay" id="modalConfirm" style="z-index: 2000;">
        <div class="form-card" style="width: 400px; max-width: 90%; height: auto; padding: 40px;">

            <h3 style="margin-top: 0; margin-bottom: 12px; font-size: 22px; font-weight: 600; color: white;">
                Konfirmasi
            </h3>

            <p id="confirmMessage" style="color: #a1a1aa; margin: 0 0 30px 0; font-size: 15px; line-height: 1.5;">
                Apakah Anda yakin?
            </p>

            <div style="display: flex; gap: 12px; justify-content: end;">

                <button onclick="tutupConfirm()" class="btn-actions" style="background-color: black;">
                    Batal
                </button>

                <button id="btnConfirmYes" class="btn-actions" style="color: black;">
                    Ya, Lanjutkan
                </button>

            </div>
        </div>
    </div>

    <script>
        const tableContainer = document.getElementById('tableContainer');
        const inputSearch = document.getElementById('inputSearch');
        const iconSearch = document.getElementById('searchIcon');
        const btnSearchAction = document.getElementById('searchBtn');
        const rows = document.querySelectorAll('#tabelProduk tr');
        const noDataMsg = document.getElementById('noDataMessage');

        inputSearch.addEventListener('keyup', function () {
            const val = this.value.toLowerCase();
            let visibleCount = 0;

            if (val.length > 0) {
                iconSearch.src = "../public/icon/material-symbols--close.png";
                btnSearchAction.style.cursor = "pointer";
                btnSearchAction.onclick = () => {
                    inputSearch.value = '';
                    inputSearch.dispatchEvent(new Event('keyup'));
                };
            } else {
                iconSearch.src = "../public/icon/mdi--magnify.png";
                btnSearchAction.style.cursor = "default";
                btnSearchAction.onclick = null;
            }

            rows.forEach(row => {
                const nama = row.querySelector('.col-nama').innerText.toLowerCase();
                const kategori = row.querySelector('.col-kategori').innerText.toLowerCase();

                if (nama.includes(val) || kategori.includes(val)) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            if (visibleCount === 0) {
                tableContainer.style.display = 'none';
                noDataMsg.style.display = 'flex';
            } else {
                tableContainer.style.display = 'block';
                noDataMsg.style.display = 'none';
            }
        });

        const modalEdit = document.getElementById('modalEdit');
        const imgPreview = document.getElementById('preview');
        const formProduk = document.getElementById('formProduk');
        const placeholder = document.getElementById('placeholderIcon');

        function bukaModalTambah() {
            formProduk.action = 'logic/simpan_produk.php';
            document.getElementById('edit_id').value = '';
            document.getElementById('edit_nama').value = '';
            document.getElementById('edit_kategori').selectedIndex = 0;
            document.getElementById('edit_harga').value = '';
            document.getElementById('edit_stok').value = '';
            document.getElementById('edit_deskripsi').value = '';
            document.getElementById('fileInput').value = '';
            imgPreview.src = '';
            imgPreview.style.display = 'none';
            placeholder.style.display = 'flex';
            modalEdit.style.display = 'flex';
        }

        function bukaModal(id, nama, kategori, harga, stok, gambar, deskripsi) {
            formProduk.action = 'logic/update_produk.php';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_deskripsi').value = deskripsi;

            let hargaFormatted = harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            document.getElementById('edit_harga').value = hargaFormatted;

            const selectKat = document.getElementById('edit_kategori');
            if (selectKat.value !== "") {
                selectKat.classList.add('has-value');
            } else {
                selectKat.classList.remove('has-value');
            }

            const inputGambar = document.getElementById('fileInput');
            if (inputGambar) {
                inputGambar.value = gambar;
            }

            const imgPreview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholderIcon');

            if (imgPreview && placeholder) {
                if (gambar && gambar !== "") {
                    imgPreview.src = gambar;
                    imgPreview.style.display = 'block';
                    placeholder.style.display = 'none';

                    imgPreview.onerror = function () {
                        imgPreview.style.display = 'none';
                        placeholder.style.display = 'flex';
                    };
                } else {
                    imgPreview.src = '';
                    imgPreview.style.display = 'none';
                    placeholder.style.display = 'flex';
                }
            }

            // 4. Munculin Modal
            const modalEdit = document.getElementById('modalEdit');
            if (modalEdit) {
                modalEdit.style.display = 'flex';
            }
        }

        function tutupModal() { modalEdit.style.display = 'none'; }

        function previewGambar(input) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholderIcon');
            const url = input.value;

            if (url.length > 0) {
                preview.src = url;
                preview.style.display = 'block';
                placeholder.style.display = 'none';

                preview.onerror = function () {
                    preview.style.display = 'none';
                    placeholder.style.display = 'flex';
                };
            } else {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'flex';
            }
        }

        const modalImageZoom = document.getElementById('modalImageZoom');
        const imgFullPreview = document.getElementById('imgFullPreview');

        function bukaModalImage(src) {
            imgFullPreview.src = src;
            modalImageZoom.style.display = 'flex';
        }

        function tutupModalImage() {
            modalImageZoom.style.display = 'none';
            setTimeout(() => { imgFullPreview.src = ''; }, 200);
        }

        const modalConfirm = document.getElementById('modalConfirm');
        const btnConfirmYes = document.getElementById('btnConfirmYes');
        const confirmMessage = document.getElementById('confirmMessage');
        let actionType = '';
        let targetUrl = '';

        function konfirmasiHapus(id) {
            actionType = 'delete';
            targetUrl = 'logic/hapus_produk.php?id=' + id;
            confirmMessage.innerText = "Yakin ingin menghapus data ini secara permanen?";
            modalConfirm.style.display = 'flex';
        }

        function konfirmasiSimpan() {
            const form = document.getElementById('formProduk');
            if (form.checkValidity()) {
                actionType = 'submit';
                confirmMessage.innerText = "Pastikan data sudah benar. Simpan perubahan?";
                modalConfirm.style.display = 'flex';
            } else {
                form.reportValidity();
            }
        }

        function tutupConfirm() { modalConfirm.style.display = 'none'; }

        btnConfirmYes.onclick = function () {
            if (actionType === 'delete') {
                window.location.href = targetUrl;
            } else if (actionType === 'submit') {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'simpan';
                hiddenInput.value = '1';
                document.getElementById('formProduk').appendChild(hiddenInput);
                document.getElementById('formProduk').submit();
            }
        }

        function toggleDropdown(id) {
            const allMenus = document.getElementsByClassName("dropdown-menu");
            for (let i = 0; i < allMenus.length; i++) {
                if (allMenus[i].id !== id) {
                    allMenus[i].classList.remove('show');
                }
            }
            document.getElementById(id).classList.toggle("show");
        }

        window.onclick = function (e) {
            if (e.target == modalEdit) tutupModal();
            if (e.target == modalImageZoom) tutupModalImage();
            if (e.target == modalConfirm) tutupConfirm();
            if (!e.target.closest('.action-dropdown')) {
                const allMenus = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < allMenus.length; i++) {
                    allMenus[i].classList.remove('show');
                }
            }
        }

        function formatRupiah(input) {
            let value = input.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            input.value = rupiah;
        }

    </script>
</body>

</html>