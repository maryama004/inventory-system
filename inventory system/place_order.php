<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'User') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['qty']);

    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$pid LIMIT 1");
    if (!$res || mysqli_num_rows($res) === 0) {
        die("Product not found");
    }
    $p = mysqli_fetch_assoc($res);
    if ($qty > $p['quantity']) {
        die("Requested quantity not available");
    }

    $total = $qty * $p['price'];
    $user_id = (int)$_SESSION['user_id'];
    mysqli_query($conn, "INSERT INTO orders (product_id,user_id,quantity,total_price) VALUES ($pid,$user_id,$qty,$total)");
    $order_id = mysqli_insert_id($conn);

    
    mysqli_query($conn, "UPDATE products SET quantity = quantity - $qty WHERE id = $pid");

    header("Location: receipt.php?id=$order_id");
    exit();
}
?>
