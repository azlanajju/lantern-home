<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$currentUrl .= "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt_secret = 'YOUR_SUPER_SECRET_JWT_KEY'; // Must match the login secret

// Helper: Cleanly redirect to login


// Check for JWT cookie
if (empty($_COOKIE['admin_jwt'])) {

    // Remove JWT cookie for both / and /admin paths (in case of path mismatch)
    setcookie('admin_jwt', '', time() - 3600, '/', '', false, true);
    setcookie('admin_jwt', '', time() - 3600, '/admin', '', false, true);
    header("Location: ../{$currentPath}/admin/index.php?redirectUrl={$currentUrl}");
    exit;
}

try {
    $user = JWT::decode($_COOKIE['admin_jwt'], new Key($jwt_secret, 'HS256'));
    // Check exp claim (token expiry)
    if (!property_exists($user, 'exp') || $user->exp < time()) {
        throw new Exception('Token expired or missing');
    }
    // Optionally, you can add more checks here (e.g., user id, username, etc.)
} catch (Exception $e) {
    // Remove JWT cookie for both / and /admin paths (in case of path mismatch)
    setcookie('admin_jwt', '', time() - 3600, '/', '', false, true);
    setcookie('admin_jwt', '', time() - 3600, '/admin', '', false, true);
    header("Location: ../{$currentPath}/admin/index.php?redirectUrl={$currentUrl}");
    exit;
}
// $user now contains the decoded JWT payload (id, username, exp)
