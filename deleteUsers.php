<?php 
include 'env.php';
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $query = "DELETE FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    header("Location:dashboardAdmin.php");
}

?>