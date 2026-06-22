<?php
session_start();
include '../config/koneksi.php';

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit;
}

// hitung total kecamatan
$q_kec  = mysqli_query($conn, "SELECT COUNT(*) as total FROM kecamatan");
$d_kec  = mysqli_fetch_array($q_kec);
$total_kec = $d_kec['total'];

// hitung total sppg
$q_sppg = mysqli_query($conn, "SELECT COUNT(*) as total FROM sppg");
$d_sppg = mysqli_fetch_array($q_sppg);
$total_sppg = $d_sppg['total'];

// hitung total user
$q_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_user");
$d_user = mysqli_fetch_array($q_user);
$total_user = $d_user['total'];

// variabel sidebar
$menu_aktif  = 'dashboard';
$base_admin  = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SPPG Bekasi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="layout-admin">

    <!-- SIDEBAR -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- KONTEN UTAMA -->
    <div class="konten-admin">

        <!-- Topbar -->
        <div class="topbar">
            <h5>&#9632; Dashboard</h5>
            <div class="info-user">
                Halo, <strong><?php echo $_SESSION['username']; ?></strong>!
                &nbsp;|&nbsp;
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <span class="badge badge-biru">Admin</span>
                <?php } else { ?>
                    <span class="badge badge-abu">User</span>
                <?php } ?>
            </div>
        </div>

        <!-- Area Konten -->
        <div class="area-konten">

            <p style="color:#777; margin-bottom:20px; font-size:13px;">
                Selamat datang di Website SPPG Kota Bekasi. Gunakan menu di kiri untuk mengelola data.
            </p>

            <!-- Card Statistik -->
            <div class="row-card-admin">

                <div class="card-admin-stat">
                    <div class="ikon-stat" style="background:#e8f0fb;">
                        <span style="font-size:22px; color:#1e3a5f;">&#9670;</span>
                    </div>
                    <div>
                        <div class="label-stat">Total Kecamatan</div>
                        <div class="angka-stat" style="color:#1e3a5f;"><?php echo $total_kec; ?></div>
                        <a href="kecamatan/index.php" class="link-stat">Lihat Data &rarr;</a>
                    </div>
                </div>

                <div class="card-admin-stat">
                    <div class="ikon-stat" style="background:#fff3e0;">
                        <span style="font-size:22px; color:#e65100;">&#9632;</span>
                    </div>
                    <div>
                        <div class="label-stat">Total SPPG</div>
                        <div class="angka-stat" style="color:#e65100;"><?php echo $total_sppg; ?></div>
                        <a href="sppg/index.php" class="link-stat" style="color:#e65100;">Lihat Data &rarr;</a>
                    </div>
                </div>

                <div class="card-admin-stat">
                    <div class="ikon-stat" style="background:#e8f5e9;">
                        <span style="font-size:22px; color:#2e7d32;">&#128100;</span>
                    </div>
                    <div>
                        <div class="label-stat">Total User</div>
                        <div class="angka-stat" style="color:#2e7d32;"><?php echo $total_user; ?></div>
                        <span class="link-stat" style="color:#2e7d32;">Terdaftar</span>
                    </div>
                </div>

            </div>

            <!-- Shortcut Menu -->
            <div class="row-shortcut">

                <a href="kecamatan/index.php" class="card-shortcut">
                    <div class="ikon-shortcut" style="color:#1e3a5f;">&#9670;</div>
                    <div class="label-shortcut">Data Kecamatan</div>
                </a>

                <a href="sppg/index.php" class="card-shortcut">
                    <div class="ikon-shortcut" style="color:#e65100;">&#9632;</div>
                    <div class="label-shortcut">Data SPPG</div>
                </a>

                <?php if ($_SESSION['role'] == 'admin') { ?>

                <a href="kecamatan/tambah.php" class="card-shortcut">
                    <div class="ikon-shortcut" style="color:#2e7d32;">&#43;</div>
                    <div class="label-shortcut">Tambah Kecamatan</div>
                </a>

                <a href="sppg/tambah.php" class="card-shortcut">
                    <div class="ikon-shortcut" style="color:#f57c00;">&#43;</div>
                    <div class="label-shortcut">Tambah SPPG</div>
                </a>

                <?php } ?>

            </div>

            <!-- Info -->
            <div class="alert alert-biru" style="margin-top:20px;">
                <strong>Info:</strong> Gunakan menu di sebelah kiri untuk mengelola data kecamatan dan SPPG.
                Data yang diubah akan langsung tampil di halaman publik.
            </div>

        </div>
    </div>
</div>

</body>
</html>
