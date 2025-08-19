<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Label on Blurred Frame</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: lightpink;
      overflow: hidden;
      position: relative;
      font-family: Arial, sans-serif;
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
      position: relative;
      width: 400px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px;
    }

    .log {
      color: white;
      text-align: center;
      opacity: 0.9;
      margin-bottom: 25px;
    }

    .email,
    .password {
      height: 35px;
      border-radius: 4px;
      width: 100%;
      margin-bottom: 20px;
      padding: 5px 10px;
      border: none;
      opacity: 0.9;
      margin-right: -50px;
    }

    .email::placeholder,
    .password::placeholder {
      color: #555;
    }

    .forgot-password {
      color: white;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .forgot-password a {
      color: #ffdede;
      text-decoration: underline;
    }

    .sub {
      width: 100%;
      height: 40px;
      background-color: white;
      border: 1.5px solid;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      margin-left: 8px;
    }
    .sub:hover{
      background-color: #9a9a9aff;
        }
  </style>
</head>
<body>
  <video autoplay loop muted class="vid">
    <source src="/web project/forest-in-the-morning-fog.1920x1080.mp4" type="video/mp4" />
  </video>

  <div class="frame">
    <form action="check.php" method="POST">
      <h1 class="log">Admin Login</h1>
      <input type="email" name="email" class="email" placeholder="Email" required>
      <input type="password" name="password" class="password" placeholder="Password" required>
      <p class="forgot-password">Forgot Password? <a href="code.php">Get Code</a></p>
      <input type="submit" class="sub" value="Login">
    </form>
  </div>

</body>
</html>
