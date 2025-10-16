<?php
include "config.php"; // DB connection

// Fetch all orders from database
$query = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($mysql_db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Orders</title>

  <style>
    :root {
      --bg1: #0f172a;
      --bg2: #06233a;
      --card: #0b1220;
      --accent: #00d4ff;
      --accent-2: #7c4dff;
      --glass: rgba(255, 255, 255, 0.06);
      --muted: rgba(255, 255, 255, 0.65);
      --radius: 16px;
      --shadow: 0 6px 30px rgba(2, 6, 23, 0.6);
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
    }

    body {
      margin: 0;
      color: #e6eef8;
      background: linear-gradient(120deg, var(--bg1), var(--bg2));
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar (Left Navbar) */
    .sidebar {
      width: 240px;
      background: var(--glass);
      backdrop-filter: blur(10px);
      border-right: 1px solid rgba(255, 255, 255, 0.05);
      padding: 24px 16px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .sidebar h2 {
      color: var(--accent);
      font-size: 20px;
      margin-bottom: 12px;
    }

    .sidebar a {
      color: var(--muted);
      text-decoration: none;
      font-size: 15px;
      padding: 10px 14px;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: linear-gradient(90deg, var(--accent), var(--accent-2));
      color: #021027;
      font-weight: 600;
    }

    /* Main Content Area */
    .main-content {
      flex: 1;
      padding: 32px 40px;
      overflow-y: auto;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .topbar h1 {
      color: var(--accent);
      font-size: 24px;
    }

    /* Table */
    .table-container {
      background: var(--glass);
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      padding: 24px;
      box-shadow: var(--shadow);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    th, td {
      text-align: left;
      padding: 12px 10px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    th {
      color: var(--accent);
      font-weight: 600;
    }

    .delete-btn {
      background: linear-gradient(90deg, var(--accent), var(--accent-2));
      color: #021027;
      padding: 6px 12px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 13px;
      transition: transform 0.2s ease;
      margin-right: 6px;
    }

    .delete-btn:hover {
      transform: scale(1.05);
    }

    @media(max-width: 700px) {
      body {
        flex-direction: column;
      }

      .sidebar {
        flex-direction: row;
        overflow-x: auto;
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      }

      .main-content {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Admin</h2>
    <a href="admin_db.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php" class="active">View Orders</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="topbar">
      <h1>All Orders</h1>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Product</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['product']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>₦<?= number_format($row['price'] * $row['quantity'], 2) ?></td>
                <td><?= $row['order_date'] ?></td>
                <td>
                  <a href="delete_order.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" style="text-align:center; color:#aaa;">No orders found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
