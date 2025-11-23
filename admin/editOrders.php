<?php
session_start();
include 'env.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}

// Get order data for editing
$order = null;
if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $result = $koneksi->query("SELECT o.*, u.username, p.name as product_name FROM orders o JOIN users u ON o.user_id = u.id_user JOIN products p ON o.product_id = p.id WHERE o.id = '$id'");
    if ($result && $result->num_rows > 0) {
        $order = $result->fetch_assoc();
    }
}

if (!$order) {
    $_SESSION['error'] = "Order tidak ditemukan";
    header("Location: dashboardAdmin.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $quantity = $koneksi->real_escape_string($_POST['quantity']);
    $notes = $koneksi->real_escape_string($_POST['notes']);
    $id = $koneksi->real_escape_string($_POST['id']);

    $stmt = $koneksi->prepare("UPDATE orders SET quantity = ?, notes = ?, WHERE id = ?");
    $stmt->bind_param("isi", $quantity, $notes, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Order berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui order: " . $stmt->error;
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
    <title>Edit Order - Admin Panel</title>
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

    .order-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
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
            <h1 class="h3 mb-0">Edit Order</h1>
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
                <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Order</h4>
            </div>
            <div class="card-body p-4">
                <!-- Order Information -->
                <div class="order-info">
                    <h6>Informasi Order</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Customer:</small>
                            <p class="mb-1"><?php echo htmlspecialchars($order['username']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Produk:</small>
                            <p class="mb-1"><?php echo htmlspecialchars($order['product_name']); ?></p>
                        </div>
                    </div>
                </div>

                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required min="1"
                            value="<?php echo htmlspecialchars($order['quantity']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes"
                            rows="3"><?php echo htmlspecialchars($order['notes']); ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update_order" class="btn btn-success">
                            <i class="bi bi-check-lg me-2"></i>
                            Update Order
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