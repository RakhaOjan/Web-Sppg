<?php
session_start();
include '../../config/koneksi.php';

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// cek role
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// ambil id dari URL
$id = $_GET['id'];

// hapus dulu sppg yang ada di kecamatan ini (karena ada foreign key)
mysqli_query($conn, "DELETE FROM sppg WHERE id_kecamatan = $id");

// baru hapus kecamatannya
mysqli_query($conn, "DELETE FROM kecamatan WHERE id_kecamatan = $id");

// redirect ke index
header("Location: index.php?pesan=hapus");
exit;
?>
