<?php
// koneksi ke database MySQL
$conn = new mysqli("localhost", "root", "", "sppg_bekasi");

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>
