<?php
session_start();
include '../../config/koneksi.php';

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// fitur search
$cari = "";
if (isset($_GET['cari'])) {
    $cari = trim($_GET['cari']);
}

// query data kecamatan dengan fitur search
if ($cari != "") {
    $ambil = mysqli_query($conn, "
        SELECT * FROM kecamatan
        WHERE nama_kecamatan LIKE '%$cari%'
        ORDER BY nama_kecamatan ASC
    ");
} else {
    $ambil = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC");
}

// variabel sidebar
$menu_aktif = 'kecamatan';
$base_admin = '../';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan - Admin</title>
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
            <h5>&#9670; Data Kecamatan</h5>
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
                    <div class="alert alert-hijau">Data kecamatan berhasil ditambahkan!</div>
                <?php } elseif ($_GET['pesan'] == 'edit') { ?>
                    <div class="alert alert-hijau">Data kecamatan berhasil diperbarui!</div>
                <?php } elseif ($_GET['pesan'] == 'hapus') { ?>
                    <div class="alert alert-kuning">Data kecamatan berhasil dihapus!</div>
                <?php } ?>
            <?php } ?>

            <!-- Form Search -->
            <form method="GET" action="index.php">
                <div class="kotak-cari">
                    <label>Cari Kecamatan:</label>
                          <input type="text" name="cari" placeholder="Cari kecamatan..."
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

            <!-- Tabel Data Kecamatan -->
            <div class="kotak-tabel">
                <div class="header-tabel">
                    <span>&#9670; Data Kecamatan</span>
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <a href="tambah.php" class="tombol tombol-kecil" style="background:white; color:#1e3a5f;">
                            + Tambah Kecamatan
                        </a>
                    <?php } ?>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="45">No</th>
                            <th>Nama Kecamatan</th>
                            <th width="130">Jumlah SPPG</th>
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

                            // hitung jumlah SPPG per kecamatan
                            $hitung = mysqli_query($conn, "SELECT COUNT(*) as total FROM sppg WHERE id_kecamatan = " . $baris['id_kecamatan']);
                            $jml    = mysqli_fetch_array($hitung);
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $baris['nama_kecamatan']; ?></td>
                            <td>
                                <span class="badge badge-biru"><?php echo $jml['total']; ?> SPPG</span>
                            </td>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <td>
                                <div class="aksi-grup">
                                    <a href="edit.php?id=<?php echo $baris['id_kecamatan']; ?>"
                                       class="tombol tombol-kuning tombol-kecil">Edit</a>
                                    <a href="hapus.php?id=<?php echo $baris['id_kecamatan']; ?>"
                                       class="tombol tombol-merah tombol-kecil"
                                       onclick="return confirm('Yakin menghapus kecamatan ini? Semua SPPG di dalamnya juga akan terhapus!')">Hapus</a>
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
                            <td colspan="4" class="td-kosong">
                                Belum ada data kecamatan<?php echo $cari != "" ? " yang cocok dengan \"$cari\"" : ""; ?>.
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
