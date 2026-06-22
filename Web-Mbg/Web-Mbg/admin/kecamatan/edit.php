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

// ambil data kecamatan yang mau diedit
$ambil     = mysqli_query($conn, "SELECT * FROM kecamatan WHERE id_kecamatan = $id");
$kecamatan = mysqli_fetch_array($ambil);

if (!$kecamatan) {
    header("Location: index.php");
    exit;
}

$pesan = "";

// proses update
if (isset($_POST['update'])) {

    $nama_kecamatan = trim($_POST['nama_kecamatan']);

    if ($nama_kecamatan == "") {
        $pesan = "Nama kecamatan tidak boleh kosong!";
    } else {
        $update = mysqli_query($conn, "UPDATE kecamatan SET nama_kecamatan='$nama_kecamatan' WHERE id_kecamatan=$id");

        if ($update) {
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $pesan = "Gagal memperbarui data!";
        }
    }
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
    <title>Edit Kecamatan - Admin</title>
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
            <h5>Edit Kecamatan</h5>
            <div class="info-user"><?php echo $_SESSION['username']; ?> &nbsp;|&nbsp; <span class="badge badge-biru">Admin</span></div>
        </div>

        <!-- Area Konten -->
        <div class="area-konten">

            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="index.php">Kecamatan</a></li>
                <li>Edit</li>
            </ul>

            <!-- Form -->
            <div class="kotak-form">
                <div class="card">
                    <div class="card-header" style="background:#f57c00;">Form Edit Kecamatan</div>
                    <div class="card-body">

                        <?php if ($pesan != "") { ?>
                        <div class="alert alert-merah"><?php echo $pesan; ?></div>
                        <?php } ?>

                        <form method="POST">

                            <div class="form-grup">
                                <label>Nama Kecamatan <span style="color:red;">*</span></label>
                                <input type="text" name="nama_kecamatan"
                                       value="<?php echo $kecamatan['nama_kecamatan']; ?>">
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
