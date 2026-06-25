-- =============================================
-- DATABASE SPPG KOTA BEKASI
-- =============================================

CREATE DATABASE IF NOT EXISTS `sppg_bekasi`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `sppg_bekasi`;

-- =============================================
-- Tabel: kecamatan
-- =============================================

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kecamatan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kecamatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `kecamatan` (`id_kecamatan`, `nama_kecamatan`) VALUES
(1,  'Bekasi Timur'),
(2,  'Bekasi Barat'),
(3,  'Bekasi Selatan'),
(4,  'Bekasi Utara'),
(5,  'Jatiasih'),
(6,  'Pondok Gede'),
(7,  'Bantargebang'),
(8,  'Mustika Jaya'),
(9,  'Rawalumbu'),
(10, 'Medansatria'),
(11, 'Jatisampurna'),
(12, 'Pondokmelati');

-- =============================================
-- Tabel: sppg
-- =============================================

CREATE TABLE `sppg` (
  `id_sppg` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sppg` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('Aktif','Tutup') NOT NULL DEFAULT 'Aktif',
  `id_kecamatan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sppg`),
  KEY `id_kecamatan` (`id_kecamatan`),
  CONSTRAINT `sppg_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sppg` (`id_sppg`, `nama_sppg`, `alamat`, `status`, `id_kecamatan`) VALUES
(1,  'SPPG Bekasi Timur 1',   'Jl. Raya Bekasi Timur No. 1, Bekasi Timur',    'Aktif', 1),
(2,  'SPPG Bekasi Timur 2',   'Jl. Bulak Kapal No. 5, Bekasi Timur',          'Aktif', 1),
(3,  'SPPG Bekasi Timur 3',   'Jl. Pengasinan No. 10, Bekasi Timur',          'Aktif', 1),
(4,  'SPPG Bekasi Barat 1',   'Jl. Raya Bekasi Barat No. 2, Bekasi Barat',   'Aktif', 2),
(5,  'SPPG Bekasi Barat 2',   'Jl. Bintara No. 7, Bekasi Barat',             'Aktif', 2),
(6,  'SPPG Bekasi Selatan 1', 'Jl. Pekayon No. 3, Bekasi Selatan',           'Aktif', 3),
(7,  'SPPG Bekasi Selatan 2', 'Jl. Kayuringin No. 8, Bekasi Selatan',        'Aktif', 3),
(8,  'SPPG Bekasi Utara 1',   'Jl. Harapan Indah No. 4, Bekasi Utara',       'Aktif', 4),
(9,  'SPPG Bekasi Utara 2',   'Jl. Perwira No. 9, Bekasi Utara',             'Tutup', 4),
(10, 'SPPG Jatiasih 1',       'Jl. Jatiasih Raya No. 6, Jatiasih',           'Aktif', 5),
(11, 'SPPG Pondok Gede 1',    'Jl. Pondok Gede Raya No. 11, Pondok Gede',   'Tutup', 6),
(12, 'SPPG Bantargebang 1',   'Jl. Narogong No. 12, Bantargebang',           'Aktif', 7);

-- =============================================
-- Tabel: tbl_user
-- =============================================

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin',  'admin123', 'admin'),
(2, 'user1',  'user123',  'user');
