<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['daftar'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $konfirm_password = $_POST['konfirm_password'];

    if (empty($username) || empty($password) || empty($konfirm_password)) {
        echo "<script>
                alert('Semua kolom wajib diisi!');
                window.history.back();
            </script>";
    } elseif (strlen($password) < 6) {
        echo "<script>
                alert('Password minimal 6 karakter!');
                window.history.back();
            </script>";
    } elseif ($password != $konfirm_password) {
        echo "<script>
                alert('Password dan konfirmasi password tidak sama!');
                window.history.back();
            </script>";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM tbl_user WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>
                    alert('Username sudah digunakan!');
                    window.history.back();
                </script>";
        } else {
            $role = "user";
            $simpan = mysqli_query(
                $conn,
                "INSERT INTO tbl_user(username,password,role)
                VALUES('$username','$password','$role')"
            );
            if ($simpan) {
                echo "<script>
                        alert('Registrasi Berhasil, Silakan Login!');
                        window.location.href='login.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Registrasi Gagal!');
                        window.history.back();
                    </script>";
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
    <title>Registrasi Admin - SPPG Bekasi</title>
    
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f, #2980b9);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .register-header {
            background: #1e3a5f;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 25px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-9">
                <div class="card register-card">

                    <!-- Header -->
                    <div class="register-header">
                        <i class="bi bi-person-plus-fill" style="font-size:2.5rem;"></i>
                        <h4 class="mt-2 mb-0">Registrasi</h4>
                        <small style="color:#bee3f8;">Website SPPG Kota Bekasi</small>
                    </div>

                    <!-- Form Registrasi -->
                    <div class="card-body p-4">
                        <form method="POST">
                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control"
                                        placeholder="Buat username"
                                        value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"
                                        required>
                                </div>
                                <div class="form-text">Gunakan huruf/angka, tanpa spasi.</div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Buat password (min. 6 karakter)"
                                        required>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" name="konfirm_password" class="form-control"
                                        placeholder="Ulangi password"
                                        required>
                                </div>
                            </div>

                            <button type="submit" name="daftar" class="btn w-100 text-white fw-bold"
                                style="background:#1e3a5f;">
                                <i class="bi bi-person-check me-1"></i>
                                Daftar Sekarang
                            </button>
                        </form>

                        <hr>
                        <p class="text-center mb-0" style="font-size:0.88rem;">
                            Sudah punya akun?
                            <a href="login.php" class="text-decoration-none fw-bold">Login di sini</a>
                        </p>
                        <p class="text-center mt-2 mb-0" style="font-size:0.85rem;">
                            <a href="../index.php" class="text-decoration-none text-muted">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                            </a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>