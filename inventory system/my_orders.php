<?php
include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $product_name = $_POST["product_name"];
    $category = $_POST["category"];
    $quantity = (int) $_POST["quantity"];
    $price = (float) $_POST["price"];

    $query = "INSERT INTO orders (full_name, email, product, category, quantity, price, order_date)
              VALUES ('$full_name', '$email', '$product_name', '$category', '$quantity', '$price' * '$quantity', NOW())";

    if (mysqli_query($mysql_db, $query)) {
        $last_order_id = mysqli_insert_id($mysql_db);
        header("Location: receipt.php?id=" . $last_order_id);
        exit();
    } else {
        echo "❌ Error placing order: " . mysqli_error($mysql_db);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Place an Order</title>

  <style>
    :root {
      --bg1: #0f172a;
      --bg2: #06233a;
      --card: #0b1220;
      --accent: #00d4ff;
      --accent-2: #7c4dff;
      --glass: rgba(255, 255, 255, 0.06);
      --muted: rgba(255, 255, 255, 0.75);
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

    /* Sidebar */
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

    /* Main Content */
    .main-content {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .order-form {
      background: var(--glass);
      border-radius: var(--radius);
      padding: 32px 40px;
      box-shadow: var(--shadow);
      width: 400px;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    h2 {
      color: var(--accent);
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      color: var(--muted);
      margin-bottom: 6px;
      font-size: 14px;
    }

    input, select {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 16px;
      border-radius: 8px;
      border: none;
      outline: none;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 14px;
    }

    input::placeholder {
      color: #aaa;
    }

    button {
      width: 100%;
      background: linear-gradient(90deg, var(--accent), var(--accent-2));
      color: #021027;
      font-weight: bold;
      padding: 10px 0;
      border-radius: 8px;
      border: none;
      font-size: 15px;
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    button:hover {
      transform: scale(1.05);
    }

    .message {
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .success { color: #00ffb3; }
    .error { color: #ff4d4d; }

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
    <h2>User Panel</h2>
    <a href="user_db.php">Dashboard</a>
    <a href="order_form.php" class="active">Place Order</a>
    <a href="receipt.php">Receipts</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <form method="POST" class="order-form">
      <h2>Place an Order</h2>

      <?php if ($message): ?> 
        <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>

      <label>Full Name</label>
      <input type="text" name="full_name" placeholder="Enter your name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Product Name</label>
      <input type="text" name="product_name" placeholder="Enter product name" required>

      <label>Category</label>
      <select name="category" required>
        <option value="">Select category</option>
        <option value="Electronics">Electronics</option>
        <option value="Furniture">Furniture</option>
        <option value="Accessories">Accessories</option>
        <option value="Others">Others</option>
      </select>

      <label>Quantity</label>
      <input type="number" name="quantity" placeholder="Enter quantity" required min="1">

      <label>Price (₦)</label>
      <input type="number" name="price" placeholder="Enter unit price" step="0.01" required>

      <button type="submit">Submit Order</button>
    </form>
  </div>
</body>
</html>
