<?php 
    include 'env.php';
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    $sql = "INSERT INTO products (name, description, price, category) VALUES ('$name', '$description', '$price', '$category')";
    if($koneksi->query($sql) === TRUE){
        // echo("Data berhasil ditambahkan");            // echo("<br> <a href= '../index.php'>HOME</a>");
    }else{
        echo("Error " . $sql . "<br>" . $koneksi->error);
    }
?>