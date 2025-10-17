-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Okt 2025 pada 18.56
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_bisnis_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `pengirim` varchar(50) DEFAULT NULL,
  `penerima` varchar(50) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_produk`, `jumlah`, `harga`) VALUES
(1, 12, 13, 1, 99000),
(2, 13, 12, 2, 110000),
(3, 13, 13, 2, 99000),
(4, 29, 13, 1, 99000),
(5, 29, 12, 1, 110000),
(6, 29, 11, 1, 99000),
(7, 30, 12, 1, 110000),
(8, 30, 13, 1, 99000),
(9, 31, 13, 2, 99000),
(10, 31, 12, 2, 110000),
(11, 31, 11, 2, 99000),
(12, 32, 13, 1, 99000),
(13, 33, 11, 1, 99000),
(14, 33, 12, 1, 110000),
(15, 34, 11, 1, 99000),
(16, 34, 12, 1, 110000),
(17, 35, 13, 2, 99000),
(18, 35, 12, 1, 110000),
(19, 35, 11, 1, 99000),
(20, 36, 13, 1, 99000),
(21, 36, 11, 1, 99000),
(22, 37, 11, 3, 99000),
(23, 37, 12, 1, 110000),
(24, 38, 13, 1, 99000),
(25, 39, 12, 1, 110000),
(26, 40, 12, 1, 110000),
(27, 40, 11, 2, 99000),
(28, 40, 13, 6, 99000),
(29, 41, 13, 1, 99000),
(30, 42, 12, 1, 110000),
(31, 42, 13, 1, 99000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id`, `id_user`, `id_produk`, `jumlah`) VALUES
(74, 2, 12, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `kategori`) VALUES
(11, 'boneka beruang', 'boneka beruang yang lucu,mejadi simbol awal kesuksesan yang di gapai selama ini', 99000.00, 100, 'produk_1759672209.jpg', 'boneka'),
(12, 'Bunga Putih', 'bunga putih yang melambangkan suci pada jalan yang kita tempuh pada kesuksesan', 110000.00, 50, 'produk_1759673854.jpg', 'bunga'),
(13, 'UANG', 'Segala Kesuksesan akan tercapai jika ada uangnya hehee', 99000.00, 50, 'produk_1759850153.jpg', 'uang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `id` int(11) NOT NULL,
  `nama_setting` varchar(255) DEFAULT NULL,
  `nilai` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`id`, `nama_setting`, `nilai`) VALUES
