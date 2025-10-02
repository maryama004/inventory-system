<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory System - Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

  <div class="signup-container">
    <h2>Create Account</h2>
    <form class="form" id="signup-form" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="cpassword" placeholder="Confirm password" required>
      </div>
      <button type="submit" class="btn-signup">Sign Up</button>
    </form>
    <div class="extra-links">
      <p>Already have an account? <a href="login.html">Login</a></p>
    </div>
  </div>

  <?php
  
    $db = "inventory-db";
    $db_username = "root";
    $db_password = "";
    $host = "localhost";

    $conn = new mysqli($host, $db_username, $db_password, $db);

  
  if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password= $_POST["password"];


    

    $stmt = $conn->prepare("INSERT INTO user_profile(user_name, email,password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username,  $email, $password);

    if ($stmt->execute()) {
        echo "SUCESS";
    } else {
        echo "FAILED";
    }

    $stmt->close();
}
?>




</body>
</html>
