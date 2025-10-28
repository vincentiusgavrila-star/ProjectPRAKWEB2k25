<?php 
    include 'env.php';
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (username, email, password) VALUES ('$nama', '$email', '$password')";
    if($koneksi->query($sql) === TRUE){
        // echo
    }else{
        echo("Error " . $sql . "<br>" . $koneksi->error);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="./login.php">LOGIN</a>
</body>

</html>