<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products - Inventory</title>
  <link rel="stylesheet" href="dbstyle.css">
</head>
<body>

  
  <div class="sidebar">
    <h2>Inventory</h2>
    <a href="dashboard.html">Dashboard</a>
    <a href="products.html" style="background:#375ac3;">Products</a>
    <a href="categories.html">Categories</a>
    <a href="suppliers.html">Suppliers</a>
    <a href="reports.html">Reports</a>
    <a href="login.html">Logout</a>
  </div>

  
  <div class="main-content">
    <div class="topbar">
      <h1>Products</h1>
      <button style="padding:8px 15px; border:none; border-radius:6px; background:#1cc88a; color:white; cursor:pointer;">+ Add Product</button>
    </div>

    <div class="table-container">
      <h2>Product List</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Supplier</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Laptop</td>>
            <td>Electronics</td>
            <td>25</td>
            <td>₦800</td>
            <td>you</td>
            <td>
              <button style="background:#4e73df;color:#fff;padding:5px 10px;border:none;border-radius:4px;">Edit</button>
              <button style="background:#e74a3b;color:#fff;padding:5px 10px;border:none;border-radius:4px;">Delete</button>
            </td>
          </tr>
          <tr>
            <td>Chair</td>
            <td>Furniture</td>
            <td>50</td>
            <td>₦120</td>
            <td>me</td>
            <td>
              <button style="background:#4e73df;color:#fff;padding:5px 10px;border:none;border-radius:4px;">Edit</button>
              <button style="background:#e74a3b;color:#fff;padding:5px 10px;border:none;border-radius:4px;">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
