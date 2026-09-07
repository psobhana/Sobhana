<?php
/**
 * Database Configuration File
 * YouTube Talk Manager
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ===== DATABASE SETTINGS ===== */
$host   = "localhost";              // Usually localhost
$dbname = "sobhanan_Talks";     // Example: sobhanan_talksdb
$user   = "sobhanan_Mettavihari";       // Example: sobhanan_user
$pass   = "pass";       // Your DB password

/* ===== CREATE PDO CONNECTION ===== */
try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );

} catch (PDOException $e) {

    // Do NOT show detailed errors in production
    die("Database connection failed.");
}
