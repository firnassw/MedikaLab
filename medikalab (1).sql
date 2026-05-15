-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Bulan Mei 2026 pada 18.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medikalab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `lab`
--

CREATE TABLE `lab` (
  `id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `parameter` varchar(100) NOT NULL,
  `hasil` text DEFAULT NULL,
  `catatan_dokter` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('PROSES','SELESAI') DEFAULT 'PROSES',
  `file_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lab`
--

INSERT INTO `lab` (`id`, `pasien_id`, `parameter`, `hasil`, `catatan_dokter`, `tanggal`, `status`, `file_pdf`) VALUES
(1, 1, 'sehat', '10000', 'baik', '2026-05-12', 'SELESAI', '6a02f56f37270.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `no_rm` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` enum('L','P') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `user_id`, `no_rm`, `nama`, `jk`) VALUES
(1, 2, 'RM-001', 'Rizal Firmansyah', 'L');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','pasien') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '111', 'admin'),
(2, 'RM-001', '111', 'pasien');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `lab`
--
ALTER TABLE `lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `lab`
--
ALTER TABLE `lab`
  ADD CONSTRAINT `lab_ibfk_1` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
