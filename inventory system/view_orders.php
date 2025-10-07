<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id'])) header("Location: login.php");

if ($_SESSION['role'] === 'Admin') {
    $q = mysqli_query($conn, "SELECT o.*, products_name, full_name FROM orders o
        LEFT JOIN products p ON product_id = id
        LEFT JOIN users u ON user_id = u.id
        ORDER BY order_date DESC");
} else {
    $uid = (int)$_SESSION['user_id'];
    $q = mysqli_query($conn, "SELECT o.*, products_name FROM orders o
        LEFT JOIN products p ON o.product_id = o.id
        WHERE user_id = $uid ORDER BY order_date DESC");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>View Orders</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body>
  <div class="sidebar">
    <?php if ($_SESSION['role']==='Admin'): ?>
      <h2>Admin Panel</h2>
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="add_product.php">Add Product</a>
      <a href="manage_users.php">Manage Users</a>
      <a href="view_orders.php">View Orders</a>
    <?php else: ?>
      <h2>User Panel</h2>
      <a href="user_db.php">Dashboard</a>
      <a href="view_orders.php">My Orders</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main-content">
    <div class="topbar"><h1>Orders</h1></div>

    <div class="table-container">
      <table>
        <thead><tr><th>ID</th><th>Product</th><?php if($_SESSION['role']==='Admin') echo '<th>User</th>'; ?><th>Qty</th><th>Total</th><th>Date</th><th>Receipt</th></tr></thead>
        <tbody>
        <?php while ($o = mysqli_fetch_assoc($q)) { ?>
          <tr>
            <td><?=$o['id']?></td>
            <td><?=htmlspecialchars($o['product_name'])?></td>
            <?php if ($_SESSION['role']==='Admin') echo "<td>".htmlspecialchars($o['full_name'])."</td>"; ?>
            <td><?=$o['quantity']?></td>
            <td>₦<?=number_format($o['total_price'],2)?></td>
            <td><?=$o['order_date']?></td>
            <td><a href="receipt.php?id=<?=$o['id']?>" target="_blank">View</a></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
