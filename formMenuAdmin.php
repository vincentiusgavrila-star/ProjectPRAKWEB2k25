<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Menu - Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-green: #198754;
        --dark-green: #155724;
        --light-green: #d1e7dd;
        --hover-green: #157347;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .admin-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .admin-header {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .admin-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .admin-subtitle {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .admin-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .btn-admin {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border: none;
        color: white;
        padding: 14px 28px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        width: 100%;
    }

    .btn-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
        background: linear-gradient(135deg, var(--hover-green), var(--primary-green));
    }

    .success-message {
        background: linear-gradient(135deg, #d3f9d8, #b2f2bb);
        border: 2px solid #51cf66;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #2b8a3e;
        font-weight: 600;
        display: none;
        animation: slideIn 0.5s ease-out;
    }

    .error-message {
        background: linear-gradient(135deg, #ffe3e3, #ffc9c9);
        border: 2px solid #ff6b6b;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #c92a2a;
        font-weight: 600;
        display: none;
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .countdown-timer {
        font-size: 0.8rem;
        opacity: 0.8;
        margin-top: 0.5rem;
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-card">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Menu Baru
                </h1>
                <p class="admin-subtitle">Kelola menu Daun Hijau Cafe dengan mudah</p>
            </div>

            <!-- Success Message (Hidden by default) -->
            <div class="success-message" id="successMessage">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="successText">Menu berhasil ditambahkan!</span>
                <div class="countdown-timer" id="countdownTimer">
                    Form akan direset dalam <span id="countdown">3</span> detik...
                </div>
            </div>

            <!-- Error Message (Hidden by default) -->
            <div class="error-message" id="errorMessage">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span id="errorText"></span>
            </div>

            <!-- Form -->
            <div class="admin-body">
                <form action="createMenu.php" method="POST" id="menuForm">
                    <!-- Nama Menu -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Contoh: Espresso Double Shot" required maxlength="50">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Menu</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Jelaskan tentang menu ini..." maxlength="200"></textarea>
                    </div>

                    <!-- Harga dan Kategori -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="25000"
                                min="0" step="500" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="coffee">Coffee</option>
                                <option value="minuman">Minuman</option>
                                <option value="makanan">Makanan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn-admin" id="submitBtn">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Menu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('menuForm');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        const successText = document.getElementById('successText');
        const errorText = document.getElementById('errorText');
        const countdownElement = document.getElementById('countdown');
        const countdownTimer = document.getElementById('countdownTimer');
        const submitBtn = document.getElementById('submitBtn');

        // Cek URL parameters untuk success/error messages
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('success')) {
            showSuccessMessage('Menu berhasil ditambahkan!');
        }

        if (urlParams.has('error')) {
            showErrorMessage(decodeURIComponent(urlParams.get('error')));
        }

        function showSuccessMessage(message) {
            successText.textContent = message;
            successMessage.style.display = 'block';
            errorMessage.style.display = 'none';

            // Disable submit button selama countdown
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menunggu...';

            // Countdown timer
            let countdown = 3;
            countdownElement.textContent = countdown;

            const timer = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;

                if (countdown <= 0) {
                    clearInterval(timer);
                    successMessage.style.display = 'none';
                    form.reset();
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Tambah Menu';

                    // Remove URL parameters tanpa reload
                    const newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }
            }, 1000);
        }

        function showErrorMessage(message) {
            errorText.textContent = message;
            errorMessage.style.display = 'block';
            successMessage.style.display = 'none';

            // Auto hide error message setelah 5 detik
            setTimeout(function() {
                errorMessage.style.display = 'none';
                // Remove URL parameters tanpa reload
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }, 5000);
        }
    });
    </script>
</body>

</html>