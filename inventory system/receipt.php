<?php
include "config.php"; // your DB connection file

// Check if an order ID is provided
if (!isset($_GET['id'])) {
  die("No order ID provided.");
}

$order_id = intval($_GET['id']); // sanitize input

// Fetch order details
$query = "SELECT * FROM orders WHERE id = $order_id";
$result = mysqli_query($mysql_db, $query);

if (mysqli_num_rows($result) == 0) {
  die("Order not found.");
}

$order = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Receipt #<?= htmlspecialchars($order['id']) ?></title>
  <link rel="stylesheet" href="user_db.css">

  <style>
    :root {
      --bg1: #0f172a;
      --bg2: #06233a;
      --accent: #00d4ff;
      --accent-2: #7c4dff;
      --glass: rgba(255,255,255,0.06);
      --muted: rgba(255,255,255,0.7);
      --radius: 16px;
      --shadow: 0 6px 30px rgba(2,6,23,0.6);
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(120deg, var(--bg1), var(--bg2));
      color: #e6eef8;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      background: var(--glass);
      backdrop-filter: blur(10px);
      width: 240px;
      padding: 24px 16px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      border-right: 1px solid rgba(255,255,255,0.05);
    }

    .sidebar h2 { color: var(--accent); font-size: 20px; margin-bottom: 12px; }
    .sidebar a { color: var(--muted); text-decoration: none; padding: 10px 14px; border-radius: 8px; }
    .sidebar a.active, .sidebar a:hover { background: linear-gradient(90deg, var(--accent), var(--accent-2)); color: #021027; font-weight: 600; }

    .main-content { flex: 1; padding: 32px 40px; overflow-y: auto; }

    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .topbar h1 { font-size: 24px; color: var(--accent); }

    .print-btn {
      padding: 10px 18px;
      border-radius: 10px;
      border: none;
      background: linear-gradient(90deg, var(--accent), var(--accent-2));
      color: #021027;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.15s ease;
    }

    .print-btn:hover { transform: scale(1.05); }

    .receipt {
      background: var(--glass);
      padding: 30px;
      border-radius: var(--radius);
      border: 1px solid rgba(255,255,255,0.05);
      max-width: 600px;
      margin: 0 auto;
      box-shadow: var(--shadow);
    }

    .receipt p { font-size: 15px; margin: 10px 0; color: var(--muted); }
    .receipt strong { color: #fff; }
    .receipt h2 { color: var(--accent); text-align: center; margin-bottom: 20px; }

    @media print {
      .sidebar, .print-btn { display: none; }
      .main-content { margin: 0; padding: 0; }
      body { background: white; color: black; }
      .receipt { background: white; border: none; box-shadow: none; }
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>User Panel</h2>
    <a href="user_db.php">Dashboard</a>
    <a href="my_orders.php">My Orders</a>
    <a href="#" class="active">Receipt</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>Receipt #<?= htmlspecialchars($order['id']) ?></h1>
      <button onclick="window.print()" class="print-btn">🖨️ Print</button>
    </div>

    <div class="receipt">
      <h2>Order Receipt</h2>
      <p><strong>Customer:</strong> <?= htmlspecialchars($order['full_name']) ?> (<?= htmlspecialchars($order['email']) ?>)</p>
      <p><strong>Product:</strong> <?= htmlspecialchars($order['product']) ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars($order['category']) ?></p>
      <p><strong>Quantity:</strong> <?= htmlspecialchars($order['quantity']) ?></p>
      <p><strong>Total Price:</strong> ₦<?= number_format($order['price'], 2) ?></p>
      <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
    </div>
  </div>
</body>
</html>
