<?php 
require_once 'connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grades'], $_POST['user_id'], $_POST['usn'])) {
    $userId = intval($_POST['user_id']);
    $usn = $_POST['usn'];

    foreach ($_POST['grades'] as $gradeId => $gradeData) {
        $score = intval($gradeData['score']);
        $total = intval($gradeData['total']);

        $stmt = $mysqli->prepare("UPDATE bscsgrades SET score = ?, total = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param('iiii', $score, $total, $gradeId, $userId);
        $stmt->execute();
    }

    // Redirect back with success
    header("Location: bscsinfo.php?usn=" . urlencode($usn) . "&success=1");
    exit;
}

// --- Display Page ---
if (!isset($_GET['usn']) || empty($_GET['usn'])) {
    echo "No USN provided.";
    exit;
}

$usn = $_GET['usn'];

// Fetch user
$stmt = $mysqli->prepare("SELECT id, firstname, lastname, mi, usn, Password FROM bscsuserdata WHERE usn = ?");
$stmt->bind_param('s', $usn);
$stmt->execute();
$userResult = $stmt->get_result();

if (!$userResult || $userResult->num_rows === 0) {
    echo "User not found.";
    exit;
}

$user = $userResult->fetch_assoc();
$userId = $user['id'];

$types = ['assignment', 'quiz', 'activity', 'exam'];

// Fetch grades
$stmtGrades = $mysqli->prepare("SELECT id, type, score, total FROM bscsgrades WHERE user_id = ?");
$stmtGrades->bind_param('i', $userId);
$stmtGrades->execute();
$gradesResult = $stmtGrades->get_result();

$gradesByType = [];
if ($gradesResult && $gradesResult->num_rows > 0) {
    while ($grade = $gradesResult->fetch_assoc()) {
        $gradesByType[strtolower($grade['type'])][] = $grade;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Dashboard - <?php echo htmlspecialchars($user['usn']); ?></title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: lightpink;
      font-family: Arial, sans-serif;
      overflow: hidden;
      position: relative;
    }
    .vid {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      z-index: -1;
    }
    .frame {
      width: 90%; max-width: 1000px;
      background: rgba(255,255,255,0.1);
      border-radius: 16px;
      padding: 30px;
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      color: #fff;
      height: 80%;
      position: relative;
    }
    .frame2 {
      max-height: 83%;
      overflow-y: auto;
      padding-right: 15px;
      margin-top: 50px;
    }
    h1, h2, h3 { color: #fff; margin-top: 0; }
    .user-info p { margin: 8px 0; font-size: 1rem; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 10px;
      text-align: left;
      color: #fff;
    }
    th { background-color: rgba(255, 255, 255, 0.2); }
    tr:nth-child(even) { background-color: rgba(255, 255, 255, 0.1); }
    a.back-link {
      display: inline-block;
      margin-top: 20px;
      color: #ffdede;
      text-decoration: none;
      margin-bottom: 20px;
    }
    a.back-link:hover { color: #fff; }
    .save-btn {
      padding: 5px 25px;
      background: #02c650;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      margin-left: 750px;
    }
    .save-btn:hover { background: #01974c; }
    .success {
      background: #4caf50;
      color: #fff;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <video autoplay loop muted class="vid">
    <source src="forest.mp4" type="video/mp4" />
  </video>

  <div class="frame">
    <div class="frame2">
      <?php if (isset($_GET['success'])): ?>
        <div class="success">Grades updated!</div>
      <?php endif; ?>

      <h1>USN: <?php echo htmlspecialchars($user['usn']); ?></h1>

      <div class="user-info">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['mi']) . '. ' . htmlspecialchars($user['lastname']); ?></p>
        <p><strong>Code:</strong> <?php echo htmlspecialchars($user['Password']); ?></p>
      </div>

      <h2>Grades by Type</h2>

      <!-- Form starts -->
      <form method="post" id="gradesForm">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <input type="hidden" name="usn" value="<?php echo htmlspecialchars($user['usn']); ?>">

        <?php foreach ($types as $type): ?>
          <h3><?php echo ucfirst($type); ?></h3>
          <?php if (!empty($gradesByType[$type])): ?>
            <table>
              <thead>
                <tr>
                  <th>Score</th>
                  <th>Total</th>
                  <th>Percentage</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($gradesByType[$type] as $grade): 
                  $percentage = ($grade['total'] > 0) ? round(($grade['score'] / $grade['total']) * 100, 2) : 0;
                ?>
                  <tr>
                    <td>
                      <input style="background:none; border: none; color:white;" type="number" name="grades[<?php echo $grade['id']; ?>][score]" 
                             value="<?php echo htmlspecialchars($grade['score']); ?>" min="0">
                    </td>
                    <td>
                      <input style="background:none; border: none; color:white;" type="number" name="grades[<?php echo $grade['id']; ?>][total]" 
                             value="<?php echo htmlspecialchars($grade['total']); ?>" min="1">
                    </td>
                    <td><?php echo $percentage; ?>%</td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p>No <?php echo htmlspecialchars($type); ?> grades.</p>
          <?php endif; ?>
        <?php endforeach; ?>
      </form>
      <!-- Form ends -->

    </div>
    <a href="../dashboard.php" class="back-link">Go Back</a>
    <button type="submit" form="gradesForm" class="save-btn">Save</button>
  </div>
</body>
</html>
