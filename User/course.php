<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Subject: Ethics</title>
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

    .frame {
      width: 1000px;
      background-color:  rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      min-height: 400px;

      position: relative;
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

    .subject-title {
      font-size: 2.5rem;
      font-weight: bold;
      color: #fff;
      margin-bottom: 30px;
      letter-spacing: 1px;
    }

    .content-wrapper {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .subject-link {
      text-decoration: none;
    }

    .content-box {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: white;
    }

    .subject-link:hover .content-box {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
    }

    .content-title {
      font-size: 1.6rem;
      margin-bottom: 12px;
      font-weight: bold;
      color: #fff;
    }

  </style>
</head>
<body>

  <video autoplay loop muted class="vid">
    <source src="forest-in-the-morning-fog.1920x1080.mp4"video/mp4 />
  </video>

  <div class="frame">
    <div class="subject-title">Course</div>

    <div class="content-wrapper">
      <a href="info/user.php" class="subject-link">
        <div class="content-box">
          <div class="content-title">BSCS</div>
        </div>
      </a>
      <a href="info/bsais user.php" class="subject-link">
        <div class="content-box">
          <div class="content-title">BSAIS</div>
        </div>
        </div>
      </a>


    </div>

</body>
</html>
