

# UMKM Batik - E-Commerce Web Application

![Banner Project](public/img/thumb.jpg) **UMKM Batik** adalah platform *E-Commerce* berbasis web yang dikembangkan untuk membantu UMKM (Usaha Mikro, Kecil, dan Menengah) memasarkan produk batik secara digital. Proyek ini dibangun menggunakan **PHP Native** tanpa framework, dengan fokus pada pemahaman logika dasar pemrograman web, manajemen database, dan *deployment* otomatis.

Proyek ini diajukan sebagai tugas **UAS Web Programming Semester 3**.

---

## 🌟 Fitur Utama

Sistem ini memiliki dua peran pengguna (*Multi-Role*): **Admin** dan **User (Pelanggan)**.

### 🛍️ Halaman Pelanggan (User)
* **Autentikasi**: Registrasi akun baru dan Login (Session management).
* **Katalog Produk**: Melihat daftar produk batik dengan gambar dan harga.
* **Detail Produk**: Informasi lengkap mengenai produk.
* **Keranjang Belanja (*Shopping Cart*)**: Menambah produk ke keranjang, mengubah jumlah, dan menghapus item.
* **Checkout**: Memproses pesanan dengan mengisi data pengiriman.
* **Riwayat Pesanan**: Memantau status pesanan (*Menunggu Pembayaran, Dikemas, Dikirim, Selesai*).

### 👨‍💻 Halaman Admin
* **Dashboard Analitik**:
    * Ringkasan **Total Pemasukan** (dari pesanan selesai).
    * Counter **Pesanan Perlu Diproses** (Pending/Dikemas).
    * Peringatan **Stok Menipis** (Stok <= 10 item).
    * Total jumlah produk aktif.
* **Manajemen Produk**: Tambah, Edit, Hapus, dan Update Stok Produk.
* **Manajemen Pesanan (`data_pesanan.php`)**:
    * Melihat seluruh daftar pesanan masuk.
    * Pencarian pesanan berdasarkan **No. Pesanan** atau **Nama Pelanggan**.
    * **Konfirmasi Pesanan**: Fitur modal untuk melihat detail pengiriman dan mengubah status dari *Menunggu Pembayaran* menjadi *Dikonfirmasi*.

---

## 🛠️ Teknologi yang Digunakan

* **Backend**: PHP 8.x (Native / Procedural style)
* **Database**: MySQL / MariaDB
* **Frontend**:
    * HTML5 & CSS3 (Custom CSS, responsive layout)
    * Google Fonts (Inter Family)
    * JavaScript (DOM Manipulation untuk modal & pencarian realtime)
* **Server**: Apache (via XAMPP/Laragon)
* **CI/CD**: GitHub Actions (FTP Deploy)

---

## 📂 Struktur Folder

```text
webpro-smtr-3-uas-kelompok/
├── .github/
│   └── workflows/
│       └── deploy.yml      # Konfigurasi Auto-Deploy ke FTP Server
├── database/
│   └── uas-kelompok.sql  # Skema Database
├── public/                 # Aset statis (Gambar, Icon, Font)
│   ├── font/
│   ├── icon/
│   └── img/
├── src/                    # Source Code Utama
│   ├── logic/              # Backend Logic (CRUD, Auth, Connection)
│   │   ├── koneksi.php     # Auto-detect Localhost vs Live Server
│   │   ├── login.php
│   │   ├── register.php
│   │   └── ...
│   ├── style/              # File CSS
│   ├── template/           # Komponen UI (Header, Card, Modal)
│   ├── beranda.php         # Halaman Utama User
│   ├── dashboard.php       # Halaman Utama Admin
│   ├── data_pesanan.php    # Manajemen Pesanan
│   └── ...
├── index.php               # Entry point (Redirect ke Login)
└── README.md               # Dokumentasi Proyek

```

---

## 🚀 Cara Instalasi & Menjalankan (Localhost)

Ikuti langkah ini untuk menjalankan proyek di komputer lokal:

### 1. Persiapan

Pastikan komputer Anda sudah terinstall **XAMPP** atau **Laragon**.

### 2. Clone Repository

Simpan folder proyek di dalam direktori server lokal (`htdocs` atau `www`).

```bash
git clone https://github.com/EkoRamadn/webpro-smtr-3.git

```

### 3. Import Database

1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Buat database baru dengan nama: **`uas-kelompok`**.
3. Pilih tab **Import**.
4. Upload file: `database/uas-kelompok.sql`.
5. Klik **Go**.

### 4. Konfigurasi Koneksi

Sistem memiliki fitur *Auto-Failover* pada `src/logic/koneksi.php`. Secara default, sistem akan mencoba koneksi ke server live terlebih dahulu. Jika gagal (internet mati/localhost), sistem otomatis beralih ke pengaturan lokal:

```php
$_DB_HOST_2 = "localhost"; 
$_DB_USERNAME_2 = "root";
$_DB_PASSWORD_2 = "";
$_DB_NAME_2 = "Batik"; 

```

### 5. Akses Website

Buka browser dan kunjungi:
`http://localhost`

---

## 🌐 Deployment (CI/CD)

Proyek ini dilengkapi dengan **GitHub Actions** untuk deployment otomatis.
Setiap kali ada `push` ke branch `uas-kelompok`, kode akan otomatis diunggah ke server hosting via FTP.

**Konfigurasi Workflow (`.github/workflows/deploy.yml`):**

* **Trigger**: Push ke branch `uas-kelompok`
* **Action**: `SamKirkland/FTP-Deploy-Action`
* **Target**: Direktori `/htdocs/` pada server FTP.
* **Excluded Files**: `.git`, `.github`, `database`, `README.md` tidak akan di-upload untuk keamanan dan efisiensi.

Untuk mengaktifkan fitur ini, tambahkan *Repository Secrets* di GitHub:

* `FTP_HOST`
* `FTP_USERNAME`
* `FTP_PASSWORD`
* `FTP_PORT`

---

## 👥 Tim Pengembang

Kelompok Web Programming Semester 3:

1. **Handika Rado Arganata**
2. **Cahyo Saputra**
3. **Dimas Akbar Maulana**
4. **Eko Ramadani**

---

*Copyright © 2026 UMKM Batik. All Rights Reserved.*
