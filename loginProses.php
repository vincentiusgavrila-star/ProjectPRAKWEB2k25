<?php 
include 'env.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if($email === 'admin@gmail.com' && $password === 'adminGanteng123'){
    $_SESSION['username'] = 'admin';
    header("location:formMenuAdmin.php");
    exit();
}

$stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $user = $result->fetch_assoc();
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id_user'];
    header("location:dashboard.php");
    exit();
}else{
    header("location:login.php?pesan=gagal");
    exit();
}
$stmt->close();
?>