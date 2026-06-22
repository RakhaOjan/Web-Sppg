<?php
// detail_kecamatan.php - halaman detail sppg per kecamatan
include 'config/koneksi.php';

// ambil id kecamatan dari URL
$id = $_GET['id'];

// ambil data kecamatan
$keca = mysqli_query($conn, "SELECT * FROM kecamatan WHERE id_kecamatan = $id");
$kec   = mysqli_fetch_array($keca);

if (!$kec) {
    header("Location: index.php");
    exit;
}

// ambil data sppg berdasarkan kecamatan
$q_sppg = mysqli_query($conn, "SELECT * FROM sppg WHERE id_kecamatan = $id ORDER BY nama_sppg ASC");
$jumlah = mysqli_num_rows($q_sppg);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPPG <?php echo $kec['nama_kecamatan']; ?> - SPPG Bekasi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="index.php" class="navbar-brand"> SPPG Kota Bekasi</a>
        <ul class="navbar-menu">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="auth/login.php">Login</a></li>
        </ul>
    </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
    <h1><?php echo $kec['nama_kecamatan']; ?></h1>
    <p>Daftar SPPG di Kecamatan <?php echo $kec['nama_kecamatan']; ?></p>
</div>

<!-- ISI HALAMAN -->
<div class="container halaman-isi">

    <a href="index.php" class="tombol-kembali">&larr; Kembali ke Beranda</a>

    <div class="judul-halaman">SPPG Kecamatan <?php echo $kec['nama_kecamatan']; ?></div>
    <div class="sub-judul">Total: <?php echo $jumlah; ?> SPPG terdaftar</div>

    <div class="kotak-tabel">
        <div class="header-tabel">
            <span>Daftar SPPG - <?php echo $kec['nama_kecamatan']; ?></span>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="45">No</th>
                    <th>Nama SPPG</th>
                    <th>Alamat</th>
                    <th width="80">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $ada = false;
                while ($sppg = mysqli_fetch_array($q_sppg)) {
                    $ada = true;
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><strong><?php echo $sppg['nama_sppg']; ?></strong></td>
                    <td style="font-size:12px;"><?php echo $sppg['alamat']; ?></td>
                    <td>
                        <?php if ($sppg['status'] == 'Aktif') { ?>
                            <span class="badge badge-hijau">Aktif</span>
                        <?php } else { ?>
                            <span class="badge badge-merah">Tutup</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                    $no++;
                }
                if (!$ada) {
                ?>
                <tr>
                    <td colspan="4" class="td-kosong">Belum ada data SPPG di kecamatan ini.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Website Informasi SPPG Kota Bekasi &mdash; Dinas Kesehatan Kota Bekasi</p>
</footer>

</body>
</html>
