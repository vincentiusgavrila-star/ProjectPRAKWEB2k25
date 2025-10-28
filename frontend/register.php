<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Daun Hijau Cafe</title>
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
        padding: 20px 0;
    }

    .register-container {
        width: 100%;
        max-width: 600px;
        padding: 20px;
    }

    .register-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        padding: 2.5rem;
    }

    .page-title {
        color: #1a5d1a;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
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

    .form-text {
        color: #6c757d;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .btn-register {
        background-color: #198754;
        border-color: #198754;
        color: white;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
        margin-top: 1rem;
    }

    .btn-register:hover {
        background-color: #146c43;
        border-color: #146c43;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .login-text {
        text-align: center;
        margin-top: 1.5rem;
        color: #6c757d;
    }

    .login-link {
        color: #198754;
        font-weight: 600;
        text-decoration: none;
    }

    .login-link:hover {
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

    .form-check {
        margin-top: 1rem;
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .form-check-label {
        color: #495057;
        font-size: 0.9rem;
    }

    .terms-link {
        color: #198754;
        text-decoration: none;
    }

    .terms-link:hover {
        color: #146c43;
        text-decoration: underline;
    }

    .alert {
        border-radius: 10px;
        margin-bottom: 1rem;
        display: none;
    }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-icon">
                    <i class="bi bi-cup-hot"></i>
                </div>
                <div class="logo-text">Daun Hijau Cafe</div>
                <div class="logo-subtext">Indonesian Coffee Experience</div>
            </div>

            <!-- Judul -->
            <h1 class="page-title">Buat Akun Baru</h1>
            <p class="subtitle">Daftar untuk menikmati kopi dengan suasana senang</p>

            <!-- Alert untuk pesan error/success -->
            <div id="alertMessage" class="alert" role="alert"></div>

            <!-- Form Register -->
            <form action="../registerSuccess.php" method="POST" id="registerForm">
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="fullname" name="nama" placeholder="Nama lengkap Anda"
                        required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com"
                        required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Minimal 6 karakter" minlength="6" required>
                    <div class="form-text">Password harus terdiri dari minimal 6 karakter</div>
                </div>

                <!-- Syarat dan Ketentuan -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        Saya setuju untuk <a href="#" class="terms-link">tidak revisi</a> serta <a href="#"
                            class="terms-link">mendapat A</a>
                    </label>
                </div>

                <!-- Tombol Daftar -->
                <button type="submit" class="btn btn-register w-100" id="submitBtn">Daftar</button>

                <!-- Sudah Punya Akun -->
                <div class="login-text">
                    Sudah punya akun? <a href="./login.php" class="login-link">Masuk sekarang</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validasi Form -->
    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const terms = document.getElementById('terms').checked;
        const alertMessage = document.getElementById('alertMessage');
        const submitBtn = document.getElementById('submitBtn');

        // Reset alert
        alertMessage.style.display = 'none';
        alertMessage.className = 'alert';

        // Validasi password
        if (password.length < 6) {
            showAlert('Password harus terdiri dari minimal 6 karakter', 'danger');
            return;
        }

        // Validasi terms
        if (!terms) {
            showAlert('Anda harus menyetujui syarat dan ketentuan', 'danger');
            return;
        }

        // Jika semua valid, tampilkan pesan sukses
        showAlert('Pendaftaran berhasil! Mengarahkan ke halaman login...', 'success');

        // Nonaktifkan tombol sementara
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Mengarahkan...';

        // Redirect ke halaman sukses setelah 2 detik
        setTimeout(() => {
            // Submit form secara programmatic
            this.submit();
        }, 2000);
    });

    function showAlert(message, type) {
        const alertMessage = document.getElementById('alertMessage');
        alertMessage.textContent = message;
        alertMessage.className = `alert alert-${type}`;
        alertMessage.style.display = 'block';

        // Scroll ke alert
        alertMessage.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }
    </script>
</body>

</html>