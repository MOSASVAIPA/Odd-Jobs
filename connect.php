<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dname = "database";

    $conn = new mysqli($servername, $username, $password, $dname);
    if($conn->connect_error){
        die("connection failed".$conn->connect_error);
    } 
?>