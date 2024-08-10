<?php
    //Database Connection
    $hostName = "localhost";
    $userName = "root";
    $password = "";

    //Create a connection
    $connection = mysqli_connect($hostName,$userName,$password);

    //Select Database
    mysqli_select_db($connection, "taskmanagerdb");
?>