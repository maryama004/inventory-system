<?php
session_start();
include "config.php";

$message = '';

if (isset($_POST['signup'])) {
    $name = ($_POST['name']);
    $email = ($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    
    if ($password !== $confirm) {
        $message = "<span style='color:red;'>Passwords do not match.</span>";
    } else {
        
        $check = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "<span style='color:red;'>Email already registered.</span>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO  user (full_name, email, password, role) VALUES ('$name','$email','$hash','User')";
            if (mysqli_query($conn, $sql)) {
                $message = "<span style='color:green;'>Account created successfully! <a href='login.php'>Login now</a>.</span>";
            } else {
                $message = "<span style='color:red;'>Error creating account.</span>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign Up - Inventory</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body class="login-page">
  <div class="login-container">
    <h2>Create an Account</h2>
    <?= $message ? "<p>$message</p>" : "" ?>
    <form method="post">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm" required>
      </div>
      <button type="submit" class="btn-login" name="signup">Sign Up</button>
    </form>
    <p class="small">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
