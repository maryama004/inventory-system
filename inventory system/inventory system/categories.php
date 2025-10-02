<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories - Inventory</title>
  <link rel="stylesheet" href="dbstyle.css">
</head>
<body>

  
  <div class="sidebar">
    <h2>Inventory</h2>
    <a href="dashboard.html">Dashboard</a>
    <a href="products.html">Products</a>
    <a href="categories.html" style="background:#375ac3;">Categories</a>
    <a href="suppliers.html">Suppliers</a>
    <a href="reports.html">Reports</a>
    <a href="login.html">Logout</a>
  </div>

  
  <div class="main-content">
    <div class="topbar">
      <h1>Categories</h1>
      <button style="padding:8px 15px; border:none; border-radius:6px; background:#1cc88a; color:white; cursor:pointer;">+ Add Category</button>
    </div>

    <div class="table-container">
      <h2>Category List</h2>
      <table>
        <thead>
          <tr>
            <th>Category Name</th>
            <th>Description</th>
            <th>Products Count</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Electronics</td>
            <td>Devices and gadgets</td>
            <td>25</td>
            <td>
              <button style="background:#4e73df;color:#fff;padding:5px 10px;border:none;border-radius:4px;">Edit</button>
              <button style="background:#e74a3b;color:#fff;padding:5px 10px;border:none;border-radius:4px;">Delete</button>
            </td>
          </tr>
          <tr>
            <td>Furniture</td>
            <td>Chairs, tables, and desks</td>
            <td>12</td>
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
