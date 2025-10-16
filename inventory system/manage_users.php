<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('location: login.php');
    exit;
}

require_once 'config.php';

$username = $password = $role = '';
$username_err = $password_err = $role_err = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {

    
    if (empty(trim($_POST['username']))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST['username']);
    }

    
    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter password.";
    } else {
        $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    }

  
    if (empty(trim($_POST['role']))) {
        $role_err = "Please enter role (admin/user).";
    } else {
        $role = trim($_POST['role']);
    }

    
    if (empty($username_err) && empty($password_err) && empty($role_err)) {
        $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
        if ($stmt = $mysql_db->prepare($sql)) {
            $stmt->bind_param("sss", $username, $password, $role);

            if ($stmt->execute()) {
                echo "User added successfully.";
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
  }
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql = "DELETE FROM user WHERE id = ?";
    if ($stmt = $mysql_db->prepare($sql)) {
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Something went wrong.";
        }
        $stmt->close();
    }
}


$sql = "SELECT * FROM user";
$result = $mysql_db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users - Admin Panel</title>
  <link rel="stylesheet" href="user_db.css">
  <link rel="stylesheet" href="manage_users.css">
</head>
<body class="dashboard-body">

  
  <div class="floaters">
    <div class="floater f1"></div>
    <div class="floater f2"></div>
    <div class="floater f3"></div>
  </div>

  <div class="dashboard">
    
    <div class="sidebar">
      <h2>Admin Panel</h2>
      <a href="admin_db.php">Dashboard</a>
      <a href="add_product.php">Add Product</a>
      <a href="manage_users.php" class="active">Manage Users</a>
      <a href="view_orders.php">View Orders</a>
      <a href="logout.php">Logout</a>
    </div>

    
    <div class="main">
      <div class="topbar">
        <h1>Manage Users</h1>
        <button class="btn-primary">+ Add User</button>
      </div>

      <div class="table-container">
        <table class="table users-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($u = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['full_name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                  <span class="role <?= strtolower($u['role']) ?>">
                    <?= $u['role'] ?>
                  </span>
                </td>
                <td>
                  <?php if ($u['role'] !== 'Admin'): ?>
                    <a href="delete_user.php?id=<?= $u['id'] ?>" class="btn-outline delete" onclick="return confirm('Delete this user?')">Delete</a>
                  <?php else: ?>
                    <span class="muted">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
