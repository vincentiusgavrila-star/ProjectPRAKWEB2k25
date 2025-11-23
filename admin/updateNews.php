<?php
session_start();
include 'env.php';

// Check if user is admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}

// Get news data for editing
$news = null;
if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $result = $koneksi->query("SELECT * FROM news WHERE id_news = '$id'");
    if ($result && $result->num_rows > 0) {
        $news = $result->fetch_assoc();
    }
}

if (!$news) {
    $_SESSION['error'] = "Berita tidak ditemukan";
    header("Location: addNews.php");
    exit();
}

// Handle form submission - Update News
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_news'])) {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
    $id_news = $koneksi->real_escape_string($_POST['id_news']);
    
    // Handle image upload
    $gambar = $news['gambar']; // Keep existing image if not changed
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['gambar']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Delete old image if exists
            if ($news['gambar'] && file_exists($news['gambar'])) {
                unlink($news['gambar']);
            }
            
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
    
    $stmt = $koneksi->prepare("UPDATE news SET judul = ?, deskripsi = ?, gambar = ? WHERE id_news = ?");
    $stmt->bind_param("sssi", $judul, $deskripsi, $gambar, $id_news);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Berita berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui berita: " . $stmt->error;
    }
    $stmt->close();
    
    header("Location: addNews.php");
    exit();
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
    <title>Edit Berita - Admin Panel</title>
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

    .form-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }

    .image-preview {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        margin-top: 0.5rem;
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="manageNews.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali
            </a>
            <h1 class="h3 mb-0">Edit Berita</h1>
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

        <!-- Edit Form -->
        <div class="form-card">
            <div class="card-header card-header-custom">
                <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Berita</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_news" value="<?php echo $news['id_news']; ?>">

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita *</label>
                        <input type="text" class="form-control" id="judul" name="judul" required
                            value="<?php echo htmlspecialchars($news['judul']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="8"
                            required><?php echo htmlspecialchars($news['deskripsi']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar"
                            accept="image/jpeg,image/jpg,image/png,image/gif">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar</div>

                        <?php if ($news['gambar']): ?>
                        <div class="mt-2">
                            <p class="mb-1">Gambar saat ini:</p>
                            <img src="<?php echo htmlspecialchars($news['gambar']); ?>" class="image-preview"
                                alt="Current image">
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update_news" class="btn btn-success">
                            <i class="bi bi-check-lg me-2"></i>
                            Update Berita
                        </button>
                        <a href="manageNews.php" class="btn btn-outline-secondary">
                            <i class="bi bi-x me-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>