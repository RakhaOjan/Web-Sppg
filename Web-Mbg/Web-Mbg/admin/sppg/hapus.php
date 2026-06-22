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

// hapus data sppg
mysqli_query($conn, "DELETE FROM sppg WHERE id_sppg = $id");

// redirect ke halaman index
header("Location: index.php?pesan=hapus");
exit;
?>
