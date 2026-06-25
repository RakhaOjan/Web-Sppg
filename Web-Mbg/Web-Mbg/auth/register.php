<?php
session_start();
include '../config/koneksi.php';

// kalau sudah login, redirect
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../user/dashboard.php");
    }
    exit;
}

$pesan  = "";
$sukses = "";

if (isset($_POST['daftar'])) {

    $username        = trim($_POST['username']);
    $password        = $_POST['password'];
    $konfirm         = $_POST['konfirm_password'];
    $role            = $_POST['role'];

    // validasi input
    if (empty($username) || empty($password) || empty($konfirm) || empty($role)) {

        $pesan = "Semua kolom wajib diisi!";
    } elseif (strlen($password) < 6) {

        $pesan = "Password minimal 6 karakter!";
    } elseif ($password != $konfirm) {

        $pesan = "Password dan konfirmasi password tidak sama!";
    } elseif ($role != 'admin' && $role != 'user') {

        $pesan = "Role tidak valid!";
    } else {

        // cek username sudah ada atau belum
        $cek = mysqli_query($conn, "SELECT * FROM tbl_user WHERE username='$username'");

        if (mysqli_num_rows($cek) > 0) {

            $pesan = "Username sudah digunakan, pilih username lain!";
        } else {

            // simpan ke database
            $simpan = mysqli_query($conn, "
                INSERT INTO tbl_user (username, password, role)
                VALUES ('$username', '$password', '$role')
            ");

            if ($simpan) {
                $sukses = "Registrasi berhasil! Silahkan login.";
            } else {
                $pesan = "Gagal menyimpan data: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SPPG Kota Bekasi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="halaman-auth">
        <div class="kotak-auth" style="max-width: 460px;">

            <!-- Header -->
            <div class="auth-header">
                <img src="../assets/images/logo-sppg.png" alt="Logo SPPG" class="logo-auth">
                <h3>Registrasi</h3>
                <p>Website SPPG Kota Bekasi</p>
            </div>

            <!-- Form -->
            <div class="auth-body">

                <?php if ($pesan != "") { ?>
                    <div class="alert alert-merah"><?php echo $pesan; ?></div>
                <?php } ?>

                <?php if ($sukses != "") { ?>
                    <div class="alert alert-hijau"><?php echo $sukses; ?></div>
                <?php } ?>

                <form method="POST">

                    <div class="form-grup">
                        <label>Username <span style="color:red;">*</span></label>
                        <input type="text" name="username" placeholder="Buat username (tanpa spasi)"
                            value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                        <span class="hint">Gunakan huruf dan angka saja, tanpa spasi.</span>
                    </div>

                    <div class="form-grup">
                        <label>Password <span style="color:red;">*</span></label>
                        <input type="password" name="password" placeholder="Buat password (min. 6 karakter)" required>
                    </div>

                    <div class="form-grup">
                        <label>Konfirmasi Password <span style="color:red;">*</span></label>
                        <input type="password" name="konfirm_password" placeholder="Ulangi password" required>
                    </div>

                    <div class="form-grup">
                        <label>Role <span style="color:red;">*</span></label>
                        <select name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo (isset($_POST['role']) && $_POST['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        </select>
                        <span class="hint">Admin: bisa tambah/edit/hapus data. User: hanya bisa melihat data.</span>
                    </div>

                    <button type="submit" name="daftar" class="tombol tombol-biru">Daftar Sekarang</button>

                </form>

            </div>

            <!-- Footer auth -->
            <div class="auth-footer">
                <hr class="garis">
                Sudah punya akun? <a href="login.php">Login di sini</a>
                <br><br>
                <a href="../index.php">&larr; Kembali ke Beranda</a>
            </div>

        </div>
    </div>

</body>

</html>