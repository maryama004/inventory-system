<?php
session_start();
// include "config.php";
// Database credentials
	define('host', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'inventory_system');

	// Attempt to connect to MySQL database
	$mysql_db = new mysqli('localhost', 'root', '', 'inventory_system');

	if (!$mysql_db) {
		die("Error: Unable to connect " . $mysql_db->connect_error);
	}
$username = $password = '';
$username_err = $password_err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty(trim($_POST['email']))) {
        $username_err = 'Please enter email.';
    } else {
        $username = trim($_POST['email']);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = 'SELECT id, email, password, role FROM user WHERE email = ?';

        if ($stmt = $mysql_db->prepare($sql)) {
            $stmt->bind_param('s', $username);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $email, $hashed_password, $role);

                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION['role'] = $role;

                            if (strtolower($role) === 'admin') {
                                header('location: admin_db.php');
                                exit();
                            } else {
                                header('location: user_db.php');
                                exit();
                            }
                        } else {
                            $password_err = 'Invalid password.';
                        }
                    }
                } else {
                    $username_err = "Email does not exist.";
                }
            } else {
                die("Query Error: " . $mysql_db->error);
            }

            $stmt->close();
        }

        $mysql_db->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Inventory System — Login</title>
  <link rel="stylesheet" href="style/index.css">
  <style>
    
    :root{
      --bg1:#0f172a; 
      --bg2:#06233a; 
      --card:#0b1220;
      --accent:#00d4ff;
      --accent-2:#7c4dff;
      --glass: rgba(255,255,255,0.06);
      --muted: rgba(255,255,255,0.65);
      --radius:16px;
      --shadow: 0 6px 30px rgba(2,6,23,0.6);
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    
    html,body{height:100%;}
    body{
      margin:0;
      background: radial-gradient(1200px 600px at 10% 10%, rgba(124,77,255,0.12), transparent),
                  radial-gradient(900px 450px at 90% 90%, rgba(0,212,255,0.08), transparent),
                  linear-gradient(120deg,var(--bg1),var(--bg2));
      display:grid;
      place-items:center;
      color: #e6eef8;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      overflow:hidden;
    }

    
    .floaters{position:fixed;inset:0;pointer-events:none;}
    .floater{
      position:absolute;
      filter:blur(12px) saturate(120%);
      opacity:0.9;
      transform-origin:center;
      mix-blend-mode:screen;
      animation: drift 12s linear infinite;
    }
    .floater.f1{width:420px;height:420px;background:linear-gradient(135deg,var(--accent),var(--accent-2));left:-8%;top:6%;border-radius:44% 56% 50% 50%;animation-duration:18s}
    .floater.f2{width:320px;height:320px;background:linear-gradient(135deg,var(--accent-2),var(--accent));right:-6%;bottom:-10%;border-radius:40% 60% 45% 55%;animation-duration:26s}
    .floater.f3{width:220px;height:220px;background:linear-gradient(180deg,rgba(255,255,255,0.06),rgba(255,255,255,0.02));left:30%;bottom:60%;border-radius:50%;animation-duration:20s}

    @keyframes drift{
      0%{transform:translateY(0) rotate(0deg) scale(1)}
      50%{transform:translateY(-24px) rotate(8deg) scale(1.03)}
      100%{transform:translateY(0) rotate(0deg) scale(1)}
    }

    
    .card{
      width:min(880px,92vw);
      max-width:1000px;
      background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
      display:grid;
      grid-template-columns: 420px 1fr;
      backdrop-filter: blur(6px) saturate(120%);
    }

    
    .brand{
      padding:36px 32px;
      background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.008));
      display:flex;
      flex-direction:column;
      gap:18px;
      align-items:flex-start;
      justify-content:center;
    }
    .logo{
      display:flex;gap:14px;align-items:center;
    }
    .logo svg{width:56px;height:56px;flex:0 0 56px}
    .logo h1{margin:0;font-size:20px;letter-spacing:0.6px}
    .logo p{margin:0;font-size:12px;color:var(--muted)}

    .tagline{font-size:14px;color:var(--muted);line-height:1.45}
    .left-illus{margin-top:auto;width:100%;display:flex;justify-content:center}
    .plane-illus{width:240px;height:140px;opacity:0.9;transform:translateY(-6px);animation:plane 6s ease-in-out infinite}
    @keyframes plane{0%{transform:translateY(0) rotate(-4deg)}50%{transform:translateY(-10px) rotate(2deg)}100%{transform:translateY(0) rotate(-4deg)}}

    /* right: form */
    .form-wrap{padding:42px 36px;display:flex;flex-direction:column;gap:18px;}
    .title{font-size:18px;margin:0}
    .subtitle{color:var(--muted);font-size:13px;margin-top:-4px}

    form{margin-top:12px;display:flex;flex-direction:column;gap:12px}
    .input{
      display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:12px;background:var(--glass);border:1px solid rgba(255,255,255,0.04);transition:all .22s ease;
    }
    .input input{background:transparent;border:0;outline:0;color:inherit;font-size:14px;width:100%}
    .input svg{opacity:0.9;flex:0 0 18px}
    .input:focus-within{transform:translateY(-3px);box-shadow:0 8px 30px rgba(12,20,40,0.5), 0 0 0 6px rgba(0,212,255,0.03);border-color:rgba(0,212,255,0.14)}

    
    .field{position:relative}
    .field::after{
      content:'';position:absolute;left:14px;right:14px;bottom:-6px;height:3px;border-radius:6px;background:linear-gradient(90deg,var(--accent),var(--accent-2));transform:scaleX(0);transform-origin:left center;transition:transform .36s cubic-bezier(.2,.9,.2,1);opacity:0.95}
    .field:focus-within::after{transform:scaleX(1)}

    .actions{display:flex;align-items:center;justify-content:space-between;margin-top:6px}
    .checkbox{display:flex;gap:8px;align-items:center;color:var(--muted);font-size:14px}
    .btn{
      padding:12px 18px;border-radius:12px;border:0;background:linear-gradient(90deg,var(--accent),var(--accent-2));color:#021027;font-weight:700;cursor:pointer;box-shadow:0 6px 18px rgba(124,77,255,0.12);transition:transform .12s ease, box-shadow .12s ease;letter-spacing:0.6px
    }
    .btn:active{transform:translateY(1px)}

    .secondary{background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted);padding:10px 14px;border-radius:10px}

    
    .muted{color:var(--muted);font-size:13px}
    .small{font-size:12px}

    
    @media (max-width:780px){
      .card{grid-template-columns:1fr;max-width:92vw}
      .brand{display:none}
    }

    
    .btn::after{
      content:'';position:absolute;pointer-events:none;opacity:0;transition:opacity .2s, transform .3s;
    }

    
    .btn:active{animation: press .8s linear}
    @keyframes press{0%{box-shadow:0 6px 18px rgba(124,77,255,0.12)}50%{box-shadow:0 14px 40px rgba(124,77,255,0.16);transform:translateY(0);}100%{box-shadow:0 6px 18px rgba(124,77,255,0.12)}}

    
    .footer{margin-top:8px;font-size:12px;color:rgba(255,255,255,0.55)}


  </style>
