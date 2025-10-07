<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='Admin') { header("Location: login.php"); exit(); }
if (!isset($_GET['id'])) { header("Location: manage_users.php"); exit(); }
$id = (int)$_GET['id'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM users WHERE id=$id LIMIT 1"));
if ($u && $u['role']!=='Admin') {
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
}
header("Location: manage_users.php");
exit();
?>
