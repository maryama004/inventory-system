<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// 1️⃣ Get total active orders (not completed)
$active_orders = $mysql_db->query("SELECT COUNT(*) AS count FROM orders WHERE id = $user_id ")->fetch_assoc()['count'];

// 2️⃣ Get total purchases (sum of all paid orders)
$total_purchases = $mysql_db->query("SELECT IFNULL(SUM(price), 0) AS total FROM orders WHERE id = $user_id")->fetch_assoc()['total'];

// 3️⃣ Get total pending payments
$pending_payments = $mysql_db->query("SELECT IFNULL(SUM(price), 0) AS total FROM orders WHERE id = $user_id ")->fetch_assoc()['total'];

// 4️⃣ Get recent products (optional)
$products = $mysql_db->query("SELECT * FROM products ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="user_db.css">
</head>

<body>
  <div class="floaters">
    <div class="floater f1"></div>
    <div class="floater f2"></div>
    <div class="floater f3"></div>
  </div>

  <div class="dashboard">
    <aside class="sidebar">
      <h2>Inventory</h2>
      <a href="user_db.php" class="active">Dashboard</a>
      <a href="my_orders.php">My Orders</a>
      <a href="receipt.php">Receipts</a>
      <a href="logout.php">Logout</a>
    </aside>

    <main class="main">
       <h1>Welcome,</h1> 
       <!-- <?= htmlspecialchars($_SESSION['full_name']) ?>! -->

      <div class="card-grid">
        <div class="card-sm">
          <h3>Active Orders</h3>
          <p><?= $active_orders ?> in progress</p>
        </div>
        <div class="card-sm">
          <h3>Total Purchases</h3>
          <p>₦<?= number_format($total_purchases, 2) ?></p>
        </div>
        <div class="card-sm">
          <h3>Pending Payments</h3>
          <p>₦<?= number_format($pending_payments, 2) ?></p>
        </div>
      </div>

      <h2 style="margin-top: 30px;">Recent Products</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Price (₦)</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($products->num_rows > 0): ?>
            <?php while ($p = $products->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($p['products_name']) ?></td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td><?= number_format($p['price'], 2) ?></td>
                <td><?= $p['quantity'] ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" style="text-align:center;color:#aaa;">No products found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

    </main>
  </div>
</body>
</html>
