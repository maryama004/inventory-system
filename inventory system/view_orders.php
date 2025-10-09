<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>View Orders</title>
  <link rel="stylesheet" href="user_db.css">
  <style>
  
  body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background-color: #f4f6f8;
    display: flex;
  }

  
  .sidebar {
    width: 230px;
    background-color: #1a237e;
    color: #fff;
    height: 100vh;
    padding: 20px 0;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .sidebar h2 {
    margin-bottom: 40px;
    font-size: 22px;
    font-weight: 600;
  }

  .sidebar a {
    text-decoration: none;
    color: #bbb;
    display: block;
    width: 80%;
    padding: 10px 15px;
    margin: 6px 0;
    border-radius: 6px;
    transition: 0.3s;
    text-align: center;
  }

  .sidebar a:hover,
  .sidebar a.active {
    background-color: #3949ab;
    color: #fff;
  }

  
  .main-content {
    margin-left: 250px;
    padding: 25px;
    width: calc(100% - 250px);
    overflow-x: auto;
  }

  .topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
  }

  .topbar h1 {
    color: #1a237e;
    font-size: 24px;
  }

  
  .table-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    min-width: 850px; 
  }

  table th,
  table td {
    border: 1px solid #ddd;
    padding: 8px 10px;
    text-align: center;
    font-size: 14px;
    white-space: nowrap;
  }

  table th {
    background-color: #1a237e;
    color: white;
    font-weight: 500;
  }

  table tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  table tr:hover {
    background-color: #f1f1f1;
  }

  a.view-btn {
    background-color: #4CAF50;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
  }

  a.view-btn:hover {
    background-color: #388e3c;
  }

  a.delete-btn {
    background-color: #e53935;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
  }

  a.delete-btn:hover {
    background-color: #b71c1c;
  }


  @media (max-width: 1100px) {
    .main-content {
      margin-left: 200px;
      width: calc(100% - 200px);
    }

    .sidebar {
      width: 200px;
    }

    table {
      min-width: 700px;
    }
  }

  @media (max-width: 768px) {
    .sidebar {
      display: none;
    }
    .main-content {
      margin-left: 0;
      width: 100%;
    }
  }
</style>

  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_db.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php" class="active">View Orders</a>
    <a href="logout.php">Logout</a>
  </div>

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
          <?php
          $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
          while ($o = mysqli_fetch_assoc($orders)) {
              echo "<tr>
                <td>{$o['id']}</td>
                <td>".htmlspecialchars($o['full_name'])."</td>
                <td>".htmlspecialchars($o['email'])."</td>
                <td>".htmlspecialchars($o['product_name'])."</td>
                <td>".htmlspecialchars($o['category'])."</td>
                <td>{$o['quantity']}</td>
                <td>₦".number_format($o['total_price'], 2)."</td>
                <td>{$o['order_date']}</td>
                <td>
                  <a href='receipt.php?id={$o['id']}' class='view-btn'>View</a>
                  <a href='delete_order.php?id={$o['id']}' class='delete-btn' onclick='return confirm(\"Delete this order?\")'>Delete</a>
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
