<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='Admin') { header("Location: login.php"); exit(); }
if (!isset($_GET['id'])) { header("Location: admin_dashboard.php"); exit(); }
$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM products WHERE id=$id");
header("Location: admin_dashboard.php");
exit();
?>
