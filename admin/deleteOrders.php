<?php
session_start();
include 'env.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $check_query = "SELECT id FROM orders WHERE id = '$id'";
    $check_result = $koneksi->query($check_query);
    
    if ($check_result && $check_result->num_rows > 0) {
        $delete_query = "DELETE FROM orders WHERE id = '$id'";
        if ($koneksi->query($delete_query)) {
            $_SESSION['success'] = "Order berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus order: " . $koneksi->error;
        }
    } else {
        $_SESSION['error'] = "Order tidak ditemukan.";
    }
} else {
    $_SESSION['error'] = "ID order tidak valid.";
}

header("Location: dashboardAdmin.php");
exit();
?>