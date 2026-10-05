-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Sep 2026 pada 08.30
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
-- Database: `db_outsourcing`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak_penawaran`
--

CREATE TABLE `kontak_penawaran` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `whatsapp` varchar(25) NOT NULL,
  `layanan_diminati` varchar(100) NOT NULL,
  `pesan` text DEFAULT NULL,
  `status_lead` enum('Baru','Diproses','Selesai','Dibatalkan') DEFAULT 'Baru',
  `tanggal_kirim` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak_penawaran`
--

INSERT INTO `kontak_penawaran` (`id`, `nama_lengkap`, `whatsapp`, `layanan_diminati`, `pesan`, `status_lead`, `tanggal_kirim`) VALUES
(2, 'RS Columbia', '08436873687', 'Home Care Profesional', '10 perawat Homecare gaji harian', 'Baru', '2026-09-16 09:51:54'),
(3, 'RS Elizabeth', '086436436326', 'Digital Marketing', '2 person unutk bagian marketing', 'Diproses', '2026-09-16 09:59:12'),
(4, 'RS Permata Medika', '08643587436', 'Home Care Profesional', '2 person HC ', 'Selesai', '2026-09-21 04:15:26'),
(5, 'Klinik Gigi Dental Care', '0856749867386', 'Digital Marketing', 'butuh 1 digital marketing untuk area klinik semarang tengah', 'Dibatalkan', '2026-09-25 04:38:51'),
(6, 'RS Siloam', '08745464646', 'Cleaning Service Medis', '50 personel CS medis untuk RS Siloam Srondol', 'Baru', '2026-09-25 04:49:32'),
(8, 'Klinik Dokter Keluarga Ungaran', '087435465475', 'Cleaning Service Medis', '2 staff CS medis', 'Baru', '2026-09-25 06:25:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `nama_lengkap`, `username`, `password`, `dibuat_pada`) VALUES
(1, 'Administrator', 'admin', '$2y$10$opaj7.XaXP.sxJh4kSr4d.wMwNBBZz60iEiNFf/rGh4OL5d1K.nNi', '2026-09-25 04:17:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kontak_penawaran`
--
ALTER TABLE `kontak_penawaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kontak_penawaran`
--
ALTER TABLE `kontak_penawaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
