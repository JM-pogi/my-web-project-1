<?php
session_start();
require_once 'connect.php';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');  // Trim input password

if (empty($email)) {
    $_SESSION['error'] = "❌ Please enter an email.";
    header("Location: index.php");
    exit();
}

if (empty($password)) {
    $_SESSION['error'] = "❌ Please enter a password.";
    header("Location: index.php");
    exit();
}

$stmt = $mysqli->prepare("SELECT id, PASSWORD FROM ad WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $db_password);
    $stmt->fetch();

    // Trim DB password just in case
    $db_password = trim($db_password);

    // Debugging — temporarily uncomment these to check values:
    // echo "Input password: '$password'<br>";
    // echo "DB password: '$db_password'<br>";

    if ($password === $db_password) {
        $_SESSION['user_email'] = $email;
        $_SESSION['user_id'] = $user_id;
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "❌ Incorrect password.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "❌ Email not found.";
    header("Location: index.php");
    exit();
}

$stmt->close();
$mysqli->close();
?>


