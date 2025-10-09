
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Orders - Inventory System</title>
  <link rel="stylesheet" href="user_db.css" />
  <link rel="stylesheet" href="view_orders.css" />
</head>
<body class="dashboard-body">

  <div class="floaters">
    <div class="floater f1"></div>
    <div class="floater f2"></div>
    <div class="floater f3"></div>
  </div>

  <div class="dashboard">
    <div class="sidebar">
      <h2>Inventory</h2>
      <a href="user_db.php">Dashboard</a>
      <a href="my_orders.php" class="active">My Orders</a>
      <a href="receipt.php">Receipts</a>
      <a href="logout.php">Logout</a>
    </div>

    
    <div class="main">
      <h1>Orders</h1>

    
      <div class="orders-section">
        <div class="orders-header">
          <h2>Recent Orders</h2>
          <button class="btn-primary">+ New Order</button>
        </div>

        <table class="table orders-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Date</th>
              <th>Status</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>00123</td>
              <td>Maryam </td>
              <td>Oct 8, 2025</td>
              <td><span class="status pending">Pending</span></td>
              <td>₦220.00</td>
              <td><button class="btn-outline">View</button></td>
            </tr>
            <tr>
              <td>00122</td>
              <td>mufidah</td>
              <td>Oct 7, 2025</td>
              <td><span class="status completed">Completed</span></td>
              <td>₦89.99</td>
              <td><button class="btn-outline">View</button></td>
            </tr>
            <tr>
              <td>00121</td>
              <td>hafsat</td>
              <td>Oct 5, 2025</td>
              <td><span class="status cancelled">Cancelled</span></td>
              <td>₦45.00</td>
              <td><button class="btn-outline">View</button></td>
            </tr>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