(1, 'site_title', 'BuketMiniku'),
(2, 'site_description', 'Toko bunga online terpercaya'),
(3, 'contact_email', 'info@bucketminiku.com'),
(4, 'contact_phone', '+62 123 456 789'),
(5, 'contact_address', 'Jl. Bunga No. 123, Jakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengiriman`
--

CREATE TABLE `tb_pengiriman` (
  `id` int(11) NOT NULL,
  `nama_pengiriman` varchar(255) DEFAULT NULL,
  `biaya` decimal(10,2) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pengiriman`
--

INSERT INTO `tb_pengiriman` (`id`, `nama_pengiriman`, `biaya`, `deskripsi`, `aktif`) VALUES
(1, 'JNE', 15000.00, 'Pengiriman via JNE', 1),
(2, 'TIKI', 12000.00, 'Pengiriman via TIKI', 1),
(3, 'POS Indonesia', 10000.00, 'Pengiriman via POS Indonesia', 1),
(4, 'Shopee Instant', 15000.00, 'Pengiriman via Shopee Instant', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `metode_pengiriman` varchar(50) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status` enum('pending','dibayar','dikirim') DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `approved` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tgl_transaksi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_user`, `id_produk`, `jumlah`, `total`, `metode_pengiriman`, `metode_pembayaran`, `status`, `bukti_pembayaran`, `approved`, `tgl_transaksi`) VALUES
(12, 2, NULL, NULL, 99000.00, 'GoSend', 'COD', 'pending', NULL, 'ditolak', '2025-10-08 19:55:23'),
(13, 2, NULL, NULL, 418000.00, 'GoSend', 'Transfer BCA', 'pending', NULL, 'ditolak', '2025-10-08 19:56:43'),
(29, 2, NULL, NULL, 308000.00, 'Shopee Instant', 'COD', 'pending', '', 'ditolak', '2025-10-08 22:14:55'),
(30, 2, NULL, NULL, 209000.00, 'GrabExpress', 'Transfer BNI', 'dibayar', '', 'disetujui', '2025-10-08 22:23:53'),
(31, 1, NULL, NULL, 616000.00, 'Shopee Instant', 'COD', 'dibayar', '', 'disetujui', '2025-10-08 22:27:57'),
(32, 1, NULL, NULL, 99000.00, 'Shopee Instant', 'COD', 'dibayar', '', 'disetujui', '2025-10-08 22:31:08'),
(33, 1, NULL, NULL, 209000.00, 'GrabExpress', 'Transfer BCA', 'dibayar', '', 'disetujui', '2025-10-08 22:35:08'),
(34, 2, NULL, NULL, 209000.00, 'Shopee Instant', 'Transfer BCA', 'dibayar', '', 'disetujui', '2025-10-12 07:35:00'),
(35, 2, NULL, NULL, 407000.00, 'Shopee Instant', 'COD', 'pending', '', 'ditolak', '2025-10-12 09:07:37'),
(36, 2, NULL, NULL, 198000.00, 'GoSend', 'Transfer BCA', 'pending', '', 'pending', '2025-10-12 18:25:30'),
(37, 123458, NULL, NULL, 407000.00, 'GoSend', 'Transfer BCA', 'dibayar', '', 'disetujui', '2025-10-12 20:52:18'),
(38, 2, NULL, NULL, 99000.00, 'Gosend', 'COD', 'pending', NULL, 'pending', '2025-10-17 21:38:28'),
(39, 2, NULL, NULL, 110000.00, 'ShopeeInstant', 'DANA', 'dibayar', NULL, 'disetujui', '2025-10-17 21:39:33'),
(40, 2, NULL, NULL, 902000.00, 'ShopeeInstant', 'Transfer Mandiri', 'dibayar', NULL, 'disetujui', '2025-10-17 22:32:54'),
(41, 2, NULL, NULL, 99000.00, 'Gosend', 'OVO', 'dibayar', NULL, 'disetujui', '2025-10-17 22:40:24'),
(42, 2, NULL, NULL, 209000.00, 'JNE', 'DANA', 'dibayar', NULL, 'disetujui', '2025-10-17 23:24:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `status` enum('Aktif','Blokir') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `alamat`, `password`, `role`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `foto`, `email`, `no_hp`, `status`) VALUES
(1, 'admin', NULL, '$2y$10$4Eych.9d.9fSuPE9qQV3d.YK9s5vlwjz0vg91DfpxOB6iOXdoo.P2', 'admin', 'admin', '0000-00-00', 'Pria', NULL, 'admin@panel.com', NULL, 'Aktif'),
(2, 'riomikail', 'jl.pancawarga', '$2y$10$sedMEGyi7mG7t7shlAytMOWvWvpvhPIPj2zhueU6yX1omyjzsOOlu', 'pelanggan', 'rio mikail', '2004-06-01', 'Pria', 'user_2_1759662076.jpeg', 'riomikail@gmail.com', '089609300019', 'Aktif'),
(123458, 'admin1', 'jl. hutan rimba', '$2y$10$RRgxznJG7z.PdFRLE3tbw.Rw2Cn0ILHMlghlpdRpFY5/40vKpQEaW', 'pelanggan', 'admin1', '2014-01-08', 'Pria', 'user_123458_1760276965.png', 'admin1@gmail.com', '08934783426', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_setting` (`nama_setting`);

--
-- Indeks untuk tabel `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123459;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
