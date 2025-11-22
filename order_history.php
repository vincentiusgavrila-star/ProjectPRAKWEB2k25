<?php
session_start();
include 'env.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat pesanan user
$query = "SELECT o.*, p.name as product_name, p.price as product_price 
          FROM orders o 
          JOIN products p ON o.product_id = p.id 
          WHERE o.user_id = '$user_id' 
          ORDER BY o.order_date ASC";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 80px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-leaf me-2"></i>Daun Hijau Cafe
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="menuUser.php">
                    <i class="fas fa-utensils me-1"></i>Menu
                </a>
                <a class="nav-link text-white" href="logout.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-success">
                        <i class="fas fa-history me-2"></i>Riwayat Pesanan
                    </h2>
                    <a href="menuUser.php" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
                    </a>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <?php if ($result->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                            <th>Catatan</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $total_keseluruhan = 0;
                                        while ($order = $result->fetch_assoc()): 
                                            $subtotal = $order['product_price'] * $order['quantity'];
                                            $total_keseluruhan += $subtotal;
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($order['product_name']); ?></strong>
                                                </td>
                                                <td><?php echo $order['quantity']; ?></td>
                                                <td>Rp <?php echo number_format($order['product_price'], 0, ',', '.'); ?></td>
                                                <td class="fw-bold text-success">
                                                    Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($order['notes'] ?: '-'); ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <tr class="table-active">
                                            <td colspan="4" class="text-end"><strong>Total Keseluruhan:</strong></td>
                                            <td colspan="3" class="fw-bold text-success">
                                                <strong>Rp <?php echo number_format($total_keseluruhan, 0, ',', '.'); ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pesanan</h5>
                                <p class="text-muted">Silakan pesan menu favorit Anda terlebih dahulu</p>
                                <a href="menuUser.php" class="btn btn-success">
                                    <i class="fas fa-utensils me-2"></i>Pesan Sekarang
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>