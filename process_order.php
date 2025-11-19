<?php
// process_order.php
session_start();
require_once 'env.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu untuk melakukan pemesanan.";
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $koneksi->real_escape_string($_POST['product_id']);
    $quantity = $koneksi->real_escape_string($_POST['quantity']);
    $notes = $koneksi->real_escape_string($_POST['notes'] ?? '');
    
    // Validasi quantity
    if ($quantity < 1) {
        $_SESSION['error'] = "Jumlah pesanan tidak valid.";
        header("Location: order.php?item_id=" . $product_id);
        exit();
    }
    
    // Cek apakah produk exists
    $product_query = "SELECT * FROM products WHERE id = '$product_id'";
    $product_result = $koneksi->query($product_query);
    
    if ($product_result->num_rows == 0) {
        $_SESSION['error'] = "Produk tidak ditemukan.";
        header("Location: menuUser.php");
        exit();
    }
    
    $product = $product_result->fetch_assoc();
    $total_price = $product['price'] * $quantity;
    
    // Insert order ke database TANPA STATUS
    $insert_query = "INSERT INTO orders (user_id, product_id, quantity, notes) 
                     VALUES ('$user_id', '$product_id', '$quantity', '$notes')";
    
    if ($koneksi->query($insert_query)) {
        $_SESSION['success'] = "Pesanan berhasil dibuat! Total: Rp " . number_format($total_price, 0, ',', '.');
        header("Location: order_history.php");
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat memproses pesanan: " . $koneksi->error;
        header("Location: order.php?item_id=" . $product_id);
    }
    
    exit();
} else {
    $_SESSION['error'] = "Data tidak valid.";
    header("Location: menuUser.php");
    exit();
}
?>