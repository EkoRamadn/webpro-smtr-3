<?php
require "./logic/koneksi.php";

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
</head>

<body>
    <div class="frame_utama">
        <div class="frame_header">
            <div class="home_title"><img class="icon" src="../public/icon/material-symbols--menu.png">
                <p class="title_header">Data Produk</p>
            </div>
            <div class="frame_button">
                <a href="#">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--store.png">
                        <p class="button_text">Store</p>
                    </div>
                </a>
                <a href="index.php">
                    <div class="button_header"><img class="icon" src="../public/icon/material-symbols--logout.png">
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

                <div class="rounded-border">
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
                                        <?php $img = $row['gambar'] ? $row['gambar'] : 'default.png'; ?>
                                        <img src="../public/img/<?= $img ?>" onclick="bukaModalImage(this.src)"
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
                '<?= $row['id'] ?>', '<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>',
                '<?= $row['kategori_id'] ?>', '<?= $row['harga'] ?>',
                '<?= $row['stok'] ?>', '<?= $row['gambar'] ?>',
                `<?= htmlspecialchars($row['deskripsi'], ENT_QUOTES) ?>`
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
                    <div id="noDataMessage" class="no-data-message">
                        <img src="../public/icon/mdi--magnify.png"
                            style="width: 48px; opacity: 0.3; margin-bottom: 10px;">
                        <p>Data tidak ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalEdit">
        <div class="form-card" style="width: 600px;">
            <h2 style="margin-top: 0; margin-bottom: 30px; font-size: 20px; font-weight: 600;">Form Produk</h2>

            <form id="formProduk" action="logic/update_produk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">

                <div style="display: grid; grid-template-columns: 250px 1fr; gap: 40px; align-items: start;">

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="image-upload-container" onclick="document.getElementById('fileInput').click()">
                            <img id="preview" src="" alt="Preview">

                            <div class="placeholder-view" id="placeholderIcon">
                                <img src="../public/icon/material-symbols--image-outline.png" style="width: 48px">
                                <span style="font-size: 12px">Klik untuk meng-upload gambar</span>
                            </div>
                        </div>
                        <input type="file" name="gambar" id="fileInput" accept="image/*" onchange="previewGambar(this)">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 15px;">

                        <div class="form-group" style="margin:0;">
                            <label class="label-text">Nama Produk</label>
                            <input type="text" name="nama" id="edit_nama" class="input-box"
                                placeholder="Masukkan nama produk" required>
                        </div>

                        <div class="form-group" style="margin:0;">
                            <label class="label-text">Kategori</label>
                            <select name="kategori_id" id="edit_kategori" class="input-box" required>
                                <option value="">Pilih Kategori</option>
                                <?php mysqli_data_seek($query_kategori_list, 0);
                                while ($kat = mysqli_fetch_assoc($query_kategori_list)): ?>
                                    <option value="<?= $kat['id'] ?>"><?= $kat['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group" style="margin:0;">
                                <label class="label-text">Harga</label>
                                <input type="number" name="harga" id="edit_harga" class="input-box" placeholder="0"
                                    required>
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
                                style="height: 100px; resize: none;"
                                placeholder="Deskripsi singkat produk..."></textarea>
                        </div>

                    </div>
                </div>

                <div
                    style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 40px; border-top: 1px solid #3f3f3f; padding-top: 20px;">
                    <button type="button" onclick="tutupModal()"
                        style="background: transparent; border: 1px solid #3f3f3f; padding: 12px 24px; border-radius: 8px; color: white; cursor: pointer; font-weight: 500;">Batal</button>
                    <button type="button" onclick="konfirmasiSimpan()"
                        style="background: white; border: none; padding: 12px 24px; border-radius: 8px; color: black; cursor: pointer; font-weight: 600;">Simpan</button>
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
        <div class="form-card" style="max-width: 400px; height: auto; text-align: center;">
            <h3 style="margin-top: 0; color: white;">Konfirmasi</h3>
            <p id="confirmMessage" style="color: #a1a1aa; margin: 20px 0;">Apakah Anda yakin?</p>

            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="tutupConfirm()"
                    style="background: black; padding: 10px 20px; border-radius: 6px; color: white; border: none; cursor: pointer; font-weight: 600;">Batal</button>
                <button id="btnConfirmYes"
                    style="background: white; padding: 10px 20px; border-radius: 6px; color: black; border: none; font-weight: 600; cursor: pointer;">Ya,
                    Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        const inputSearch = document.getElementById('inputSearch');
        const iconSearch = document.getElementById('searchIcon');
        const btnSearchAction = document.getElementById('searchBtn');
        const rows = document.querySelectorAll('#tabelProduk tr');

        inputSearch.addEventListener('keyup', function () {
            const val = this.value.toLowerCase();
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
                } else {
                    row.style.display = "none";
                }
            });
        });

        const modalEdit = document.getElementById('modalEdit');
        const imgPreview = document.getElementById('preview');
        const formProduk = document.getElementById('formProduk');

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
            modalEdit.style.display = 'flex';

            const preview = document.getElementById('preview');
            preview.src = '';
            preview.style.display = 'none';

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
            if (gambar) { imgPreview.src = '../public/img/' + gambar; }
            else { imgPreview.src = ''; }
            modalEdit.style.display = 'flex';

            const preview = document.getElementById('preview');
            if (gambar && gambar !== "") {
                preview.src = '../public/img/' + gambar;
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
            modalEdit.style.display = 'flex';
        }

        function tutupModal() { modalEdit.style.display = 'none'; }

        function previewGambar(input) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholderIcon');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'flex';
            }
        }


        function bukaModal(id, nama, kategori, harga, stok, gambar, deskripsi) {
            formProduk.action = 'logic/update_produk.php';

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_deskripsi').value = deskripsi;


            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholderIcon');

            if (gambar && gambar !== "") {
                preview.src = '../public/img/' + gambar;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'flex';
            }
            modalEdit.style.display = 'flex';
        }

        function bukaModalTambah() {
            formProduk.action = 'logic/simpan_produk.php';
            document.getElementById('edit_id').value = '';
            document.getElementById('edit_nama').value = '';
            document.getElementById('edit_kategori').selectedIndex = 0;
            document.getElementById('edit_harga').value = '';
            document.getElementById('edit_stok').value = '';
            document.getElementById('edit_deskripsi').value = '';
            document.getElementById('fileInput').value = '';

            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholderIcon');

            preview.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'flex';

            modalEdit.style.display = 'flex';
        }

        function previewGambar(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
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

        window.onclick = function (e) {
            if (e.target == modalEdit) {
                tutupModal();
            }
            if (e.target == modalImageZoom) {
                tutupModalImage();
            }
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

        function tutupConfirm() {
            modalConfirm.style.display = 'none';
        }

        window.onclick = function (e) {
            if (e.target == modalEdit) tutupModal();
            if (e.target == modalImageZoom) tutupModalImage();
            if (e.target == modalConfirm) tutupConfirm();
        }

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
                noDataMsg.style.display = 'flex';
            } else {
                noDataMsg.style.display = 'none';
            }
        });

        function toggleDropdown(id) {
            const allMenus = document.getElementsByClassName("dropdown-menu");
            for (let i = 0; i < allMenus.length; i++) {
                if (allMenus[i].id !== id) {
                    allMenus[i].classList.remove('show');
                }
            }

            document.getElementById(id).classList.toggle("show");
        }

        window.addEventListener('click', function (e) {
            if (!e.target.closest('.action-dropdown')) {
                const allMenus = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < allMenus.length; i++) {
                    allMenus[i].classList.remove('show');
                }
            }
        });
    </script>
</body>

</html>