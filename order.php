<?php
// order.php
session_start();
require_once 'env.php';

// Get product if item_id is provided
$product = null;
if (isset($_GET['item_id'])) {
    $item_id = $koneksi->real_escape_string($_GET['item_id']);
    $query = "SELECT * FROM products WHERE id = '$item_id'";
    $result = $koneksi->query($query);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan - Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="menuUser.php" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
                </a>
                
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">Form Pemesanan</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($product): ?>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <img src="<?php 
                                        if ($product['category'] == 'coffee') echo 'https://images.unsplash.com/photo-1698466631860-0886a4f0c2c3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRvbmVzaWFuJTIwY29mZmVlJTIwY3VwfGVufDF8fHx8MTc2MTc0MDIxNHww&ixlib=rb-4.1.0&q=80&w=1080';
                                        elseif ($product['category'] == 'minuman') echo 'https://images.unsplash.com/photo-1713949215254-9769b4ad8724?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpY2VkJTIwdGVhJTIwZHJpbmt8ZW58MXx8fHwxNzYxNjQ5MTU3fDA&ixlib=rb-4.1.0&q=80&w=1080';
                                        else echo 'https://images.unsplash.com/photo-1680674814945-7945d913319c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYXNpJTIwZ29yZW5nJTIwZm9vZHxlbnwxfHx8fDE3NjE3NDAyMTR8MA&ixlib=rb-4.1.0&q=80&w=1080';
                                    ?>" 
                                    class="img-fluid rounded" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </div>
                                <div class="col-md-8">
                                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                    <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                                    <h5 class="text-success">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></h5>
                                </div>
                            </div>
                            
                            <form method="POST" action="process_order.php">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan (opsional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Contoh: Kurangi gula, tambah es, dll."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted">Produk tidak ditemukan.</p>
                                <a href="menuUser.php" class="btn btn-success">Pilih Menu Lain</a>
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