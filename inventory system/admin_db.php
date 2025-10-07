<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}


$tp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM products"))['c'];
$tu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users"))['c'];
$to = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders"))['c'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_db.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>Welcome, <?=htmlspecialchars($_SESSION['name'])?></h1>
      <form method="post" action="logout.php"><button class="logout-btn">Logout</button></form>
    </div>

    <div class="cards">
      <div class="card"><h3>Total Products</h3><p><?=$tp?></p></div>
      <div class="card"><h3>Total Users</h3><p><?=$tu?></p></div>
      <div class="card"><h3>Total Orders</h3><p><?=$to?></p></div>
    </div>

    <div class="table-container">
      <h2>Recent Products</h2>
      <table>
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Quantity</th><th>Price</th><th>Action</th></tr></thead>
        <tbody>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM products ORDER BY date_added DESC LIMIT 10");
        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$r['id']}</td>
                <td>".htmlspecialchars($r['products_name'])."</td>
                <td>".htmlspecialchars($r['category'])."</td>
                <td>{$r['quantity']}</td>
                <td>{$r['price']}</td>
                <td>
                  <a href='delete_product.php?id={$r['id']}' style='color:red;' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                </td>
            </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
