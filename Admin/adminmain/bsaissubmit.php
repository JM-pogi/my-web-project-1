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

    // Insert into userdata table
    $stmt = $mysqli->prepare("INSERT INTO bsaisuserdata (firstname, lastname, mi, usn, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $mi, $usn, $password);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        echo "❌ Failed to insert user data.";
        exit();
    }

    $userId = $stmt->insert_id;
    $stmt->close();

    // ✅ Insert coverage (grade_weights)
    $coverage = $_POST['coverage'] ?? [25, 25, 25, 25];
    if (count($coverage) !== 4 || array_sum($coverage) !== 100) {
        echo "❌ Coverage must have 4 parts and total 100%.";
        exit();
    }

    $stmt = $mysqli->prepare("
        INSERT INTO grade_weights (user_id, assignment_weight, quiz_weight, activity_weight, exam_weight)
        VALUES (?, ?, ?, ?, ?)
    ");
    // ✅ Insert grades
    $types = ['assignment', 'quiz', 'activity', 'exam'];
    $gradeStmt = $mysqli->prepare("INSERT INTO bsaisgrades (user_id, type, score, total) VALUES (?, ?, ?, ?)");

    foreach ($types as $type) {
        $scores = $_POST['grades'][$type] ?? [];
        $totals = $_POST['grades']["{$type}_total"] ?? [];

        for ($i = 0; $i < count($scores); $i++) {
            $score = is_numeric($scores[$i]) ? (float)$scores[$i] : 0;
            $total = is_numeric($totals[$i]) ? (float)$totals[$i] : 0;

            if ($total > 0) {
                $gradeStmt->bind_param("isdd", $userId, $type, $score, $total);
                $gradeStmt->execute();
            }
        }
    }

    $gradeStmt->close();

    // Redirect
    header("Location: dashboard bsais.php");
    exit();
}
?>
