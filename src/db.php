<?php
$servername = "db";
$username = "root";
$password = "password";
$dbname = "project";

$connection = new mysqli ($servername, $username, $password, $dbname);

if($connection->connect_error){
    die("connection failed:" . $connection->connect_error);
}

?>