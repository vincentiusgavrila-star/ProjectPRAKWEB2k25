<?php
session_start();
include 'env.php';

// Check if user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}

function getImagePath($gambar_path) {
    if (empty($gambar_path)) return '';
    
    // Cek berbagai kemungkinan path
    $possible_paths = [
        $gambar_path,
        '../uploads/news/' . basename($gambar_path)
    ];
    
    foreach ($possible_paths as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }
    
    return $gambar_path; // Return original path as fallback
}
// Get all news with images
$query = "SELECT id_news, judul, gambar, created_at FROM news WHERE gambar IS NOT NULL AND gambar != '' ORDER BY created_at DESC";
$result = $koneksi->query($query);
$news_with_images = [];
if ($result) {
    $news_with_images = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Berita - Admin Panel</title>
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

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin: 0;
    }

    .gallery-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .gallery-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .gallery-image {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-card:hover .gallery-image img {
        transform: scale(1.05);
    }

    .gallery-content {
        padding: 1.25rem;
    }

    .gallery-title {
        color: #212529;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-green);
        font-size: 0.85rem;
        font-weight: 500;
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

    .image-count {
        background: var(--primary-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem 0.5rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .gallery-image {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div>
                    <a href="dashboardAdmin.php" class="btn btn-back">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="page-title display-5 fw-bold">Gallery Berita</h1>
                    <p class="page-subtitle">Kumpulan semua gambar berita yang telah diupload</p>
                </div>
                <div class="image-count mt-2">
                    <i class="bi bi-image me-1"></i>
                    <?php echo count($news_with_images); ?> Gambar
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-card">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo count($news_with_images); ?></div>
                        <div class="stat-label">Total Gambar</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                            $recent_images = 0;
                            $one_week_ago = date('Y-m-d H:i:s', strtotime('-1 week'));
                            foreach ($news_with_images as $news) {
                                if ($news['created_at'] > $one_week_ago) {
                                    $recent_images++;
                                }
                            }
                            echo $recent_images;
                            ?>
                        </div>
                        <div class="stat-label">Gambar Minggu Ini</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                            $total_news_query = "SELECT COUNT(*) as total FROM news";
                            $total_result = $koneksi->query($total_news_query);
                            $total_news = $total_result ? $total_result->fetch_assoc()['total'] : 0;
                            $percentage = $total_news > 0 ? round((count($news_with_images) / $total_news) * 100) : 0;
                            echo $percentage . '%';
                            ?>
                        </div>
                        <div class="stat-label">Berita Bergambar</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Content -->
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0"><i class="bi bi-images me-2"></i>Semua Gambar Berita</h4>
                <div class="text-muted">
                    <?php echo count($news_with_images); ?> gambar ditemukan
                </div>
            </div>

            <?php if (empty($news_with_images)): ?>
            <div class="empty-state">
                <i class="bi bi-image"></i>
                <h4>Belum ada gambar berita</h4>
                <p>Belum ada berita yang memiliki gambar</p>
                <a href="manageNews.php" class="btn btn-back mt-3">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali ke Kelola Berita
                </a>
            </div>
            <?php else: ?>
            <div class="gallery-grid">
                <?php foreach ($news_with_images as $news): 
                    $created_at = new DateTime($news['created_at']);
                    $formatted_date = $created_at->format('j F Y');
                    $formatted_time = $created_at->format('H:i');
                ?>
                <div class="gallery-card">
                    <div class="gallery-image">
                        <img src="<?php echo htmlspecialchars(getImagePath($news['gambar'])); ?>"
                            alt="<?php echo htmlspecialchars($news['judul']); ?>"
                            title="<?php echo htmlspecialchars($news['judul']); ?>">
                    </div>
                    <div class="gallery-content">
                        <h5 class="gallery-title"><?php echo htmlspecialchars($news['judul']); ?></h5>
                        <div class="gallery-date">
                            <i class="bi bi-calendar"></i>
                            <span><?php echo $formatted_date; ?></span>
                            <i class="bi bi-clock ms-2"></i>
                            <span><?php echo $formatted_time; ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Simple image click to view larger (optional enhancement)
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.gallery-image img');
        images.forEach(img => {
            img.style.cursor = 'pointer';
            img.addEventListener('click', function() {
                const src = this.src;
                const alt = this.alt;

                // Create modal for larger view
                const modalHtml = `
                    <div class="modal fade" id="imageModal" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">${alt}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center p-0">
                                    <img src="${src}" alt="${alt}" class="img-fluid" style="max-height: 70vh; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Remove existing modal if any
                const existingModal = document.getElementById('imageModal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Add new modal and show it
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                modal.show();
            });
        });
    });
    </script>
</body>

</html>