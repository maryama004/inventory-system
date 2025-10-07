<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'User') {
    header("Location: login.php");
    exit();
}

// fetch products
$products = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body>
  <div class="sidebar">
    <h2>User Panel</h2>
    <a href="user_dashboard.php">Dashboard</a>
    <a href="view_orders.php">My Orders</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>Welcome, <?=htmlspecialchars($_SESSION['name'])?></h1>
      <form method="post" action="logout.php"><button class="logout-btn">Logout</button></form>
    </div>

    <div class="table-container">
      <h2>Available Products</h2>
      <table>
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Quantity</th><th>Price</th><th>Order</th></tr></thead>
        <tbody>
          <?php while ($p = mysqli_fetch_assoc($products)) { ?>
            <tr>
              <td><?=$p['id']?></td>
              <td><?=htmlspecialchars($p['product_name'])?></td>
              <td><?=htmlspecialchars($p['category'])?></td>
              <td><?=$p['quantity']?></td>
              <td><?=$p['price']?></td>
              <td>
                <?php if ($p['quantity'] > 0): ?>
                <form method="post" action="place_order.php" style="display:inline-block;">
                  <input type="hidden" name="product_id" value="<?=$p['id']?>">
                  <input type="number" name="quantity" min="1" max="<?=$p['quantity']?>" value="1" style="width:80px;display:inline-block;">
                  <button type="submit">Buy</button>
                </form>
                <?php else: ?>
                  <span class="small">Out of stock</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
