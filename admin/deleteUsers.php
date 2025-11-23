<?php 
include 'env.php';
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("location: ../login.php");
    exit();
}
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $query = "DELETE FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    header("Location:dashboardAdmin.php");
}

?>