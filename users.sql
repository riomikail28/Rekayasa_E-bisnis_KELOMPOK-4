-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2025 pada 18.11
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
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123459;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
