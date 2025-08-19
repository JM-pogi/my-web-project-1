<?php 
require_once 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student List</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
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

    .frame {
      width: 70%;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 30px;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      color: #fff;
      position: relative;
      max-height: 80%
    }

    .frame h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 2rem;
      color: #fff;
    }

    .frame2 {
      max-height: 400px;
      overflow-y: auto;
      padding-right: 10px;
    }

    .student-entry {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      transition: background 0.2s;
    }

    .student-entry:hover {
      background: rgba(255, 255, 255, 0.25);
    }

    .student-entry span {
      color: #f1f1f1;
      font-size: 1rem;
      line-height: 1.5;
    }

    .student-entry a {
      color: #ffdddd;
      text-decoration: underline;
    }

    .menu {
      position: fixed;
      top: 20px;
      right: 30px;
      font-size: 28px;
      color: #fff;
      cursor: pointer;
      z-index: 10;
      user-select: none;
      transition: transform 0.3s ease;
    }

    .menu:hover {
      transform: scale(1.2);
      color: #ddd;
    }

    #menuFrame {
      position: fixed;
      top: 60px;
      right: 30px;
      width: 160px;
      background: rgba(0, 0, 0, 0.6);
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
      display: none;
      z-index: 9;
    }

    .menu-frame-content {
      display: flex;
      flex-direction: column;
    }

    .menu-frame-content a {
      color: #fff;
      padding: 12px 16px;
      text-decoration: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      transition: background 0.2s;
    }

    .menu-frame-content a:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 600px) {
      .frame {
        padding: 20px;
      }

      .student-entry {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>

  <video autoplay loop muted class="vid">
    <source src="/web project/forest-in-the-morning-fog.1920x1080.mp4" type="video/mp4" />
  </video>

  <!-- Menu icon -->
  <div class="menu"><b menuchar>⚙</b></div>

  <!-- Dropdown menu -->
  <div id="menuFrame">
    <div class="menu-frame-content">
      <a href="acc.php">Account</a>
      <a href="../index.php">Logout</a>
    </div>
  </div>

  <div class="frame">
        <h2>Student List</h2>
    <div class="frame2">
      <?php
        $result = $mysqli->query("SELECT firstname, lastname, mi, usn FROM userdata");
        if ($result && $result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                $fname = htmlspecialchars($row['firstname']);
                $lname = htmlspecialchars($row['lastname']);
                $mi = htmlspecialchars($row['mi']);
                $usn = htmlspecialchars($row['usn']);
      ?>
        <div class="student-entry">
          <span>
            <?php echo $counter . ". $fname $mi. $lname"; ?><br>
            USN: <a href="info.php?usn=<?php echo urlencode($usn); ?>"><?php echo $usn; ?></a>
          </span>
        </div>
      <?php
                $counter++;
            }
        } else {
            echo "<p>No users found in the database.</p>";
        }
      ?>
    </div>
  </div>

  <script>
    const menuIcon = document.querySelector('.menu b[menuchar]');
    const menuFrame = document.getElementById('menuFrame');

    menuIcon.addEventListener('click', () => {
      menuFrame.style.display = menuFrame.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!menuFrame.contains(e.target) && !menuIcon.contains(e.target)) {
        menuFrame.style.display = 'none';
      }
    });
  </script>
</body>
</html>
