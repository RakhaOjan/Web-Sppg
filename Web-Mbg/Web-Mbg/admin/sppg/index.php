<?php
session_start();
include '../../config/koneksi.php';

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// fitur pencarian
$cari = "";
if (isset($_GET['cari'])) {
    $cari = trim($_GET['cari']);
}

// query data sppg + kecamatan dengan pencarian
if ($cari != "") {
    $ambil = mysqli_query($conn, "
        SELECT s.*, k.nama_kecamatan
        FROM sppg s
        JOIN kecamatan k ON s.id_kecamatan = k.id_kecamatan
        WHERE k.nama_kecamatan LIKE '%$cari%'
        OR s.nama_sppg LIKE '%$cari%'
        ORDER BY k.nama_kecamatan, s.nama_sppg ASC
    ");
} else {
    $ambil = mysqli_query($conn, "
        SELECT s.*, k.nama_kecamatan
        FROM sppg s
        JOIN kecamatan k ON s.id_kecamatan = k.id_kecamatan
        ORDER BY k.nama_kecamatan, s.nama_sppg ASC
    ");
}

// variabel sidebar
$menu_aktif = 'sppg';
$base_admin = '../';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data SPPG - Admin</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="layout-admin">

    <!-- SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- KONTEN -->
    <div class="konten-admin">

        <!-- Topbar -->
        <div class="topbar">
            <h5>&#9632; Data SPPG</h5>
            <div class="info-user">
                <?php echo $_SESSION['username']; ?>
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

            <!-- Pesan notifikasi -->
            <?php if (isset($_GET['pesan'])) { ?>
                <?php if ($_GET['pesan'] == 'tambah') { ?>
                    <div class="alert alert-hijau">Data SPPG berhasil ditambahkan!</div>
                <?php } elseif ($_GET['pesan'] == 'edit') { ?>
                    <div class="alert alert-hijau">Data SPPG berhasil diperbarui!</div>
                <?php } elseif ($_GET['pesan'] == 'hapus') { ?>
                    <div class="alert alert-kuning">Data SPPG berhasil dihapus!</div>
                <?php } ?>
            <?php } ?>

            <!-- Form Pencarian -->
            <form method="GET" action="index.php">
                <div class="kotak-cari">
                    <label>Cari SPPG:</label>
                    <input type="text" name="cari" placeholder="Nama SPPG atau Kecamatan..."
                           value="<?php echo $cari; ?>">
                    <button type="submit">Cari</button>
                    <?php if ($cari != "") { ?>
                        <a href="index.php" class="tombol-reset">Reset</a>
                    <?php } ?>
                </div>
            </form>

            <?php if ($cari != "") { ?>
                <p class="teks-cari">Menampilkan hasil pencarian untuk: <strong>"<?php echo $cari; ?>"</strong></p>
            <?php } ?>

            <!-- Tabel Data SPPG -->
            <div class="kotak-tabel">
                <div class="header-tabel">
                    <span>&#9632; Data SPPG</span>
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <a href="tambah.php" class="tombol tombol-kecil" style="background:white; color:#1e3a5f;">
                            + Tambah SPPG
                        </a>
                    <?php } ?>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="45">No</th>
                            <th>Nama SPPG</th>
                            <th>Kecamatan</th>
                            <th>Alamat</th>
                            <th width="80">Status</th>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <th width="160">Aksi</th>
                            <?php } ?>
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
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <td>
                                <div class="aksi-grup">
                                    <a href="edit.php?id=<?php echo $baris['id_sppg']; ?>"
                                       class="tombol tombol-kuning tombol-kecil">Edit</a>
                                    <a href="hapus.php?id=<?php echo $baris['id_sppg']; ?>"
                                       class="tombol tombol-merah tombol-kecil"
                                       onclick="return confirm('Yakin ingin menghapus SPPG ini?')">Hapus</a>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php
                            $no++;
                        }

                        if (!$ada_data) {
                        ?>
                        <tr>
                            <td colspan="6" class="td-kosong">
                                Belum ada data SPPG<?php echo $cari != "" ? " yang cocok dengan pencarian \"$cari\"" : ""; ?>.
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>
