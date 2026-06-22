<?php
// index.php - halaman utama publik
include 'config/koneksi.php';

// hitung total kecamatan
$q_kec   = mysqli_query($conn, "SELECT COUNT(*) as total FROM kecamatan");
$d_kec   = mysqli_fetch_array($q_kec);
$total_kecamatan = $d_kec['total'];

// hitung total sppg
$q_sppg  = mysqli_query($conn, "SELECT COUNT(*) as total FROM sppg");
$d_sppg  = mysqli_fetch_array($q_sppg);
$total_sppg = $d_sppg['total'];

// ambil semua data kecamatan
$ambil_kecamatan = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC");

// variabel untuk header
$base_url = '';
$judul_halaman = 'Beranda';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website SPPG Kota Bekasi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="index.php" class="navbar-brand"> SPPG Kota Bekasi</a>
        <ul class="navbar-menu">
            <li><a href="index.php" class="aktif">Beranda</a></li>
            <li><a href="auth/login.php">Login</a></li>
        </ul>
    </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
    <h1>Website Informasi SPPG</h1>
    <h4>Kota Bekasi</h4>
    <p>Satuan Pelayanan Pemenuhan Gizi</p>
</div>

<!-- ISI HALAMAN -->
<div class="container halaman-isi">

    <!-- Statistik -->
    <div class="row-statistik">

        <div class="card-statistik">
            <div class="ikon" style="background:#e8f0fb;">
                <span style="color:#1e3a5f; font-size:22px;">&#9670;</span>
            </div>
            <div>
                <div class="label">Total Kecamatan</div>
                <div class="angka" style="color:#1e3a5f;"><?php echo $total_kecamatan; ?></div>
            </div>
        </div>

        <div class="card-statistik">
            <div class="ikon" style="background:#fff3e0;">
                <span style="color:#e65100; font-size:22px;">&#9632;</span>
            </div>
            <div>
                <div class="label">Total SPPG</div>
                <div class="angka" style="color:#e65100;"><?php echo $total_sppg; ?></div>
            </div>
        </div>

    </div>

    <!-- Daftar Kecamatan -->
    <div class="card">
        <div class="card-header">Daftar Kecamatan di Kota Bekasi</div>
        <div class="card-body">
            <p style="color:#777; font-size:13px; margin-bottom:16px;">
                Klik nama kecamatan untuk melihat daftar SPPG yang tersedia.
            </p>

            <div class="grid-kecamatan">
                <?php
                $no = 1;
                while ($kec = mysqli_fetch_array($ambil_kecamatan)) {

                    // hitung jumlah sppg per kecamatan
                    $hitung = mysqli_query($conn, "SELECT COUNT(*) as total FROM sppg WHERE id_kecamatan = " . $kec['id_kecamatan']);
                    $jml    = mysqli_fetch_array($hitung);
                ?>
                <a href="detail_kecamatan.php?id=<?php echo $kec['id_kecamatan']; ?>">
                    <div class="card-kecamatan">
                        <div class="nomor"><?php echo $no; ?></div>
                        <div>
                            <div class="nama"><?php echo $kec['nama_kecamatan']; ?></div>
                            <div class="jumlah"><?php echo $jml['total']; ?> SPPG</div>
                        </div>
                        <div class="panah">&rsaquo;</div>
                    </div>
                </a>
                <?php
                    $no++;
                }
                ?>
            </div>

        </div>
    </div>

</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2026 Website Informasi SPPG Kota Bekasi -- Dinas Kesehatan Kota Bekasi</p>
</footer>

</body>
</html>
