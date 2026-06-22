<?php
session_start();
include '../config/koneksi.php';

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit;
}

// kalau admin, redirect ke dashboard admin
if ($_SESSION['role'] == 'admin') {
    header("Location: ../admin/dashboard.php");
    exit;
}

// hitung statistik
$q_kec  = mysqli_query($conn, "SELECT COUNT(*) as total FROM kecamatan");
$d_kec  = mysqli_fetch_array($q_kec);
$total_kec = $d_kec['total'];

$q_sppg = mysqli_query($conn, "SELECT COUNT(*) as total FROM sppg");
$d_sppg = mysqli_fetch_array($q_sppg);
$total_sppg = $d_sppg['total'];

$q_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_user");
$d_user = mysqli_fetch_array($q_user);
$total_user = $d_user['total'];

// fitur pencarian
$cari = "";
if (isset($_GET['cari'])) {
    $cari = trim($_GET['cari']);
}

// query data sppg dengan pencarian
if ($cari != "") {
    $ambil = mysqli_query($conn, "
        SELECT sppg.*, kecamatan.nama_kecamatan
        FROM sppg
        JOIN kecamatan ON sppg.id_kecamatan = kecamatan.id_kecamatan
        WHERE kecamatan.nama_kecamatan LIKE '%$cari%'
        OR sppg.nama_sppg LIKE '%$cari%'
        ORDER BY kecamtan.nama_kecamatan, sppg.nama_sppg ASC
    ");
} else {
    $ambil = mysqli_query($conn, "
        SELECT sppg.*, kecamatan.nama_kecamatan
        FROM sppg
        JOIN kecamatan ON sppg.id_kecamatan = kecamatan.id_kecamatan
        ORDER BY kecamatan.nama_kecamatan, sppg.nama_sppg ASC
    ");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SPPG Bekasi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="layout-admin">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="ikon-logo">&#9829;</div>
            <div class="nama-logo">SPPG Bekasi</div>
            <div class="sub-logo">Kota Bekasi</div>
        </div>
        <div class="sidebar-menu">
            <div class="menu-judul">Menu</div>
            <a href="dashboard.php" class="aktif">&#9632; Dashboard</a>
            <div class="menu-judul">Akun</div>
            <a href="../auth/logout.php" onclick="return confirm('Yakin Logout?')">&#10006; Logout</a>
        </div>
    </div>

    <!-- KONTEN -->
    <div class="konten-admin">

        <!-- Topbar -->
        <div class="topbar">
            <h5>&#9632; Dashboard User</h5>
            <div class="info-user">
                Halo, <strong><?php echo $_SESSION['username']; ?></strong>!
                &nbsp;|&nbsp;
                <span class="badge badge-abu">User</span>
            </div>
        </div>

        <!-- Area Konten -->
        <div class="area-konten">

            <p style="color:#777; margin-bottom:20px; font-size:13px;">
                Selamat datang! Anda dapat melihat data SPPG dan melakukan pencarian di bawah ini.
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
                    </div>
                </div>

                <div class="card-admin-stat">
                    <div class="ikon-stat" style="background:#fff3e0;">
                        <span style="font-size:22px; color:#e65100;">&#9632;</span>
                    </div>
                    <div>
                        <div class="label-stat">Total SPPG</div>
                        <div class="angka-stat" style="color:#e65100;"><?php echo $total_sppg; ?></div>
                    </div>
                </div>

                <div class="card-admin-stat">
                    <div class="ikon-stat" style="background:#e8f5e9;">
                        <span style="font-size:22px; color:#2e7d32;">&#128100;</span>
                    </div>
                    <div>
                        <div class="label-stat">Total User</div>
                        <div class="angka-stat" style="color:#2e7d32;"><?php echo $total_user; ?></div>
                    </div>
                </div>

            </div>

            <!-- Form Pencarian -->
            <form method="GET" action="dashboard.php">
                <div class="kotak-cari">
                    <label>Cari SPPG:</label>
                    <input type="text" name="cari" placeholder="Nama SPPG atau Kecamatan..."
                    value="<?php echo $cari; ?>">
                    <button type="submit">Cari</button>
                    <?php if ($cari != "") { ?>
                        <a href="dashboard.php" class="tombol-reset">Reset</a>
                    <?php } ?>
                </div>
            </form>

            <?php if ($cari != "") { ?>
                <p class="teks-cari">Hasil pencarian untuk: <strong>"<?php echo $cari; ?>"</strong></p>
            <?php } ?>

            <!-- Tabel Data SPPG -->
            <div class="kotak-tabel">
                <div class="header-tabel">
                    <span>&#9632; Data SPPG</span>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="45">No</th>
                            <th>Nama SPPG</th>
                            <th>Kecamatan</th>
                            <th>Alamat</th>
                            <th width="80">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $ada_data = false;
                        while ($baris = mysqli_fetch_array($ambil)) {
                            $ada_data = true;
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><strong><?php echo $baris['nama_sppg']; ?></strong></td>
                            <td>
                                <span class="badge badge-biru"><?php echo $baris['nama_kecamatan']; ?></span>
                            </td>
                            <td style="font-size:12px; max-width:200px;"><?php echo $baris['alamat']; ?></td>
                            <td>
                                <?php if ($baris['status'] == 'Aktif') { ?>
                                    <span class="badge badge-hijau">Aktif</span>
                                <?php } else { ?>
                                    <span class="badge badge-merah">Tutup</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                            $no++;
                        }

                        if (!$ada_data) {
                        ?>
                        <tr>
                            <td colspan="5" class="td-kosong">
                                Belum ada data SPPG<?php echo $cari != "" ? " yang cocok dengan pencarian \"$cari\"" : ""; ?>.
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Info -->
            <div class="alert alert-biru" style="margin-top:20px;">
                <strong>Info:</strong> Akun Anda adalah User. Untuk mengelola data (tambah/edit/hapus), silahkan hubungi Admin.
            </div>

        </div>
    </div>
</div>

</body>
</html>
