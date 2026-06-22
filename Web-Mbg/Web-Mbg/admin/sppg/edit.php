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

// ambil data sppg yang mau diedit
$ambil = mysqli_query($conn, "SELECT * FROM sppg WHERE id_sppg = $id");
$sppg  = mysqli_fetch_array($ambil);

if (!$sppg) {
    header("Location: index.php");
    exit;
}

// ambil data kecamatan untuk dropdown
$ambil_kec = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC");

$pesan = "";

// proses update data
if (isset($_POST['update'])) {

    $nama_sppg    = $_POST['nama_sppg'];
    $alamat       = $_POST['alamat'];
    $status       = $_POST['status'];
    $id_kecamatan = $_POST['id_kecamatan'];

    if ($nama_sppg == "" || $id_kecamatan == "") {
        $pesan = "Nama SPPG dan Kecamatan wajib diisi!";
    } else {
        // update ke database
        $update = mysqli_query($conn, "
            UPDATE sppg SET
                nama_sppg    = '$nama_sppg',
                alamat       = '$alamat',
                status       = '$status',
                id_kecamatan = '$id_kecamatan'
            WHERE id_sppg = $id
        ");

        if ($update) {
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $pesan = "Gagal memperbarui data!";
        }
    }
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
    <title>Edit SPPG - Admin</title>
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
            <h5>Edit SPPG</h5>
            <div class="info-user"><?php echo $_SESSION['username']; ?> &nbsp;|&nbsp; <span class="badge badge-biru">Admin</span></div>
        </div>

        <!-- Area Konten -->
        <div class="area-konten">

            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="index.php">SPPG</a></li>
                <li>Edit</li>
            </ul>

            <!-- Form -->
            <div class="kotak-form">
                <div class="card">
                    <div class="card-header" style="background:#f57c00;">Form Edit SPPG</div>
                    <div class="card-body">

                        <?php if ($pesan != "") { ?>
                        <div class="alert alert-merah"><?php echo $pesan; ?></div>
                        <?php } ?>

                        <form method="POST">

                            <div class="form-grup">
                                <label>Nama SPPG <span style="color:red;">*</span></label>
                                <input type="text" name="nama_sppg"
                                       value="<?php echo $sppg['nama_sppg']; ?>">
                            </div>

                            <div class="form-grup">
                                <label>Kecamatan <span style="color:red;">*</span></label>
                                <select name="id_kecamatan">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <?php
                                    while ($kec = mysqli_fetch_array($ambil_kec)) {
                                        $selected = "";
                                        if ($kec['id_kecamatan'] == $sppg['id_kecamatan']) {
                                            $selected = "selected";
                                        }
                                    ?>
                                    <option value="<?php echo $kec['id_kecamatan']; ?>" <?php echo $selected; ?>>
                                        <?php echo $kec['nama_kecamatan']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-grup">
                                <label>Alamat</label>
                                <textarea name="alamat" rows="3"><?php echo $sppg['alamat']; ?></textarea>
                            </div>

                            <div class="form-grup">
                                <label>Status</label>
                                <select name="status">
                                    <option value="Aktif" <?php if ($sppg['status'] == 'Aktif') echo 'selected'; ?>>Aktif</option>
                                    <option value="Tutup" <?php if ($sppg['status'] == 'Tutup') echo 'selected'; ?>>Tutup</option>
                                </select>
                            </div>

                            <div class="form-row-aksi">
                                <button type="submit" name="update" class="tombol tombol-kuning" style="width:auto; padding:10px 24px;">
                                    Update
                                </button>
                                <a href="index.php" class="tombol tombol-abu">Batal</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
