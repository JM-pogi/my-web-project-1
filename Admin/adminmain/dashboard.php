<?php
require_once 'connect.php';

// Handle delete request before outputting any HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_usn'])) {
    $delete_usn = $mysqli->real_escape_string($_POST['delete_usn']);
    $delete_query = "DELETE FROM userdata WHERE usn = '$delete_usn' LIMIT 1";

    if ($mysqli->query($delete_query)) {
        // Redirect to avoid resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Label on Blurred Frame</title>
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
      overflow: hidden;
      font-family: Arial, sans-serif;
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
      height: 80px;
      width: auto;
      z-index: 2;
    }

    .frame {
      width: 1005px;
      min-height: 300px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      -webkit-backdrop-filter: blur(10px);
      padding: 30px;
      position: relative;
      display: flex;
      flex-direction: column;
      gap: 20px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
    }

    .header {
      color: white;
      text-align: center;
      margin-bottom: 30px;
    }

    .row {
      display: flex;
      align-items: center;
      gap: 15px;
      color: white;
      margin-left: 10px;
    }

    .input-field {
      padding: 5px;
      border: none;
      border-radius: 4px;
    }

    .inf { width: 150px; }
    .inu { width: 100px; }
    .inm { width: 50px; }
    .inn { width: 200px; }
    .coverage { width: 50px; }

    .side-by-side {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      margin-top: 20px;
    }

    .frame2 {
      height: 190px;
      width: 60%;
      border-radius: 4px;
      background-color: rgba(255, 255, 255, 0.26);
      margin-left: 5px;
      overflow-y: auto;
      padding: 10px;
    }

    .frame3 {
      position: absolute;
      top: 110px;
      right: 30px;
      height: 400px;
      width: 350px;
      border-radius: 4px;
      background-color: rgba(30, 30, 30, 0.26);
      z-index: 1;
      overflow-y: auto;
      padding: 10px;
      display: flex;
      flex-direction: column;
      align-items: stretch;
      box-sizing: border-box;
    }

    .listframe {
      color: white;
      height: 45px;
      width: 100%;
      position: sticky;
      top: 0;
      background-color: rgba(86, 86, 86, 0.73);
      display: flex;
      justify-content: center;
      align-items: center;
      border-bottom-left-radius: 4px;
      border-bottom-right-radius: 4px;
      z-index: 2;
      flex-shrink: 0;
      box-sizing: border-box;
    }

    .listframe h1 {
      margin: 0;
    }

    .tab th, .tab td {
      border-left: 1px solid black;
      border-bottom: none;
      padding: 5px;
      vertical-align: top;
    }

    .gradein {
      width: 50px;
      margin: 2px 4px 6px 0;
    }

    .over {
      color: white;
    }

    .head {
      background: #545454ff;
      color: white;
    }

    .add {
      color: lightgray;
      text-align: center;
      vertical-align: middle;
    }

    button {
      cursor: pointer;
      margin-top: 6px;
      border-radius: 4px;
      border: none;
      background-color: rgba(255, 255, 255, 0.7);
      padding: 5px 10px;
      font-weight: bold;
    }

    button:hover {
      background: #868686ff;
      color: white;
    }

    .inputs-container > div {
      margin-bottom: 6px;
    }

    .addstudent {
      height: 40px;
      width: 100px;
      margin-left: 430px;
      margin-top: 20px;
      border-radius: 4px;
      border: none;
      background-color: rgba(255, 255, 255, 0.7);
    }

    .addstudent:hover {
      background: #868686ff;
      color: white;
    }

    .student-list {
      color: white;
      margin-top: 10px;
      text-align: left;
      width: 100%;
      counter-reset: student-counter;
    }

    /* Updated student entry styling to handle delete button */
    .student-entry {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: rgba(161, 161, 161, 0.45);
      padding: 5px 10px;
      margin-bottom: 5px;
      border-radius: 4px;
      counter-increment: student-counter;
      word-break: break-word;
      color: white;
    }

    .student-entry span {
      flex-grow: 1;
      flex-shrink: 1;
      min-width: 0;
      margin-right: 10px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .student-entry button {
      background: transparent;
      border: none;
      color: red;
      font-size: 20px;
      cursor: pointer;
      flex-shrink: 0;
      font-weight: bold;
      line-height: 1;
      padding: 0 6px;
    }

    .student-entry button:hover {
      color: darkred;
    }

    .user-list {
      color: white;
      margin-top: 10px;
      overflow-y: auto;
      max-height: 350px;
    }
    .menu {
      position: absolute;
      top: 20px;
      right: 30px;
      height: auto;
      width: auto;
      z-index: 2;
      color: white;
      font-size: 30px;
      cursor: pointer;
    }
    .menu:hover {
      color: lightgray;
    }

    /* Menu Frame Styles */
    #menuFrame {
      position: absolute;
      top: 60px;
      right: 30px;
      width: 150px;
      background-color: rgba(64, 64, 64, 0.7);
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.5);
      z-index: 10;
      font-family: Arial, sans-serif;
      user-select: none;
      display: none;
    }

    .menu-frame-content {
      display: flex;
      flex-direction: column;
    }

    .menu-frame-content a {
      padding: 12px 15px;
      color: white;
      text-decoration: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .menu-frame-content a:last-child {
      border-bottom: none;
    }

    .menu-frame-content a:hover {
      background-color: rgba(255, 255, 255, 0.15);
    }
    .pass{
      left: 0px;
      padding: 5px;
      border: none;
      border-radius: 4px;
      position: absolute;
      margin-left: 70px;
      font-size: large;
    }
    .passn{
      position: absolute;
      left: 0px;
      color: white;
      margin-top: 220px;
      margin-left: 35px;
      font-size: 25px;
      }
  </style>
</head>
<body>
  <video autoplay loop muted class="vid">
    <source src="forest.mp4" type="video/mp4" />
  </video>


  <!-- Main Form -->
  <div class="frame">



    <!-- Frame 3: User List -->
  <div class="frame3">
    <div class="listframe"><h1>List</h1></div>
    <div class="user-list">
      <?php
        $result = $mysqli->query("SELECT firstname, lastname, mi, usn FROM userdata");
        if ($result && $result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                $fname = htmlspecialchars($row['firstname']);
                $lname = htmlspecialchars($row['lastname']);
                $mi = htmlspecialchars($row['mi']);
                $usn = htmlspecialchars($row['usn']);
                
                echo '<div class="student-entry">';
                echo '<span>' . $counter . '. ' . htmlspecialchars("$fname $mi. $lname") . '<br>USN: <a href="checkuser/info.php?usn=' . urlencode($usn) . '" style="color: #ffdede;">' . htmlspecialchars($usn) . '</a></span>';
                echo '<form method="POST" action="" style="margin:0;">';
                echo '<input type="hidden" name="delete_usn" value="' . $usn . '">';
                echo '<button type="submit" onclick="return confirm(\'Delete this user?\');" title="Delete user">&times;</button>';
                echo '</form>';
                echo '</div>';

                $counter++;
            }
          }
      ?>
    </div>
  </div>





    <label for="menu" class="menu"><b menuchar>⚙</b></label>
      <!-- Menu frame for Account and Logout -->
  <div id="menuFrame">
    <div class="menu-frame-content">
      <a href="acc.php">Account</a>
      <a href="index.php">Logout</a>
    </div>
  </div>

  
    <form id="studentForm" method="POST" action="submit.php">
      <h1 class="header">Admin Input</h1>
      <img src="logo.png" alt="Logo" class="logo" />
      <div class="row">
        <label>Firstname: <input type="text" class="input-field inf" name="fname" maxlength="12" required /></label>
        <label>Surname: <input type="text" class="input-field inu" name="lname" maxlength="8" required /></label>
        <label>MI: <input type="text" class="input-field inm" name="mi" maxlength="2" required /></label>
      </div>

      <div class="row" style="margin-top: 20px;">
        <label>USN: <input type="number" class="input-field inn" name="usn" required /></label>
      </div>

      <div class="row" style="margin-top: 20px;">
        <label>Assignment % <input type="number" class="input-field coverage" name="coverage[]" required /></label>
        <label>Quiz % <input type="number" class="input-field coverage" name="coverage[]" required /></label>
        <label>Activity % <input type="number" class="input-field coverage" name="coverage[]" required /></label>
        <label>Exam % <input type="number" class="input-field coverage" name="coverage[]" required /></label>
      </div>

      <div class="side-by-side">
        <div class="frame2">
          <table class="tab" cellpadding="10" cellspacing="0">
            <thead>
              <tr>
                <th class="head">Assignment</th>
                <th class="head">Quiz</th>
                <th class="head">Activity</th>
                <th class="head">Exam</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div id="assignmentContainer" class="inputs-container">
                    <div><input type="number" class="gradein" name="grades[assignment][]" /> / <input type="number" class="gradein" name="grades[assignment_total][]" /></div>
                  </div>
                  <button type="button" onclick="addInput(0)">Add New</button>
                </td>
                <td>
                  <div id="quizContainer" class="inputs-container">
                    <div><input type="number" class="gradein" name="grades[quiz][]" /> / <input type="number" class="gradein" name="grades[quiz_total][]" /></div>
                  </div>
                  <button type="button" onclick="addInput(1)">Add New</button>
                </td>
                <td>
                  <div id="activityContainer" class="inputs-container">
                    <div><input type="number" class="gradein" name="grades[activity][]" /> / <input type="number" class="gradein" name="grades[activity_total][]" /></div>
                  </div>
                  <button type="button" onclick="addInput(2)">Add New</button>
                </td>
                <td>
                  <div id="examContainer" class="inputs-container">
                    <div><input type="number" class="gradein" name="grades[exam][]" /> / <input type="number" class="gradein" name="grades[exam_total][]" /></div>
                    <div><input type="number" class="gradein" name="grades[exam][]" /> / <input type="number" class="gradein" name="grades[exam_total][]" /></div>
                    <div><input type="number" class="gradein" name="grades[exam][]" /> / <input type="number" class="gradein" name="grades[exam_total][]" /></div>
                    <div><input type="number" class="gradein" name="grades[exam][]" /> / <input type="number" class="gradein" name="grades[exam_total][]" /></div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      


        <label class="passn">
  Code:
  <input type="text" class="pass" name="PASSWORD" minlength="4" maxlength="8" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$" placeholder="include numbers or letters" required />
