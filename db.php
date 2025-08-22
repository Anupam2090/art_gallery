<?php
// include config constants
require_once __DIR__ . '/config.php';

// connect to MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// check connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// set charset to avoid encoding issues
$conn->set_charset('utf8mb4');
?>