<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You - DressUp Studio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff0f6;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }

    .thankyou-box {
      background: #ffffff;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .thankyou-box h1 {
      color: #e91e63;
      font-size: 32px;
      margin-bottom: 15px;
    }

    .thankyou-box p {
      color: #555;
      font-size: 18px;
      margin-bottom: 30px;
    }

    .thankyou-box a {
      display: inline-block;
      padding: 12px 25px;
      background-color: #ff69b4;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .thankyou-box a:hover {
      background-color: #e91e63;
    }
  </style>
</head>
<body>
  <div class="thankyou-box">
    <h1>🎉 Thank You!</h1>
    <p>Your order has been placed successfully.</p>
    <a href="index.php">← Back to Home</a>
  </div>
</body>
</html>
