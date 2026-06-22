<?php
session_start();
include '../config/koneksi.php';

// kalau sudah login
if(isset($_SESSION['username'])){

    if($_SESSION['role'] == 'admin'){
        header("Location: dashboard.php");
    }else{
        header("Location: ../admin/dashboard.php");
    }
    exit;
}


if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($conn,
        "SELECT * FROM tbl_user WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);
    if($user){
        if($password == $user['password']){
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            if($user['role'] == 'admin'){
                echo "<script>alert('Login Berhasil Selamat Datang Admin'); window.location.href = 'dashboard.php';</script>";
            }else{
                echo "<script>alert('Login Berhasil Selamat Datang User'); window.location.href = '../user/dashboard.php';</script>";
            }
            exit;
        }else{
            echo "<script>alert('Pasword Salah!!'); window.history.back();</script>";
        }
    }else{
        echo "<script>alert('Username Salah!!'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SPPG Bekasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f, #2980b9);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .login-header {
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
        <div class="col-md-4 col-sm-8">
            <div class="card login-card">
                <!-- Header Login -->
                <div class="login-header">
                    <i class="bi bi-person-lock" style="font-size:2.5rem;"></i>
                    <h4 class="mt-2 mb-0">Login</h4>
                    <small style="color:#bee3f8;">Website SPPG Kota Bekasi</small>
                </div>

                <!-- Form Login -->
                <div class="card-body p-4">

                    <?php if ($pesan != "") { ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <?php echo $pesan; ?>
                    </div>
                    <?php } ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="username" class="form-control" 
                                       placeholder="Masukkan username" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" 
                                       placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn w-100 text-white fw-bold" 
                                style="background:#1e3a5f;">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </button>
                    </form>

                    <hr>
                    <p class="text-center mb-1" style="font-size:0.88rem;">
                        Belum punya akun?
                        <a href="register.php" class="text-decoration-none fw-bold">Daftar di sini</a>
                    </p>
                    <p class="text-center text-muted mb-0" style="font-size:0.85rem;">
                        <a href="../index.php" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                        </a>
                    </p>
                </div>
            </div>

            <!-- Info default login -->
            <div class="text-center mt-3" style="color:rgba(255,255,255,0.7); font-size:0.85rem;">
                Default: admin / admin123
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
