<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "projectcafedh";

    $koneksi = new mysqli($hostname, $username, $password, $database);

    if($koneksi -> connect_error){
        die("koneksi gagal: " . $koneksi -> connect_error);
    }
?>