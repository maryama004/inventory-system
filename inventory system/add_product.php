<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('location: login.php');
    exit;
}

include ("config.php");

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    
    $sql = "INSERT INTO products (products_name, category, quantity, price)
            VALUES (?, ?, ?, ?)";

    $stmt = $mysql_db->prepare($sql);
    $stmt->bind_param("ssid", $name, $category, $quantity, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysql_db->close();
?>
   

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Product | Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    /* ===== Theme Variables ===== */
    :root {
      --bg: #0c1427;
      --glass: rgba(255, 255, 255, 0.05);
      --muted: #cfd8dc;
      --accent: #64b5f6;
      --radius: 12px;
    }

    /* ===== Base Layout ===== */
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: var(--bg);
      color: #fff;
      display: flex;
      min-height: 100vh;
    }

    /* ===== Sidebar ===== */
    .sidebar {
      width: 230px;
      background: linear-gradient(180deg, #0d1b3d, #101f4a);
      padding: 28px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      box-shadow: 2px 0 10px rgba(0,0,0,0.25);
    }

    .sidebar h2 {
      color: var(--accent);
      font-size: 20px;
      margin-bottom: 40px;
      font-weight: 600;
    }

    .sidebar a {
      width: 80%;
      color: var(--muted);
      text-decoration: none;
      padding: 10px 16px;
      text-align: center;
      border-radius: 8px;
      margin: 6px 0;
      transition: 0.25s;
      font-weight: 500;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: var(--accent);
      color: #021027;
      font-weight: 600;
    }

    /* ===== Main Content ===== */
    .main-content {
      margin-left: 230px;
      padding: 40px;
      flex: 1;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
    }

    .topbar h1 {
      color: var(--accent);
      font-size: 24px;
      font-weight: 600;
    }

    .btn-logout {
      background: transparent;
      border: 1px solid rgba(255,255,255,0.25);
      color: var(--muted);
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.25s ease;
    }

    .btn-logout:hover {
      background: var(--accent);
      color: #021027;
    }

    /* ===== Add Product Form ===== */
    .table-container {
      background: var(--glass);
      padding: 32px;
      border-radius: var(--radius);
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: 0 4px 16px rgba(0,0,0,0.25);
      max-width: 600px;
      margin: 0 auto;
    }

    .table-container h2 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 24px;
      font-weight: 600;
    }

    .card-form {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .card-form label {
      color: var(--muted);
      font-weight: 500;
      font-size: 15px;
    }

    .card-form input {
      padding: 10px 12px;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 8px;
      background: rgba(255,255,255,0.08);
      color: #fff;
      font-size: 15px;
      transition: 0.25s;
    }

    .card-form input:focus {
      outline: none;
      border-color: var(--accent);
      background: rgba(255,255,255,0.12);
    }

    .card-form button {
      background: var(--accent);
      color: #021027;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.25s;
    }

    .card-form button:hover {
      background: #90caf9;
      transform: translateY(-2px);
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .table-container {
        width: 100%;
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_db.php">Dashboard</a>
    <a href="add_product.php" class="active">Add Product</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>Add Product</h1>
      <form method="post" action="logout.php">
        <button class="btn-logout">Logout</button>
      </form>
    </div>

    <div class="table-container">
      <h2>Add New Product</h2>
      <?php if (isset($msg)) echo "<div style='color:#81c784;margin-bottom:10px;'>$msg</div>"; ?>
      <form method="post" class="card-form">
        <label>Product Name</label>
        <input type="text" name="name" placeholder="Enter product name" required>

        <label>Category</label>
        <input type="text" name="category" placeholder="Enter category" required>

        <label>Quantity</label>
        <input type="number" name="quantity" min="0" value="1" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="0" required>

        <button type="submit" name="add">Add Product</button>
      </form>
    </div>
  </div>
</body>
</html>
