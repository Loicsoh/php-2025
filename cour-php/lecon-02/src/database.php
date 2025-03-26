<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'cour_php';
    
    $conn = new mysqli($host, $username, $password, $database);
        if ($conn -> connect_error){
            echo "connection failed";
        }else{
            echo "connection success";
        }
//     $sql = "CREATE DATABASE IF NOT EXISTS cour_php";



?>