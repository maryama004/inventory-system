<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('location: login.php');
    exit;
}

include("config.php");

// Fetch all products
$sql = "SELECT * FROM products ORDER BY price_added DESC";
$result = $mysql_db->query($sql);

// Get totals
$total_products = $mysql_db->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];
$total_users = $mysql_db->query("SELECT COUNT(*) AS count FROM user")->fetch_assoc()['count'];
$total_orders = $mysql_db ->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="user_db.css">
  <link rel="stylesheet" href="admin_db.css">
</head>
<body class="dashboard-body">

  <div class="floaters">
    <div class="floater f1"></div>
    <div class="floater f2"></div>
    <div class="floater f3"></div>
  </div>

  <div class="dashboard">
    
    <div class="sidebar">
      <h2>Admin</h2>
      <a href="admin_db.php" class="active">Dashboard</a>
      <a href="add_product.php">Add Product</a>
      <a href="manage_users.php">Manage Users</a>
      <a href="view_orders.php">View Orders</a>
      <a href="logout.php">Logout</a>
    </div>

    <div class="main">
      <div class="topbar">
        <h1>Welcome, Admin</h1>
        <form method="post" action="logout.php">
          <button class="btn-logout" type="submit">Logout</button>
        </form>
      </div>

      <div class="card-grid">
        <div class="card-sm">
          <h3>Total Products</h3>
          <p><?= $total_products ?></p>
        </div>
        <div class="card-sm">
          <h3>Total Users</h3>
          <p><?= $total_users ?></p>
        </div>
        <div class="card-sm">
          <h3>Total Orders</h3>
          <?= $total_orders ?>
        </div>
      </div>

      <div class="table-container">
        <h2>Recent Products</h2>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Category</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Date Added</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['products_name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['price_added']}</td>
                        <td><a href='delete_product.php?id={$row['id']}' class='btn-outline delete'>Delete</a></td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='7' style='text-align:center;color:#aaa;'>No products found.</td></tr>";
            }

            $mysql_db->close();
            ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

</body>
</html>
