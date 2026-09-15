<?php
/**
 * Photo Album - Configuration
 * Compatible with PHP 5.6+
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'sobhanan_album');
define('DB_USER', 'sobhanan_album');
define('DB_PASS', 'pass');
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_TITLE', 'Photo Album');
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', 'image/jpeg,image/png,image/gif');

// Create upload directory if not exists
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

// Database connection
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    $db = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// UTF-8 headers
header('Content-Type: text/html; charset=utf-8');

session_start();
?>
