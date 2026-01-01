CREATE TABLE `produk` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(255),
  `deskripsi` text,
  `kategori_id` int,
  `harga` int,
  `stok` int,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `user` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255),
  `password` text,
  `nama_lengkap` varchar(255),
  `alamat` text,
  `no_hp` varchar(255),
  `role` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `kategori` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `slug` varchar(255) UNIQUE
);

CREATE TABLE `keranjang` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `status` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `keranjang_produk` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `keranjang_id` int,
  `produk_id` int,
  `total_produk` int
);

CREATE TABLE `pesanan` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `no_pesanan` varchar(255) UNIQUE,
  `user_id` int,
  `total_pesanan` int,
  `status_pesanan` varchar(255),
  `pembayaran` varchar(255),
  `alamat` text,
  `nama` varchar(255),
  `no_hp` varchar(255),
  `created_at` datetime
);

CREATE TABLE `pesanan_produk` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `pesanan_id` int,
  `produk_id` int,
  `produk_nama` varchar(255),
  `produk_harga` int,
  `total_produk` int,
  `total_harga` int
);

CREATE UNIQUE INDEX `keranjang_produk_index_0` ON `keranjang_produk` (`keranjang_id`, `produk_id`);

ALTER TABLE `produk` ADD FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

ALTER TABLE `keranjang` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `keranjang_produk` ADD FOREIGN KEY (`keranjang_id`) REFERENCES `keranjang` (`id`);

ALTER TABLE `keranjang_produk` ADD FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

ALTER TABLE `pesanan` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `pesanan_produk` ADD FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`);

ALTER TABLE `pesanan_produk` ADD FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
