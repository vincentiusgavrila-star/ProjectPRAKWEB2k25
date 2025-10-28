<?php 
include 'env.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users where email='$email' AND password= '$password' ");

// var_dump($query);

$cek = mysqli_num_rows($query);

if($cek > 0){
    $_SESSION['username'] = $username;
    header("location:dashboard.php");
}else{
    header("location:login.php?pesan=gagal");
}
?>