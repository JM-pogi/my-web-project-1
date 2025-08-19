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
      height: 250px;
      width: 400px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .label-icon {
      font-size: 75px;
      background: rgba(0, 0, 0, 0.3);
      color: white;
      border-radius: 6px;
      cursor: pointer;
      padding: 10px;
      text-decoration: none;
      display: inline-block;
    }

    .label-icon:hover {
      background: rgba(0, 0, 0, 0.5);
    }

    .log {
      color: white;
      font-size: 24px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    .icon-container {
      display: flex;
      justify-content: space-between;
      width: 100%;
      padding: 0 60px;
    }

    .user, .admin {
      display: flex;
      flex-direction: column;
      align-items: center;
      color: white;
      font-weight: bold;
      font-size: 14px;
    }

    .user {
      margin-left: 50px;
    }

    .admin {
      margin-right: 50px;
    }

    .tag {
      margin-top: 8px;
      height: auto;
    }
  </style>
</head>
<body>

  <video autoplay loop muted class="vid">
    <source src="/web project/forest-in-the-morning-fog.1920x1080.mp4" type="video/mp4" />
  </video>

  <div class="frame">
    <h1 class="log">Choose login</h1>
    <div class="icon-container">
      <div class="user">
        <a href="User/index.php" class="label-icon">👤</a>
        <p class="tag">Student</p>
      </div>
      <div class="admin">
        <a href="Admin/adminmain/index.php" class="label-icon">⚙️</a>
        <p class="tag">Administrator</p>
      </div>
    </div>
  </div>

</body>
</html>

