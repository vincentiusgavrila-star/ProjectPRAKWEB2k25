<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    body {
        background: linear-gradient(135deg, #1a5d1a 0%, #2d8c2d 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
        width: 100%;
        max-width: 600px;
        padding: 20px;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        padding: 2.5rem;
    }

    .welcome-text {
        color: #1a5d1a;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .subtitle {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .forgot-password {
        color: #198754;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .forgot-password:hover {
        color: #146c43;
        text-decoration: underline;
    }

    .btn-login {
        background-color: #198754;
        border-color: #198754;
        color: white;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-login:hover {
        background-color: #146c43;
        border-color: #146c43;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .signup-text {
        text-align: center;
        margin-top: 1.5rem;
        color: #6c757d;
    }

    .signup-link {
        color: #198754;
        font-weight: 600;
        text-decoration: none;
    }

    .signup-link:hover {
        color: #146c43;
        text-decoration: underline;
    }

    .logo {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .logo-icon {
        background-color: #198754;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }

    .logo-text {
        color: #1a5d1a;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .logo-subtext {
        color: #6c757d;
        font-size: 0.9rem;
    }
    </style>
</head>

<body>
    <?php 
        if(isset($_GET['pesan'])){
            $notif = $_GET['pesan'];
            if ($notif == "gagl") {
                echo ("Gagal Login!");
            } elseif ($notif == "logout") {
                echo ("Berhasil Logout!");
            } elseif ($notif == "belum") {
                echo ("Belum Login!");
            }
        }
    ?>
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-icon">
                    <i class="bi bi-cup-hot"></i>
                </div>
                <div class="logo-text">Daun Hijau Cafe</div>
                <div class="logo-subtext">Indonesian Coffee Experience</div>
            </div>

            <!-- Judul -->
            <h4 class="welcome-text">Selamat Datang Kembali</h4>
            <p class="subtitle">Masuk ke akun Daun Hijau Cafe Anda</p>

            <!-- Form Login -->
            <form action="loginProses.php" method="POST">
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@email.com"
                        required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password" required>
                </div>

                <!-- Lupa Password -->
                <div class="mb-4 text-end">
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>

                <!-- Tombol Masuk -->
                <button type="submit" class="btn btn-login w-100">Masuk</button>

                <!-- Daftar Sekarang -->
                <div class="signup-text">
                    Belum punya akun? <a href="./register.php" class="signup-link">Daftar sekarang</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>