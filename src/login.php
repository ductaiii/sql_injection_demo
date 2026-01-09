<?php
session_start();
require 'db.php';

$message = "";
$debug_sql = "";

// Use GET for demo per request: only process when username is present in query
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
    $username = $_GET['username'] ?? '';
    $password = $_GET['password'] ?? '';

    // Nỗi chuỗi trực tiếP -> SQl Injection
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    $debug_sql = $sql;


    // Dùng Prepared Statement
    // $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("ss", $username, $password);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $debug_sql = $sql;


    try {


        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Store user info in session so home.php can read role and user data
            $_SESSION['user'] = $user;
            $message = "<div class='alert success'>&#10004; Đăng nhập thành công! Chào <strong>" . htmlspecialchars($user['fullname']) . "</strong></div>";
            $message .= "<script>window.open('home.php', '_blank');</script>";
        } else {
            $message = "<div class='alert error'>❌ Sai tài khoản hoặc mật khẩu!</div>";
        }
    } catch (Exception $e) {
        $message = "<div class='alert error'>⚠️ Lỗi Database: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Đăng nhập Demo</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; display: flex; justify-content: center; padding-top: 50px; }
        .login-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; border: none; color: white; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #218838; }
        .alert { padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .debug-box { background: #272822; color: #f8f8f2; padding: 15px; border-radius: 4px; font-family: monospace; font-size: 12px; margin-top: 20px; overflow-x: auto; }
        .debug-title { font-weight: bold; color: #ae81ff; margin-bottom: 5px; display: block; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login System</h2>

    <?php echo $message; ?>

    <form method="GET">
        <div class="form-group">
            <label>Tên đăng nhập:</label>
            <input type="text" name="username" placeholder="Nhập username..." required>
        </div>
        <div class="form-group">
            <label>Mật khẩu:</label>
            <input type="password" name="password" placeholder="Nhập password..." required>
        </div>
        <button type="submit">Đăng nhập</button>

    </form>

    <?php if ($debug_sql): ?>
        <div class="debug-box">
            <span class="debug-title">Raw SQL Query (Debug):</span>
            <?php echo htmlspecialchars($debug_sql); ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>