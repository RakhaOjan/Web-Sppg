<?php
session_start();
include '../config/koneksi.php';

// kalau sudah login, redirect ke dashboard
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../user/dashboard.php");
    }
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // query cek username
    $query = mysqli_query($conn, "SELECT * FROM tbl_user WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {

        // cek password
        if ($password == $user['password']) {

            // simpan session
            $_SESSION['id']       = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            // redirect sesuai role
            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
            exit;

        } else {
            $pesan = "Password salah!";
        }

    } else {
        $pesan = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPPG Kota Bekasi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="halaman-auth">
    <div class="kotak-auth">

        <!-- Header -->
        <div class="auth-header">
            <div class="ikon-besar">&#128274;</div>
            <h3>Login</h3>
            <p>Website SPPG Kota Bekasi</p>
        </div>

        <!-- Form -->
        <div class="auth-body">

            <?php if ($pesan != "") { ?>
            <div class="alert alert-merah"><?php echo $pesan; ?></div>
            <?php } ?>

            <form method="POST">

                <div class="form-grup">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required
                           value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                </div>

                <div class="form-grup">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" name="login" class="tombol tombol-biru">Login</button>

            </form>

        </div>

        <!-- Footer auth -->
        <div class="auth-footer">
            <hr class="garis">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
            <br><br>
            <a href="../index.php">&larr; Kembali ke Beranda</a>
        </div>

    </div>
</div>

</body>
</html>
