<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory System - Login</title>
  <link rel="stylesheet" href="loginstyle.css">
</head>
<body>

  <div class="login-container">
    <h2>Login</h2>
    <form method="post">
      <div class="form-group">
        <label for="username">email</label>
        <input type="text" id="email" name="email" placeholder="Enter email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
      </div>
      <button type="submit" class="btn-login">Login</button>
    </form>
    <div class="sign-up">
      <p>Don’t have an account? <a href="signup.html">Sign Up</a></p>
    </div>
  </div>
  <?php
  session_start();
  include ("config.php");

  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST["email"];
      $password = $_POST["password"];


$sqlQuery = "SELECT id, email, password FROM user_profile WHERE email=? AND password=?";
$stmt = $conn->prepare($sqlQuery);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $db_email, $db_password);
    $stmt->fetch();

    $_SESSION['user'] = $db_email;
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid email or password!";
}
}
?>


</body>
</html>
