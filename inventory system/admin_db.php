<?php
session_start();
include "config.php";
if ($_SESSION['role'] !== 'Admin') {
    header("Location: user_db.php");
    exit();
}
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
      <h2>Admin </h2>
      <a href="admin_db.php" class="active">Dashboard</a>
      <a href="add_product.php">Add Product</a>
      <a href="manage_users.php">Manage Users</a>
      <a href="view_orders.php">View Orders</a>
      <a href="logout.php">Logout</a>
    </div>

    
    <div class="main">
      <div class="topbar">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h1>
        <form method="post" action="logout.php">
          <button class="btn-logout">Logout</button>
        </form>
      </div>

      
      <div class="card-grid">
        <div class="card-sm">
          <h3>Total Products</h3>
          <p><?= $tp ?></p>
        </div>
        <div class="card-sm">
          <h3>Total Users</h3>
          <p><?= $tu ?></p>
        </div>
        <div class="card-sm">
          <h3>Total Orders</h3>
          <p><?= $to ?></p>
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
              <th>Action</th>
            </tr>
          </thead>
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
                  <a href='delete_product.php?id={$r['id']}' class='btn-outline delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                </td>
              </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
