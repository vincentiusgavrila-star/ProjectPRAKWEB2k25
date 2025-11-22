<?php
session_start();
include 'env.php';

// Check if user is admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: login.php");
    exit();
}

// Handle form submission - Add News
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
    
    // Handle image upload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['gambar']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $upload_dir = 'uploads/news/';
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
    
    header("Location: addNews.php");
    exit();
}

// Handle delete news
if (isset($_GET['delete_id'])) {
    $delete_id = $koneksi->real_escape_string($_GET['delete_id']);
    
    // Get image path before deleting
    $result = $koneksi->query("SELECT gambar FROM news WHERE id_news = '$delete_id'");
    if ($result && $row = $result->fetch_assoc() && $row['gambar']) {
        if (file_exists($row['gambar'])) {
            unlink($row['gambar']);
        }
    }
    
    $delete_query = "DELETE FROM news WHERE id_news = '$delete_id'";
    if ($koneksi->query($delete_query)) {
        $_SESSION['success'] = "Berita berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus berita: " . $koneksi->error;
    }
    
    header("Location: admin_news.php");
    exit();
}

// Get all news
$query = "SELECT * FROM news ORDER BY created_at DESC";
$result = $koneksi->query($query);
$news_list = [];
if ($result) {
    $news_list = $result->fetch_all(MYSQLI_ASSOC);
}

// Handle success/error messages
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - Admin Panel</title>
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
        max-width: 1400px;
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

    .stats-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 600;
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

    .news-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .news-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .news-image {
        height: 200px;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .news-card:hover .news-image img {
        transform: scale(1.05);
    }

    .news-content {
        padding: 1.5rem;
    }

    .news-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-green);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .news-title {
        color: #212529;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .news-description {
        color: #6c757d;
        line-height: 1.6;
        margin: 0;
    }

    .news-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .btn-action {
        background: none;
        border: 1px solid #198754;
        color: #198754;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .btn-action:hover {
        background-color: #198754;
        border-color: #198754;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);
    }

    .btn-action.delete:hover {
        background-color: #f8d7da;
        border-color: #f1aeb5;
        color: #dc3545;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #dee2e6;
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

        .news-image {
            height: 180px;
        }

        .news-actions {
            flex-direction: column;
        }
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="page-header">
            <a href="dashboardAdmin.php" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali ke Dashboard
            </a>
            <h1 class="page-title display-5 fw-bold">Kelola Berita</h1>
            <p class="page-subtitle">Tambah dan kelola berita untuk ditampilkan di website</p>
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

        <!-- Statistics -->
        <div class="stats-card">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo count($news_list); ?></div>
                        <div class="stat-label">Total Berita</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                            $recent_count = 0;
                            $one_week_ago = date('Y-m-d H:i:s', strtotime('-1 week'));
                            foreach ($news_list as $news) {
                                if ($news['created_at'] > $one_week_ago) {
                                    $recent_count++;
                                }
                            }
                            echo $recent_count;
                            ?>
                        </div>
                        <div class="stat-label">Berita Minggu Ini</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                            $with_images = 0;
                            foreach ($news_list as $news) {
                                if (!empty($news['gambar'])) {
                                    $with_images++;
                                }
                            }
                            echo $with_images;
                            ?>
                        </div>
                        <div class="stat-label">Dengan Gambar</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Add News Form -->
            <div class="col-lg-4">
                <div class="form-card">
                    <div class="card-header card-header-custom">
                        <h4><i class="bi bi-plus-circle me-2"></i>Tambah Berita Baru</h4>
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
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required
                                    placeholder="Tulis deskripsi berita di sini..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar"
                                    accept="image/jpeg,image/jpg,image/png,image/gif">
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                <img id="imagePreview" class="image-preview" alt="Preview">
                            </div>

                            <button type="submit" name="add_news" class="btn btn-submit w-100">
                                <i class="bi bi-save me-2"></i>
                                Simpan Berita
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- News List -->
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="card-header card-header-custom">
                        <h4><i class="bi bi-newspaper me-2"></i>Daftar Berita</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (empty($news_list)): ?>
                        <div class="empty-state">
                            <i class="bi bi-newspaper"></i>
                            <h4>Belum ada berita</h4>
                            <p>Mulai tambahkan berita pertama Anda</p>
                        </div>
                        <?php else: ?>
                        <div class="row">
                            <?php foreach ($news_list as $news): 
                                // Format tanggal Indonesia
                                $created_at = new DateTime($news['created_at']);
                                $formatted_date = $created_at->format('j F Y');
                                $formatted_time = $created_at->format('H:i');
                            ?>
                            <div class="col-md-6 mb-4">
                                <div class="news-card">
                                    <?php if ($news['gambar']): ?>
                                    <div class="news-image">
                                        <img src="<?php echo htmlspecialchars($news['gambar']); ?>"
                                            alt="<?php echo htmlspecialchars($news['judul']); ?>">
                                    </div>
                                    <?php endif; ?>

                                    <div class="news-content">
                                        <div class="news-date">
                                            <i class="bi bi-calendar"></i>
                                            <span><?php echo $formatted_date; ?></span>
                                            <i class="bi bi-clock ms-2"></i>
                                            <span><?php echo $formatted_time; ?></span>
                                        </div>

                                        <h5 class="news-title"><?php echo htmlspecialchars($news['judul']); ?></h5>

                                        <p class="news-description">
                                            <?php 
                                            $description = htmlspecialchars($news['deskripsi']);
                                            if (strlen($description) > 150) {
                                                echo substr($description, 0, 150) . '...';
                                            } else {
                                                echo $description;
                                            }
                                            ?>
                                        </p>

                                        <div class="news-actions">
                                            <a href="updateNews.php?id=<?php echo $news['id_news']; ?>"
                                                class="btn-action">
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </a>
                                            <a href="admin_news.php?delete_id=<?php echo $news['id_news']; ?>"
                                                class="btn-action delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
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