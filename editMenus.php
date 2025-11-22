<?php
session_start();
include 'env.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: login.php");
    exit();
}

// Get menu data for editing
$menu = null;
if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $result = $koneksi->query("SELECT * FROM products WHERE id = '$id'");
    if ($result && $result->num_rows > 0) {
        $menu = $result->fetch_assoc();
    }
}

if (!$menu) {
    $_SESSION['error'] = "Menu item tidak ditemukan";
    header("Location: dashboardAdmin.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_menu'])) {
    $name = $koneksi->real_escape_string($_POST['name']);
    $category = $koneksi->real_escape_string($_POST['category']);
    $price = $koneksi->real_escape_string($_POST['price']);
    $description = $koneksi->real_escape_string($_POST['description']);
    $id = $koneksi->real_escape_string($_POST['id']);

    $stmt = $koneksi->prepare("UPDATE products SET name = ?, category = ?, price = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $name, $category, $price, $description, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Menu berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui menu: " . $stmt->error;
    }
    $stmt->close();
    
    header("Location: dashboardAdmin.php");
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
    <title>Edit Menu - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-green: #198754;
        --dark-green: #155724;
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
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="dashboardAdmin.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali ke Dashboard
            </a>
            <h1 class="h3 mb-0">Edit Menu</h1>
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
                <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Menu Item</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Menu *</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="<?php echo htmlspecialchars($menu['name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori *</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="coffee" <?php echo $menu['category'] == 'coffee' ? 'selected' : ''; ?>>Coffee
                            </option>
                            <option value="minuman" <?php echo $menu['category'] == 'minuman' ? 'selected' : ''; ?>>
                                Minuman</option>
                            <option value="makanan" <?php echo $menu['category'] == 'makanan' ? 'selected' : ''; ?>>
                                Makanan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga *</label>
                        <input type="number" class="form-control" id="price" name="price" required
                            value="<?php echo htmlspecialchars($menu['price']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            required><?php echo htmlspecialchars($menu['description']); ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update_menu" class="btn btn-success">
                            <i class="bi bi-check-lg me-2"></i>
                            Update Menu
                        </button>
                        <a href="dashboardAdmin.php" class="btn btn-outline-secondary">
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