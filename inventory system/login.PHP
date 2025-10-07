<?php
session_start();
include "config.php";

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'Admin') header("Location: admin_db.php");
    else header("Location: user_db.php");
    exit();
}

$error = '';
if (isset($_POST['login'])) {
    $email = ($_POST['email']);
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        $u = mysqli_fetch_assoc($q);
        if (password_verify($password, $u['password'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['role'] = $u['role'];
            $_SESSION['name'] = $u['full_name'];

            if ($u['role'] === 'Admin') header("Location: admin_db.php");
            else header("Location: user_db.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Inventory</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body class="login-page">
  <div class="login-container">
    <h2>Inventory System Login</h2>
    <?php if ($error): ?>
      <div style="color:red;margin-bottom:10px;"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form method="post">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required />
      </div>
      <button type="submit" class="btn-login" name="login">Login</button>
    </form>
    <p class="small">No account yet? <a href="signup.php">Sign up</a></p>
    
  </div>
</body>
</html>
