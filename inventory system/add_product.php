<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}
$msg = '';
if (isset($_POST['add'])) {
    $name = esc($_POST['name']);
    $cat = esc($_POST['category']);
    $qty = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    mysqli_query($conn, "INSERT INTO products (product_name, category, quantity, price) VALUES ('$name','$cat',$qty,$price)");
    $msg = "Product added.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>Add Product</h1>
      <form method="post" action="logout.php"><button class="logout-btn">Logout</button></form>
    </div>

    <div class="table-container">
      <?php if ($msg) echo "<div style='color:green;margin-bottom:10px;'>$msg</div>"; ?>
      <form method="post" class="card-form">
        <label>Product Name</label>
        <input type="text" name="name" required>
        <label>Category</label>
        <input type="text" name="category" required>
        <label>Quantity</label>
        <input type="number" name="quantity" min="0" value="1" required>
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="0" required>
        <button type="submit" name="add">Add Product</button>
      </form>
    </div>

  </div>
</body>
</html>
