<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify Code – UPTM</title>
  <style>
    body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f0f4f8;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.verify-container {
  background-color: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
  width: 350px;
  text-align: center;
}

h2 {
  margin-bottom: 20px;
  color: #333;
}

label {
  display: block;
  margin-top: 15px;
  font-weight: bold;
  color: #444;
}

input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  width: 100%;
  padding: 10px;
  margin-top: 20px;
  background-color: #0078D7;
  color: white;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
}

button:hover {
  background-color: #005fa3;
}

  </style>
</head>
<body>
  <div class="verify-container">
    <h2>Enter Verification Code</h2>
    <form action="check_code.php" method="POST">
      <label for="code">Verification Code</label>
      <input type="text" id="code" name="code" placeholder="Enter 6-digit code" required>

      <button type="submit">VERIFY</button>
    </form>
  </div>
</body>
</html>
