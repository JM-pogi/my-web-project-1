<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize & validate
    $firstname = trim($_POST['fname'] ?? '');
    $lastname = trim($_POST['lname'] ?? '');
    $mi = trim($_POST['mi'] ?? '');
    $usn = trim($_POST['usn'] ?? '');
    $password = trim($_POST['PASSWORD'] ?? '');

    if ($firstname === '' || $lastname === '' || $mi === '' || $usn === '' || $password === '') {
        echo "❌ Please fill in all required fields.";
        exit();
    }

    // Insert user info into userdata table WITHOUT hashing password
    $stmt = $mysqli->prepare("INSERT INTO userdata (firstname, lastname, mi, usn, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $mi, $usn, $password);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        echo "❌ Failed to insert user data.";
        exit();
    }

    // Get the inserted user ID for foreign key reference
    $userId = $stmt->insert_id;
    $stmt->close();

    // Insert grades as before...
    $types = ['assignment', 'quiz', 'activity', 'exam'];
    $gradeStmt = $mysqli->prepare("INSERT INTO grades (user_id, type, score, total) VALUES (?, ?, ?, ?)");

    foreach ($types as $type) {
        $scores = $_POST['grades'][$type] ?? [];
        $totals = $_POST['grades']["{$type}_total"] ?? [];

        for ($i = 0; $i < count($scores); $i++) {
            $score = is_numeric($scores[$i]) ? (int)$scores[$i] : 0;
            $total = is_numeric($totals[$i]) ? (int)$totals[$i] : 0;

            $gradeStmt->bind_param("isii", $userId, $type, $score, $total);
            $gradeStmt->execute();
        }
    }

    $gradeStmt->close();
    header("Location: dashboard.php");
    exit();
}
?>
