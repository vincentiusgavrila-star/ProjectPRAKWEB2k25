<?php
session_start();
include 'env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        $_SESSION['error'] = "Anda harus login terlebih dahulu";
        header("Location: index.php#contact");
        exit();
    }
    $name = $koneksi->real_escape_string($_POST['name']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $message = $koneksi->real_escape_string($_POST['message']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    // Validasi
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Nama harus diisi";
    }
    
    if (empty($email)) {
        $errors[] = "Email harus diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($message)) {
        $errors[] = "Pesan harus diisi";
    }

    // Jika ada error, redirect kembali
    if (!empty($errors)) {
        $_SESSION['contact_errors'] = $errors;
        header("Location: index.php#contact");
        exit();
    }

    // konek db
    $stmt = $koneksi->prepare("INSERT INTO contact_messages (name, email, message, user_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    
    if ($stmt) {
        $stmt->bind_param("sssi", $name, $email, $message, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Pesan berhasil dikirim!";
            header("Location: index.php#contact");
            exit();
        } else {
            $_SESSION['error'] = "Terjadi kesalahan sistem: " . $stmt->error;
            header("Location: index.php#contact");
            exit();
        }
        
        $stmt->close();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan sistem";
        header("Location: index.php#contact");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>