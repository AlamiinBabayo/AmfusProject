<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$host = 'localhost';
$dbname = 'amfus_school';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = '';
$debug_info = [];

if (isset($_POST['login'])) {
    $debug_info[] = "Login form submitted";
    $input_username = trim($_POST['username']);
    $input_password = $_POST['password'];
    
    $debug_info[] = "Username: " . $input_username;
    
    if (!empty($input_username) && !empty($input_password)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
            $stmt->execute([$input_username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                $debug_info[] = "User found in database";
                
                if (password_verify($input_password, $user['password'])) {
                    $debug_info[] = "Password verified successfully";
                    
                   
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['login_time'] = time();
                    
                   
                    try {
                        $stmt = $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                        $stmt->execute([$user['id']]);
                    } catch (PDOException $e) {
                        $debug_info[] = "Could not update login info: " . $e->getMessage();
                    }
                    
                   
                    header("Location: admin_dashboard.php", true, 302);
                    exit();
                    
                } else {
                    $debug_info[] = "Password verification failed";
                    $error = 'Invalid username or password';
                }
            } else {
                $debug_info[] = "User not found in database";
                $error = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            $debug_info[] = "Database query error: " . $e->getMessage();
            $error = 'Database error occurred';
        }
    } else {
        $debug_info[] = "Username or password empty";
        $error = 'Please fill in all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Amfus School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root{--primary:#ff4b5c;--secondary:#4169e1;--dark:#1a1a2e;--sidebar-bg:#16213e;--sidebar-hover:#0f3460}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f8f9fc;overflow-x:hidden}
        .login-wrapper{min-height:100vh;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;padding:20px}
        .login-card{background:white;border-radius:20px;box-shadow:0 30px 80px rgba(0,0,0,0.3);overflow:hidden;max-width:900px;width:100%;animation:fadeInUp 0.6s ease}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
        .login-left{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white;padding:60px 40px;display:flex;flex-direction:column;justify-content:center}
        .login-left h1{font-size:32px;font-weight:700;margin-bottom:16px}
        .login-left p{font-size:16px;opacity:0.9;line-height:1.6}
        .login-right{padding:60px 40px}
        .login-right h2{font-size:28px;font-weight:700;color:var(--dark);margin-bottom:10px}
        .login-right .subtitle{color:#6c757d;margin-bottom:40px}
        .form-control:focus{border-color:var(--secondary);box-shadow:0 0 0 0.25rem rgba(65,105,225,0.15)}
        .btn-login{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border:none;padding:14px;font-weight:600;letter-spacing:0.5px;transition:transform 0.3s}
        .btn-login:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(102,126,234,0.4)}
        .alert{padding:12px;border-radius:8px;margin-bottom:20px}
        .alert-danger{background:rgba(244,67,54,0.1);color:#f44336;border:1px solid rgba(244,67,54,0.3)}
        @media(max-width:991px){.login-left{display:none}}
    </style>
</head>
<body>

<div class="login-wrapper">
  <div class="login-card">
    <div class="row g-0">
      <div class="col-lg-5 d-none d-lg-block">
        <div class="login-left">
          <h1>Amfus Comprehensive Model School</h1>
          <p>Welcome to the administrative dashboard. Manage your school's content, view applications, and communicate with parents efficiently.</p>
          <div class="mt-4"><i class="bi bi-shield-check" style="font-size:48px"></i></div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="login-right">
          <h2>Admin Login</h2>
          <p class="subtitle">Enter your credentials to access the dashboard</p>
          
          <?php if ($error): ?>
            <div class="alert alert-danger">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <?php echo htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>
          
          <form method="POST">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
              <label>Username</label>
            </div>
            <div class="form-floating mb-4">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <label>Password</label>
            </div>
            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="rememberMe">
              <label class="form-check-label">Remember me</label>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-login w-100">Sign In</button>
            <div class="text-center mt-3">
              <small class="text-muted">Demo: username: <strong>admin</strong>, password: <strong>admin123</strong></small>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>