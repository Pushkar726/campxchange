<?php
// Copy this file to config.php for a local XAMPP setup.
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'campxchange');
define('BASE_URL', '/campxchange/');
define('APP_NAME', 'campXchange');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

