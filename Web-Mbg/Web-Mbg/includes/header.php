<?php
// includes/header.php
// Digunakan di halaman publik saja
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($judul_halaman) ? $judul_halaman . ' - SPPG Bekasi' : 'Website SPPG Kota Bekasi'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url ?? ''; ?>assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="<?php echo $base_url ?? ''; ?>index.php" class="navbar-brand">&#9829; SPPG Kota Bekasi</a>
        <ul class="navbar-menu">
            <li><a href="<?php echo $base_url ?? ''; ?>index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['id'])) ? 'aktif' : ''; ?>">Beranda</a></li>
            <li><a href="<?php echo $base_url ?? ''; ?>auth/login.php">Login</a></li>
        </ul>
    </div>
</nav>
