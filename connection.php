<?php

    // declare variables to connect to the phpmyadmin db
    $servername = "localhost";
    $username = "root";
    $password = "password"; //Put password
    $db_name = "hotel";
    // connection string to mysql phpmyadmin db
    $conn = new mysqli($servername, $username, $password, $db_name, 3306); //3306
    // if error, then display it
    if($conn->connect_error) {
        die("Connection Failed".$conn->connect_error);
    }

?>