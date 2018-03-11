<?php
$server = "localhost";
$user = "root";
$pass = "";

try {
    $connection = new PDO("mysql:host=$server;dbname=travel", $user, $pass);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