</head>
<body>
  <div class="floaters" aria-hidden="true">
    <div class="floater f1"></div>
    <div class="floater f2"></div>
    <div class="floater f3"></div>
  </div>

  <main class="card" role="main" aria-labelledby="loginTitle">

    <section class="brand" aria-hidden="false">
      <div class="logo">
        
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Inventory logo">
          <rect width="64" height="64" rx="12" fill="url(#g)"/>
          <path d="M8 46s16-10 24-12c8-2 24-4 24-4" stroke="#021027" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.95"/>
          <path d="M10 50c6-2 48-18 48-18" stroke="#021027" stroke-width="1.6" stroke-linecap="round" opacity="0.7"/>
          <defs>
            <linearGradient id="g" x1="0" x2="1" y1="0" y2="1">
              <stop stop-color="#00d4ff"/>
              <stop offset="1" stop-color="#7c4dff"/>
            </linearGradient>
          </defs>
        </svg>
        <div>
          <h1>Inventory System</h1>
          <p>Management Dashboard</p>
        </div>
      </div>

      <div class="tagline">
        Secure access for admins and users. Manage products, track stock, and view reports.
      </div>

      <div class="left-illus">
        <svg class="plane-illus" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
          <g transform="translate(0,10)">
            <path d="M6 70 L84 34 L108 46 L164 22 L198 18 L184 30 L150 44 L96 66 L36 84 Z" fill="rgba(255,255,255,0.06)" />
            <path d="M20 60 L96 30 L116 40 L160 26" stroke="white" stroke-opacity="0.08" stroke-width="2" fill="none" stroke-linecap="round"/>
          </g>
        </svg>
      </div>
    </section>

    <section class="form-wrap">
      <div>
        <h2 id="loginTitle" class="title">Log in to Inventory Dashboard</h2>
        <div class="subtitle">Enter your admin or user credentials to continue.</div>
      </div>

      <form method="post">
        <label class="field">
          <div class="input" aria-hidden="false">
            <svg viewBox="0 0 24 24">
              <path fill="currentColor" d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/>
              <path fill="currentColor" d="M21 21a8 8 0 0 0-14 0"/>
            </svg>
            <input id="email" name="email" type="email" placeholder="Email" required aria-label="Email">
          </div>
        </label>

        <label class="field">
          <div class="input">
            <svg viewBox="0 0 24 24">
              <path fill="currentColor" d="M6 10v6a4 4 0 0 0 4 4h4a4 4 0 0 0 4-4v-6"/>
              <rect x="8" y="6" width="8" height="4" rx="2"/>
            </svg>
            <input id="password" name="password" type="password" placeholder="Password" required aria-label="Password">
          </div>
        </label>

        <div class="actions">
          <label class="checkbox"><input type="checkbox" name="remember"> Remember me</label>
          <a href="#" class="muted small">Forgot password?</a>
        </div>

        <div style="display:flex;gap:12px;align-items:center;">
          <button class="btn" type="submit">Log in</button>
          <a href="signup.php" class="secondary">Sign Up</a>
        </div>

        <div class="footer">By signing in you agree to the Inventory System’s <span style="text-decoration:underline;opacity:0.9">terms & policies</span>.</div>
      </form>
    </section>
  </main>
</body>
</html>