<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Users</title>
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
    <div class="topbar"><h1>Manage Users</h1></div>

    <div class="table-container">
      <table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
        <tbody>
        <?php while ($u = mysqli_fetch_assoc($users)) { ?>
          <tr>
            <td><?=$u['id']?></td>
            <td><?=htmlspecialchars($u['full_name'])?></td>
            <td><?=htmlspecialchars($u['email'])?></td>
            <td><?=$u['role']?></td>
            <td>
              <?php if ($u['role'] !== 'Admin'): ?>
                <a href="delete_user.php?id=<?=$u['id']?>" style="color:red;" onclick="return confirm('Delete user?')">Delete</a>
              <?php else: ?>
                <span class="small">—</span>
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
