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

$pesan = "";

// proses simpan
if (isset($_POST['simpan'])) {

    $nama_kecamatan = trim($_POST['nama_kecamatan']);

    if ($nama_kecamatan == "") {
        $pesan = "Nama kecamatan tidak boleh kosong!";
    } else {
        $simpan = mysqli_query($conn, "INSERT INTO kecamatan (nama_kecamatan) VALUES ('$nama_kecamatan')");

        if ($simpan) {
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $pesan = "Gagal menyimpan data!";
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
    <title>Tambah Kecamatan - Admin</title>
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
            <h5>+ Tambah Kecamatan</h5>
            <div class="info-user"><?php echo $_SESSION['username']; ?> &nbsp;|&nbsp; <span class="badge badge-biru">Admin</span></div>
        </div>

        <!-- Area Konten -->
        <div class="area-konten">

            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="index.php">Kecamatan</a></li>
                <li>Tambah</li>
            </ul>

            <!-- Form -->
            <div class="kotak-form">
                <div class="card">
                    <div class="card-header">Form Tambah Kecamatan</div>
                    <div class="card-body">

                        <?php if ($pesan != "") { ?>
                        <div class="alert alert-merah"><?php echo $pesan; ?></div>
                        <?php } ?>

                        <form method="POST">

                            <div class="form-grup">
                                <label>Nama Kecamatan <span style="color:red;">*</span></label>
                                    <input type="text" name="nama_kecamatan"
                                        placeholder="Misal: Bekasi Timur"
                                       value="<?php echo isset($_POST['nama_kecamatan']) ? $_POST['nama_kecamatan'] : ''; ?>">
                                <span class="hint">Masukkan nama kecamatan dengan benar.</span>
                            </div>

                            <div class="form-row-aksi">
                                <button type="submit" name="simpan" class="tombol tombol-biru" style="width:auto; padding:10px 24px;">
                                    Simpan
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
