<?php
session_start();
include '../../config/koneksi.php';

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// cek role - hanya admin yang boleh
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// ambil data kecamatan untuk dropdown
$ambil_kec = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC");

$pesan = "";

// proses simpan data
if (isset($_POST['simpan'])) {

    $nama_sppg    = $_POST['nama_sppg'];
    $alamat       = $_POST['alamat'];
    $status       = $_POST['status'];
    $id_kecamatan = $_POST['id_kecamatan'];

    // validasi
    if ($nama_sppg == "" || $id_kecamatan == "") {
        $pesan = "Nama SPPG dan Kecamatan wajib diisi!";
    } else {
        // simpan ke database
        $simpan = mysqli_query($conn, "
            INSERT INTO sppg (nama_sppg, alamat, status, id_kecamatan)
            VALUES ('$nama_sppg', '$alamat', '$status', '$id_kecamatan')
        ");

        if ($simpan) {
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $pesan = "Gagal menyimpan data!";
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
    <title>Tambah SPPG - Admin</title>
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
            <h5>+ Tambah SPPG</h5>
            <div class="info-user"><?php echo $_SESSION['username']; ?> &nbsp;|&nbsp; <span class="badge badge-biru">Admin</span></div>
        </div>

        <!-- Area Konten -->
        <div class="area-konten">

            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="index.php">SPPG</a></li>
                <li>Tambah</li>
            </ul>

            <!-- Form -->
            <div class="kotak-form">
                <div class="card">
                    <div class="card-header">Form Tambah SPPG</div>
                    <div class="card-body">

                        <?php if ($pesan != "") { ?>
                        <div class="alert alert-merah"><?php echo $pesan; ?></div>
                        <?php } ?>

                        <form method="POST">

                            <div class="form-grup">
                                <label>Nama SPPG <span style="color:red;">*</span></label>
                                <input type="text" name="nama_sppg"
                                       placeholder="Contoh: SPPG Bekasi Timur 1"
                                       value="<?php echo isset($_POST['nama_sppg']) ? $_POST['nama_sppg'] : ''; ?>">
                            </div>

                            <div class="form-grup">
                                <label>Kecamatan <span style="color:red;">*</span></label>
                                <select name="id_kecamatan">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <?php
                                    while ($kec = mysqli_fetch_array($ambil_kec)) {
                                        $selected = "";
                                        if (isset($_POST['id_kecamatan']) && $_POST['id_kecamatan'] == $kec['id_kecamatan']) {
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
                                <textarea name="alamat" rows="3"
                                    placeholder="Alamat lengkap (opsional)"><?php echo isset($_POST['alamat']) ? $_POST['alamat'] : ''; ?></textarea>
                                <span class="hint">Kosongkan jika tidak ada.</span>
                            </div>

                            <div class="form-grup">
                                <label>Status</label>
                                <select name="status">
                                    <option value="Aktif" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="Tutup" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Tutup') ? 'selected' : ''; ?>>Tutup</option>
                                </select>
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
