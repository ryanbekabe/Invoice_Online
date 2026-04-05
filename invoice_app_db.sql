-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Apr 2026 pada 04.21
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice_app_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `hash_id` varchar(32) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_email` varchar(100) DEFAULT NULL,
  `client_address` text DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Draft','Terkirim','Lunas','Jatuh Tempo') DEFAULT 'Draft',
  `notes` text DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id`, `hash_id`, `user_id`, `invoice_number`, `client_name`, `client_email`, `client_address`, `issue_date`, `due_date`, `status`, `notes`, `total_amount`, `created_at`) VALUES
(1, '862d65f64f65cf3359a338e9a4513687', 1, 'INV-20260405-4088', 'RS Islam PKU Muhammadiyah Palangka Raya', 'pku@gmail.com', 'Jl. RTA. Milono', '2026-04-05', '2026-04-19', 'Terkirim', 'Bank Ryan', '0.00', '2026-04-05 02:04:23'),
(2, 'f3932d1b4d3e79f612e83e2d249f9560', 1, 'INV-20260405-8377', 'RS Islam PKU Muhammadiyah Palangka Raya', 'pku@gmail.com', 'Jl. RTA. Milono', '2026-04-05', '2026-04-19', 'Lunas', 'Bank Ryan', '6600000.00', '2026-04-05 02:05:28'),
(3, '459183d44c0ba261831bc8e016337dce', 1, 'INV-20260405-3663', 'Klinik Aisyiyah Pratama', 'pratama@gmail.com', 'Jl. RTA. Milono', '2026-04-05', '2026-04-19', 'Draft', 'Bank Ryan', '3000000.00', '2026-04-05 02:19:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `description`, `quantity`, `unit_price`, `total`) VALUES
(1, 1, 'Server VPS 1', 1, '1000.00', '1000.00'),
(2, 1, 'Server VPS 2', 1, '1000.00', '1000.00'),
(3, 1, 'Server VPS 1', 10, '300000.00', '3000000.00'),
(4, 2, 'Server VPS 1', 10, '300000.00', '3000000.00'),
(5, 2, 'Server VPS 2', 12, '300000.00', '3600000.00'),
(6, 3, 'Server VPS 1', 12, '250000.00', '3000000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `company_name` varchar(255) DEFAULT 'Your Company LLC',
  `company_address1` varchar(255) DEFAULT '123 Business Road',
  `company_address2` varchar(255) DEFAULT 'Tech City, TC 10101',
  `company_email` varchar(100) DEFAULT 'hello@yourcompany.com'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_address1`, `company_address2`, `company_email`) VALUES
(1, 'HanyaJasa.Com', 'Jl. Dr. Murjani, Gang Rahayu', 'Jl. Pantai Cemara Labat', 'hanyajasa@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'hanyajasa@gmail.com', '$2y$10$CC5pub5cIo/mkXTyhH4jU.qbFrALgJoY5T6qZPrL3zS6DjEMEtkT.', '2026-04-05 01:48:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_settings`
--

CREATE TABLE `user_settings` (
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT 'Perusahaan Anda',
  `company_address1` varchar(255) DEFAULT 'Jl. Bisnis No. 123',
  `company_address2` varchar(255) DEFAULT 'Kota Teknologi, 10101',
  `company_email` varchar(100) DEFAULT 'halo@perusahaan.com',
  `theme` varchar(50) DEFAULT 'theme-default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_settings`
--

INSERT INTO `user_settings` (`user_id`, `company_name`, `company_address1`, `company_address2`, `company_email`, `theme`) VALUES
(1, 'Perusahaan Anda', 'Jl. Bisnis No. 123', 'Kota Teknologi, 10101', 'halo@perusahaan.com', 'theme-rose');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash_id` (`hash_id`);

--
-- Indeks untuk tabel `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
