<?php
session_start();
require_once 'connect.php';

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
    $_SESSION['error'] = "❌ Please enter an email.";
    header("Location: index.php");
    exit();
}

// Prepare statement to check if email exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Email exists — redirect to desired page
    $_SESSION['user_email'] = $email;
    header("Location: info/user.php");
    exit();
} else {
    // Email not found — redirect back with error
    $_SESSION['error'] = "❌ Email not found.";
    header("Location: index.php");
    exit();
}

$stmt->close();
$mysqli->close();
?>
