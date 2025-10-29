<?php
session_start();
include 'env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $koneksi->real_escape_string($_POST['name']);
    $description = $koneksi->real_escape_string($_POST['description']);
    $price = $koneksi->real_escape_string($_POST['price']);
    $category = $koneksi->real_escape_string($_POST['category']);
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Nama menu harus diisi";
    }
    
    if (empty($price) || $price <= 0) {
        $errors[] = "Harga harus lebih dari 0";
    }
    
    if (empty($category)) {
        $errors[] = "Kategori harus dipilih";
    }
    
    if (!empty($errors)) {
        $errorString = urlencode(implode(', ', $errors));
        header("Location: formMenuAdmin.php?error=" . $errorString);
        exit();
    }
    
    $sql = "INSERT INTO products (name, description, price, category) VALUES ('$name', '$description', '$price', '$category')";
    
    if ($koneksi->query($sql) === TRUE) {
        header("Location: formMenuAdmin.php?success=1");
        exit();
    } else {
        $errorMessage = urlencode("Error: " . $sql . "<br>" . $koneksi->error);
        header("Location: formMenuAdmin.php?error=" . $errorMessage);
        exit();
    }
} else {
    header("Location: formMenuAdmin.php");
    exit();
}
?>