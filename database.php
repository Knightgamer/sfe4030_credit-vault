<?php
$hostname = "localhost";
$dbname = "root";
$password = "";
$database = "credit_control";

$conn = new mysqli($hostname, $dbname, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