</label>
      
      </div>

      <button class="addstudent" type="submit">Add</button>
    </form>
  </div>


  <script>
    function addInput(colIndex) {
      const colContainers = [
        document.getElementById('assignmentContainer'),
        document.getElementById('quizContainer'),
        document.getElementById('activityContainer')
      ];
      const colNames = ['assignment', 'quiz', 'activity'];

      if (colIndex >= 0 && colIndex < colContainers.length) {
        const container = colContainers[colIndex];
        const div = document.createElement('div');

        const input = document.createElement('input');
        input.type = 'number';
        input.className = 'gradein';
        input.name = `grades[${colNames[colIndex]}][]`;

        const total = document.createElement('input');
        total.type = 'number';
        total.className = 'gradein';
        total.name = `grades[${colNames[colIndex]}_total][]`;

        div.appendChild(input);
        div.insertAdjacentText('beforeend', ' / ');
        div.appendChild(total);
        container.appendChild(div);
      }
    }

    // Menu toggle logic
    const menuIcon = document.querySelector('.menu b[menuchar]');
    const menuFrame = document.getElementById('menuFrame');

    menuIcon.addEventListener('click', () => {
      if (menuFrame.style.display === 'none' || menuFrame.style.display === '') {
        menuFrame.style.display = 'block';
      } else {
        menuFrame.style.display = 'none';
      }
    });

    // Close menu if clicked outside
    document.addEventListener('click', (e) => {
      if (!menuFrame.contains(e.target) && !menuIcon.contains(e.target)) {
        menuFrame.style.display = 'none';
      }
    });
  </script>
  <script>
  document.querySelector('input[name="usn"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
  
</script>

</body>
</html>
