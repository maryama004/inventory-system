<?php
$host = "localhost";
$db_username = "root";
$db_password = "";
$db = "inventory_system";

$conn = new mysqli($host, $db_username, $db_password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
