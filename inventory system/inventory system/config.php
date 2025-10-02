<?php
$host = "localhost";
$db_username = "root";
$db_password = "";
$db = "inventory-db";

$conn = new mysqli($host, $db_username, $db_password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
