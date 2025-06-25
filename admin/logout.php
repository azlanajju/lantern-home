<?php
// Remove the JWT cookie
setcookie('admin_jwt', '', time() - 3600, '/', '', false, true);
// Optionally destroy session if used
session_start();
session_unset();
session_destroy();
// Redirect to login
header('Location: ./index.php');
exit;
