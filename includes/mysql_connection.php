<?php
$servername = "localhost";
$username = "root";
$password = "root";

$con = mysqli_connect($servername, $username, $password);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

