<?php
session_start();
include "config.php";

$message = '';

if (isset($_POST['signup'])) {
    $name = ($_POST['name']);
    $email = ($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $role = "role"; 

    
    if ($password !== $confirm) {
        $message = "<span style='color:red;'>Passwords do not match.</span>";
    } else {
        
        $check = mysqli_query($mysql_db, "SELECT * FROM user WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "<span style='color:red;'>Email already registered.</span>";
        } else {
          
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (full_name, email, password, role) 
                    VALUES ('$name', '$email', '$hash', '$role')";
            if (mysqli_query($mysql_db, $sql)) {
                $message = "<span style='color:green;'>Account created successfully! <a href='login.php'>Login now</a>.</span>";
            } else {
                $message = "<span style='color:red;'>Error creating account.</span>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sign Up - Inventory</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg1: #0f172a;
      --bg2: #06233a;
      --accent: #00d4ff;
      --accent-2: #7c4dff;
      --glass: rgba(255, 255, 255, 0.06);
      --muted: rgba(255, 255, 255, 0.7);
      --radius: 16px;
      font-family: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    html, body {
      height: 100%;
      margin: 0;
      color: #e6eef8;
      background: radial-gradient(1200px 600px at 10% 10%, rgba(124,77,255,0.12), transparent),
                  radial-gradient(900px 450px at 90% 90%, rgba(0,212,255,0.08), transparent),
                  linear-gradient(120deg, var(--bg1), var(--bg2));
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    /* Floating gradient shapes */
    .floaters {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: -1;
    }
    .floater {
      position: absolute;
      filter: blur(12px) saturate(120%);
      opacity: 0.9;
      transform-origin: center;
      mix-blend-mode: screen;
      animation: drift 16s ease-in-out infinite;
    }
    .floater.f1 {
      width: 420px;
      height: 420px;
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      left: -8%; top: 6%;
      border-radius: 44% 56% 50% 50%;
    }
    .floater.f2 {
      width: 320px;
      height: 320px;
      background: linear-gradient(135deg, var(--accent-2), var(--accent));
      right: -6%; bottom: -10%;
      border-radius: 40% 60% 45% 55%;
    }
    .floater.f3 {
      width: 220px;
      height: 220px;
      background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
      left: 30%; bottom: 60%;
      border-radius: 50%;
    }

    @keyframes drift {
      0% { transform: translateY(0) rotate(0deg) scale(1); }
      50% { transform: translateY(-20px) rotate(8deg) scale(1.03); }
      100% { transform: translateY(0) rotate(0deg) scale(1); }
    }

    
    .login-container {
      background: var(--glass);
      backdrop-filter: blur(14px);
      padding: 40px 50px;
      border-radius: var(--radius);
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: 0 8px 28px rgba(0,0,0,0.3);
      max-width: 400px;
      width: 90%;
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-container h2 {
      color: var(--accent);
      margin-bottom: 20px;
      font-weight: 600;
      font-size: 24px;
    }

    .login-container p {
      margin: 0 0 10px;
      font-size: 14px;
      color: #8fa6c0;
    }

    .form-group {
      text-align: left;
      margin-bottom: 16px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      color: var(--muted);
      margin-bottom: 6px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 14px;
      border: 1px solid rgba(255,255,255,0.15);
      background: rgba(255,255,255,0.08);
      color: #fff;
      border-radius: 8px;
      font-size: 14px;
      transition: 0.25s;
    }

    .form-group input:focus {
      border-color: var(--accent);
      background: rgba(255,255,255,0.12);
      outline: none;
    }

    .btn-login {
      width: 100%;
      background: linear-gradient(90deg, var(--accent), var(--accent-2));
      border: none;
      padding: 12px;
      border-radius: 8px;
      color: #021027;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 14px rgba(0,212,255,0.3);
    }

    .small {
      margin-top: 16px;
      font-size: 13px;
      color: var(--muted);
    }

    .small a {
      color: var(--accent);
      text-decoration: none;
    }

    .small a:hover {
      text-decoration: underline;
    }

    @media (max-width: 500px) {
      .login-container {
        padding: 30px 24px;
      }
    }
  </style>
</head>
<body>
  <div class="floaters">
    <div class="floater f1"></div>
    <div class="floater f2"></div>
    <div class="floater f3"></div>
  </div>

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
