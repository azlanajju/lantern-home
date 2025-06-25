<?php
session_start();
require_once '../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt_secret = 'YOUR_SUPER_SECRET_JWT_KEY'; // Change this to a secure value
$redirectUrl = isset($_GET['redirectUrl']) ? $_GET['redirectUrl'] : '';

// If already logged in, redirect
if (!empty($_COOKIE['admin_jwt'])) {
    try {
        $user = JWT::decode($_COOKIE['admin_jwt'], new Key($jwt_secret, 'HS256'));
        if (property_exists($user, 'exp') && $user->exp > time()) {
            if (!empty($redirectUrl)) {
                header("Location: $redirectUrl");
            } else {
                header('Location: ./dashboard/');
            }
            exit;
        }
    } catch (Exception $e) {
        // Invalid token, show login
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    $stmt = $pdo->prepare('SELECT * FROM admin WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $payload = [
            'id' => $admin['id'],
            'username' => $admin['username'],
            'exp' => time() + ($remember ? 60 * 60 * 24 * 30 : 60 * 60 * 24) // 30 days or 1 day
        ];
        $jwt = JWT::encode($payload, $jwt_secret, 'HS256');
        setcookie('admin_jwt', $jwt, $payload['exp'], '/', '', false, true);
        if (!empty($redirectUrl)) {
            header("Location: $redirectUrl");
        } else {
            header('Location: ./dashboard/');
        }
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            background: #181818;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: #222;
            padding: 32px 24px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            width: 320px;
        }

        .login-box h2 {
            margin-bottom: 24px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 4px;
            border: none;
            font-size: 1rem;
        }

        .login-box label {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .login-box input[type="checkbox"] {
            margin-right: 8px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: none;
            background: #ffb347;
            color: #222;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
        }

        .error {
            color: #ff6b6b;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Admin Login </h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <label><input type="checkbox" name="remember"> Remember me for 30 days</label>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>