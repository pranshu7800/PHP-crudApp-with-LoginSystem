<?php
$server ="localhost";
$username = "root";
$password = "";
$db = "users";

$conn = mysqli_connect($server, $username, $password, $db);

if(!$conn){
    die("Error: " . mysqli_connect_error());
}
?>