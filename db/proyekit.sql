-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Nov 2024 pada 00.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyekit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `nama`, `comment`, `tanggal`) VALUES
(28, 'lutfan hadi', 'hallo', '2024-11-11 00:55:30'),
(31, 'okta', 'hello semua', '2024-11-11 08:22:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('Tertunda','Berjalan','selesai') NOT NULL,
  `progres` varchar(255) NOT NULL,
  `id_proyek` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `tanggal_mulai`, `tanggal_selesai`, `status`, `progres`, `id_proyek`) VALUES
(9, '2024-11-08', '2024-11-30', 'Berjalan', '67', 34),
(16, '2024-11-11', '2024-11-28', 'Berjalan', '50%', 39),
(17, '2024-11-21', '2024-11-30', 'Berjalan', '90%', 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `manajemen_anggaran`
--

CREATE TABLE `manajemen_anggaran` (
  `id_anggaran` int(11) NOT NULL,
  `id_proyek` int(100) NOT NULL,
  `anggaran` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manajemen_anggaran`
--

INSERT INTO `manajemen_anggaran` (`id_anggaran`, `id_proyek`, `anggaran`) VALUES
(23, 39, 3000000.00),
(24, 40, 10000000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `manajemen_proyek`
--

CREATE TABLE `manajemen_proyek` (
  `id_proyek` int(11) NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `pelanggan` varchar(200) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manajemen_proyek`
--

INSERT INTO `manajemen_proyek` (`id_proyek`, `nama_proyek`, `pelanggan`, `tanggal_mulai`, `tanggal_selesai`) VALUES
(39, 'web perpustakaan', 'dani', '2024-11-11', '2024-11-28'),
(40, 'web cipak', 'faris', '2024-11-21', '2024-11-30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manajemen_tim`
--

CREATE TABLE `manajemen_tim` (
  `id_tim` int(11) NOT NULL,
  `id_proyek` int(100) NOT NULL,
  `proyek_manager` varchar(200) NOT NULL,
  `anggota_team` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manajemen_tim`
--

INSERT INTO `manajemen_tim` (`id_tim`, `id_proyek`, `proyek_manager`, `anggota_team`) VALUES
(97, 0, 'hadi', 'okta,hadi,alfin'),
(98, 0, 'hadi', 'okta,hadi,alfin'),
(99, 0, 'hadi', 'okta,hadi,alfin'),
(100, 16, 'hadi', 'okta,hadi,alfin'),
(101, 17, 'alfin', 'okta,hadi,alfin'),
(108, 39, 'hadi', 'okta,alfin,faris'),
(109, 40, 'hadi', 'okta,alfin,faris');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT '''img/undraw_profile.svg'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `profile_picture`) VALUES
(1, 'hadi', 'hadibro1@gmail.com', 'e786d75e08d5dfec845cf5509e50535702c95574', ''),
(2, 'bella', 'admin1@gmail.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', ''),
(3, 'alfin', 'alfin1@gmail.com', 'c69dd5e040cceb556bdfbf9779953e88be93188e', ''),
(4, 'Lutfan Hadi', 'lutfan1@gmail.com', '58b1dec8d30c9a79940532e16dc38dfc561745e7', ''),
(5, 'Najikha ', 'najikhasr@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '\'img/undraw_profile.svg\''),
(6, 'OKTA BARKA RAMADHAN', 'oktarabakramadhan@gmail.com', '382d9b40ed5d18110077e8e29ef38c47da777335', '\'img/undraw_profile.svg\'');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `manajemen_anggaran`
--
ALTER TABLE `manajemen_anggaran`
  ADD PRIMARY KEY (`id_anggaran`),
  ADD KEY `id_proyek` (`id_proyek`);

--
-- Indeks untuk tabel `manajemen_proyek`
--
ALTER TABLE `manajemen_proyek`
  ADD PRIMARY KEY (`id_proyek`);

--
-- Indeks untuk tabel `manajemen_tim`
--
ALTER TABLE `manajemen_tim`
  ADD PRIMARY KEY (`id_tim`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `manajemen_anggaran`
--
ALTER TABLE `manajemen_anggaran`
  MODIFY `id_anggaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `manajemen_proyek`
--
ALTER TABLE `manajemen_proyek`
  MODIFY `id_proyek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `manajemen_tim`
--
ALTER TABLE `manajemen_tim`
  MODIFY `id_tim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `manajemen_anggaran`
--
ALTER TABLE `manajemen_anggaran`
  ADD CONSTRAINT `manajemen_anggaran_ibfk_1` FOREIGN KEY (`id_proyek`) REFERENCES `manajemen_proyek` (`id_proyek`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
