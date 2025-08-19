<?php 
require_once 'connect.php';

if (!isset($_GET['usn']) || empty($_GET['usn'])) {
    echo "No USN provided.";
    exit;
}

$usn = $mysqli->real_escape_string($_GET['usn']);
$userQuery = "SELECT id, firstname, lastname, mi, usn, Password FROM userdata WHERE usn = '$usn' LIMIT 1";
$userResult = $mysqli->query($userQuery);

if (!$userResult || $userResult->num_rows === 0) {
    echo "User not found.";
    exit;
}

$user = $userResult->fetch_assoc();
$userId = $user['id'];

$error = '';
$showGrades = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputPassword = $_POST['password'] ?? '';
    if (strlen($inputPassword) > 8) {
        $error = 'Password cannot be longer than 8 characters';
    } else if ($inputPassword === $user['Password']) {
        $showGrades = true;
    } else {
        $error = 'Incorrect password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard - <?php echo htmlspecialchars($user['usn']); ?></title>
  <style>
    * {
      box-sizing: border-box;
    }

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
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      height: 60px;
    }

    .frame {
      width: 90%;
      max-width: 1000px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 30px;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      color: #fff;
      position: relative;
      height: 80%;
    }

    .frame2 {
      max-height: 95%;
      overflow-y: auto;
      padding-right: 15px;
      margin-top: 50px;
    }

    h1, h2, h3 {
      color: #fff;
      margin-top: 0;
    }

    .user-info p {
      margin: 8px 0;
      font-size: 1rem;
    }

    form {
      margin-top: 20px;
    }

    input[type="password"] {
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      width: 200px;
      margin-right: 10px;
      margin-bottom: 10px;
    }

    input[type="submit"] {
      padding: 10px 18px;
      font-size: 16px;
      cursor: pointer;
      background-color: #fff;
      color: #333;
      border: none;
      border-radius: 4px;
      transition: background 0.2s;
    }

    input[type="submit"]:hover {
      background-color: #eee;
    }

    .error {
      color: #ffaaaa;
      font-weight: bold;
      margin-top: 10px;
    }

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

    th {
      background-color: rgba(255, 255, 255, 0.2);
    }

    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.1);
    }

    a.back-link {
      display: inline-block;
      margin-top: 20px;
      color: #ffdede;
      text-decoration: underline;
    }

    a.back-link:hover {
      color: #fff;
    }

    @media (max-width: 600px) {
      .frame {
        padding: 20px;
      }

      .user-info p, h1 {
        font-size: 1rem;
      }

      table th, table td {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <video autoplay loop muted class="vid">
    <source src="/web project/forest-in-the-morning-fog.1920x1080.mp4" type="video/mp4" />
  </video>

  <div class="frame">
    <img src="logo.png" alt="Logo" class="logo" />

    <div class="frame2">
      <h1>USN: <?php echo htmlspecialchars($user['usn']); ?></h1>

      <div class="user-info">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['mi']) . '. ' . htmlspecialchars($user['lastname']); ?></p>
      </div>

      <?php if (!$showGrades): ?>
        <form method="POST">
          <label for="password"><b>Enter Password to View Grades</b></label><br />
          <input type="password" id="password" name="password" required maxlength="8" />
          <input type="submit" value="Submit" />
          <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>
        </form>
      <?php else: ?>
        <?php
          $gradesQuery = "SELECT type, score, total FROM grades WHERE user_id = $userId";
          $gradesResult = $mysqli->query($gradesQuery);
          $grades = [];
          if ($gradesResult && $gradesResult->num_rows > 0) {
              while ($gradeRow = $gradesResult->fetch_assoc()) {
                  $grades[$gradeRow['type']][] = $gradeRow;
              }
          }
        ?>

        <div class="grades">
          <h2>Grades</h2>
          <?php if (empty($grades)): ?>
            <p>No grades found for this user.</p>
          <?php else: ?>
            <?php foreach ($grades as $type => $gradeList): ?>
              <div class="grade-type">
                <h3><?php echo ucfirst($type); ?></h3>
                <table>
                  <thead>
                    <tr>
                      <th>Score</th>
                      <th>Total</th>
                      <th>Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($gradeList as $grade): 
                      $percentage = $grade['total'] > 0 ? round(($grade['score'] / $grade['total']) * 100, 2) : 0;
                    ?>
                      <tr>
                        <td><?php echo htmlspecialchars($grade['score']); ?></td>
                        <td><?php echo htmlspecialchars($grade['total']); ?></td>
                        <td><?php echo $percentage; ?>%</td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <a href="user.php" class="back-link">← Go Back</a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const passwordInput = document.getElementById('password');
      if (passwordInput) {
        passwordInput.addEventListener('input', function() {
          if (this.value.length > 8) {
            this.value = this.value.slice(0, 8);
          }
        });
      }
    });
  </script>
</body>
</html>
