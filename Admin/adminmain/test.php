<?php
require_once 'connect.php';

if (!isset($_GET['usn'])) {
    echo "No student specified.";
    exit();
}

$usn = $mysqli->real_escape_string($_GET['usn']);
$stmt = $mysqli->prepare("SELECT id, firstname, mi, lastname FROM userdata WHERE usn = ?");
$stmt->bind_param("s", $usn);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "Student not found.";
    exit();
}

$gradesQ = $mysqli->prepare("SELECT type, score, total FROM grades WHERE user_id = ?");
$gradesQ->bind_param("i", $user['id']);
$gradesQ->execute();
$gradesRes = $gradesQ->get_result();
$gradesQ->close();

$grades = ['assignment'=>[], 'quiz'=>[], 'activity'=>[], 'exam'=>[]];
while ($g = $gradesRes->fetch_assoc()) {
    $grades[$g['type']][] = "{$g['score']}/{$g['total']}";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Student Info - <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f2f2f2; color: #333; padding: 20px; }
    .card { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.15); }
    h1 { margin-top: 0; }
    ul { list-style: none; padding: 0; }
    ul li { margin: 6px 0; }
  </style>
</head>
<body>
  <div class="card">
    <h1><?= htmlspecialchars($user['firstname'] . ' ' . $user['mi'] . '. ' . $user['lastname']) ?></h1>
    <p><strong>USN:</strong> <?= htmlspecialchars($usn) ?></p>
    <h3>Grades</h3>
    <ul>
      <li><strong>Assignments:</strong> <?= !empty($grades['assignment']) ? implode(', ', $grades['assignment']) : '—' ?></li>
      <li><strong>Quizzes:</strong> <?= !empty($grades['quiz']) ? implode(', ', $grades['quiz']) : '—' ?></li>
      <li><strong>Activities:</strong> <?= !empty($grades['activity']) ? implode(', ', $grades['activity']) : '—' ?></li>
      <li><strong>Exams:</strong> <?= !empty($grades['exam']) ? implode(', ', $grades['exam']) : '—' ?></li>
    </ul>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>
  </div>
</body>
</html>
