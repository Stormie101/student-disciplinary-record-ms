<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - UPTM</title>
  <style>
    body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f0f4f8;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.logo-container {
  position: absolute;
  top: 20px;
  right: 20px;
}

.logo-container img {
  width: 100px;
  height: auto;
}

.reset-container {
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

input[type="email"] {
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
  <div class="logo-container">
    <img src="../relate/uptm logo.png" alt="UPTM Logo">
  </div>

  <div class="reset-container">
    <h2>Reset Password</h2>
    <form action="send_verification.php" method="POST">
      <label for="email">EMAIL</label>
      <input type="email" id="email" name="email" placeholder="Enter registered email" required>

      <button type="submit">SEND VERIFICATION</button>
    </form>
  </div>
</body>
</html>
