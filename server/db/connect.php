<?php

//Please modify connection settings according to mySql 

$servername = "localhost";
$username = "";
$password = "";
$dbName = "";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 
?>