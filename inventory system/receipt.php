<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) { echo "No order specified"; exit(); }
$id = (int)$_GET['id'];

// join orders, products, users
$q = mysqli_query($conn, "SELECT o.*, p.product_name, p.category, u.full_name, u.email
    FROM orders o
    LEFT JOIN products p ON o.product_id = p.id
    LEFT JOIN users u ON o.user_id = u.id
    WHERE o.id = $id LIMIT 1");

if (!$q || mysqli_num_rows($q) === 0) { echo "Order not found"; exit(); }
$o = mysqli_fetch_assoc($q);

// security: only allow admin or owner to view
if ($_SESSION['role'] !== 'Admin' && $_SESSION['user_id'] != $o['user_id']) {
    echo "Access denied"; exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Receipt #<?=$o['id']?></title>
  <link rel="stylesheet" href="inventory.css">
  <style> .receipt { max-width:600px; margin:20px auto; padding:20px; } .print-btn { float:right; } </style>
</head>
<body>
  <div class="main-content" style="margin-left:20px;">
    <div class="topbar">
      <h1>Receipt #<?=$o['id']?></h1>
      <button onclick="window.print()" class="logout-btn print-btn">Print</button>
    </div>

    <div class="table-container receipt">
      <p><strong>Customer:</strong> <?=htmlspecialchars($o['full_name'])?> (<?=htmlspecialchars($o['email'])?>)</p>
      <p><strong>Product:</strong> <?=htmlspecialchars($o['product_name'])?></p>
      <p><strong>Category:</strong> <?=htmlspecialchars($o['category'])?></p>
      <p><strong>Quantity:</strong> <?=$o['quantity']?></p>
      <p><strong>Total Price:</strong> ₦<?=number_format($o['total_price'],2)?></p>
      <p class="small">Order Date: <?=$o['order_date']?></p>
    </div>
  </div>
</body>
</html>
