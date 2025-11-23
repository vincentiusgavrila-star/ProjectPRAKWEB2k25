<?php
session_start();
include 'env.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addNews'])) {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);

    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['gambar']['type'];

        if (in_array($file_type, $allowed_types)) {
            $upload_dir = '../uploads/news/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $filename = 'news_' . time() . '_' . uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $filename;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $gambar = $upload_path;
            }
        }
    }
    
    $stmt = $koneksi->prepare("INSERT INTO news (judul, deskripsi, gambar) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $judul, $deskripsi, $gambar);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Berita berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menambahkan berita: " . $stmt->error;
    }
    $stmt->close();
    
    header("Location: manageNews.php");
    exit();
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-green: #198754;
        --dark-green: #155724;
        --light-green: #d1e7dd;
        --hover-green: #157347;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .btn-back {
        background: none;
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-back:hover {
        background-color: var(--primary-green);
        color: white;
        transform: translateY(-2px);
    }

    .page-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #6c757d;
    }

    .form-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .card-header-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }

    .card-header-custom h4 {
        margin: 0;
        font-weight: 600;
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

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border: none;
        color: white;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
    }

    .image-preview {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        margin-top: 0.5rem;
        display: none;
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem 0.5rem;
        }
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="page-header">
            <a href="manageNews.php" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali ke Kelola Berita
            </a>
            <h1 class="page-title display-5 fw-bold">Tambah Berita Baru</h1>
            <p class="page-subtitle">Buat berita baru untuk ditampilkan di website</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Add News Form -->
        <div class="form-card">
            <div class="card-header card-header-custom">
                <h4><i class="bi bi-plus-circle me-2"></i>Form Tambah Berita</h4>
            </div>
            <div class="card-body p-4">
                <form id="addNewsForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita *</label>
                        <input type="text" class="form-control" id="judul" name="judul" required
                            placeholder="Masukkan judul berita">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="8" required
                            placeholder="Tulis deskripsi berita di sini..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar"
                            accept="image/jpeg,image/jpg,image/png,image/gif">
                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                        <img id="imagePreview" class="image-preview" alt="Preview">
                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <button type="submit" name="addNews" class="btn btn-submit">
                            <i class="bi bi-save me-2"></i>
                            Simpan Berita
                        </button>
                        <a href="manageNews.php" class="btn btn-outline-secondary py-2">
                            <i class="bi bi-x me-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Image preview functionality
    document.getElementById('gambar').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Form validation
    document.getElementById('addNewsForm').addEventListener('submit', function(e) {
        const judul = document.getElementById('judul').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();

        if (!judul || !deskripsi) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi!');
            return;
        }
    });
    </script>
</body>

</html>