-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2025 pada 08.46
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jahit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `design`
--

CREATE TABLE `design` (
  `design_id` int(11) NOT NULL,
  `jenis_pakaian` varchar(50) NOT NULL,
  `gambar_design` mediumblob NOT NULL,
  `deskripsi_design` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `design`
--

INSERT INTO `design` (`design_id`, `jenis_pakaian`, `gambar_design`, `deskripsi_design`) VALUES
(2, 'Daster bobok', 0x75706c6f6164732f363834663961653533643639665f313735303034373436312e6a7067, 'Daster keren banget uwaw'),
(6, 'PDH ', 0x75706c6f6164732f363834663961666633663164325f313735303034373438372e6a706567, 'PDH tapi gerah'),
(7, 'Baju polo', 0x75706c6f6164732f363834663962346533646430345f313735303034373536362e6a7067, 'Baju starboy coi'),
(8, 'Baju KKN', 0x75706c6f6164732f363834663962363363306431305f313735303034373538372e6a7067, 'Baju KKN-nya UNNES');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `pesanan_id` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_model` varchar(50) NOT NULL,
  `opsi_pengambilan` varchar(20) NOT NULL,
  `ukuran` text NOT NULL,
  `catatan` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_pengerjaan` varchar(50) NOT NULL,
  `Warna` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`pesanan_id`, `nama_pelanggan`, `nomor_telepon`, `alamat`, `jenis_model`, `opsi_pengambilan`, `ukuran`, `catatan`, `quantity`, `tanggal_mulai`, `tanggal_selesai`, `status_pengerjaan`, `Warna`) VALUES
(4, 'ini', 122, 'joga', 'Baju KKN', 'Pesanan diantar', 'Panjang Kaki: 10, Lingkar Tangan: 50', 'ini percobaan ketiga', 10, '2025-07-03', '2025-07-05', 'Penjahitan', '359d73'),
(5, 'Nobel', 289, 'aada', 'Muka shrek', 'Pesanan diantar', 'Lingkar Tangan: 20, Panjang Lengan Atas: 20', 'opsional', 789, '2025-07-06', '2025-07-09', 'Selesai', '359d73'),
(10, 'test', 1, 'ada deh', 'Muka shrek', 'Pesanan diantar', 'Panjang Lengan Bawah: 1', 'gantengnya', 1, '2025-06-17', '2025-06-20', 'Finishing', 'f0be39'),
(11, 'tes merah', 11, 'ada', 'Muka shrek', 'Pesanan diantar', 'Lingkar Tangan: 1', 'ini merah', 10, '2025-06-16', '2025-06-17', 'Selesai', 'd70e17'),
(12, 'Rahman', 2147483647, 'Bekasi', 'Baju polo', 'Ambil di tempat', 'Lingkar Perut: 20, Lingkar Pinggang: 23', '', 2, '2025-06-18', '2025-06-22', '-', 'f0be39'),
(13, 'Robi sitanggang', 789, 'adaa', 'PDH ', 'Pesanan diantar', '', '', 1, '2025-06-25', '2025-06-27', '-', '359d73'),
(14, 'icikiwir', 123, 'ada', 'Baju KKN', 'Pesanan diantar', '', 'cie', 2, '2025-06-17', '2025-06-21', '-', 'f0be39');

--
-- Trigger `pesanan`
--
DELIMITER $$
CREATE TRIGGER `before_insert_pesanan` BEFORE INSERT ON `pesanan` FOR EACH ROW BEGIN
  SET NEW.Warna = 
    CASE 
      WHEN DATEDIFF(NEW.tanggal_selesai, CURRENT_DATE) BETWEEN 1 AND 3 THEN 'd70e17'
      WHEN DATEDIFF(NEW.tanggal_selesai, CURRENT_DATE) BETWEEN 4 AND 9 THEN 'f0be39'
      WHEN DATEDIFF(NEW.tanggal_selesai, CURRENT_DATE) >= 10 THEN '359d73'
      ELSE 'ffff'
    END;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_pesanan` BEFORE UPDATE ON `pesanan` FOR EACH ROW BEGIN
  SET NEW.Warna = 
    CASE 
      WHEN DATEDIFF(NEW.tanggal_selesai, CURRENT_DATE) BETWEEN 1 AND 3 THEN 'd70e17'
      WHEN DATEDIFF(NEW.tanggal_selesai, CURRENT_DATE) BETWEEN 4 AND 9 THEN 'f0be39'
      WHEN DATEDIFF(NEW.tanggal_selesai, CURRENT_DATE) >= 10 THEN '359d73'
      ELSE 'ffff'
    END;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(8) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `name`) VALUES
(1, 'admin', '123', 'adminRahman');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `design`
--
ALTER TABLE `design`
  ADD PRIMARY KEY (`design_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`pesanan_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `design`
--
ALTER TABLE `design`
  MODIFY `design_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `pesanan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
