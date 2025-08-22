<?php
session_start();
require_once "config.php"; // DB connection

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $session_id = session_id();

    // 1. Delete session from active_sessions table
    $stmt = $conn->prepare("DELETE FROM active_sessions WHERE user_id = ? AND session_id = ?");
    $stmt->bind_param("is", $user_id, $session_id);
    $stmt->execute();
    $stmt->close();

    // 2. Delete user credentials from users table
    $stmt2 = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $stmt2->close();
}

// 3. Destroy PHP session
session_unset();
session_destroy();

// 4. Redirect to signup page (since user is deleted, they must register again)
header("Location: home.php");
exit;
?>