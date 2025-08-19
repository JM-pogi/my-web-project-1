<?php
session_start();

// Optional: redirect if email is not set
if (!isset($_SESSION['user_email'])) {
  header("Location: index.php");
  exit();
}

$email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Profile</title>
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
      background-color: #ffe4e1;
      overflow: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    .glass-card {
      width: 90%;
      max-width: 500px;
      padding: 40px;
      border-radius: 16px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      text-align: center;
      color: white;
    }

    .glass-card h1 {
      font-size: 28px;
      margin-bottom: 10px;
    }

    .glass-card p {
      font-size: 18px;
      margin: 5px 0 20px 0;
      color: #f0f0f0;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      border-radius: 6px;
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .back-link:hover {
      background-color: rgba(255, 255, 255, 0.4);
    }

    @media (max-width: 600px) {
      .glass-card {
        padding: 25px;
      }

      .glass-card h1 {
        font-size: 22px;
      }

      .glass-card p {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <video autoplay loop muted class="vid">
    <source src="/web project/forest-in-the-morning-fog.1920x1080.mp4" type="video/mp4" />
  </video>

  <div class="glass-card">
    <p><strong><?php echo htmlspecialchars($email); ?></strong></p>
    <a href="user.php" class="back-link">Back to Login</a>
  </div>
</body>
</html>
