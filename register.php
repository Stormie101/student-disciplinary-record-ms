<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UPTM Register Page</title>
  <link rel="stylesheet" href="index.css">
  <style>
    .error-box {
      background-color: #f44336;
      color: #fff;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 20px;
      text-align: center;
      font-weight: bold;
    }

    .role-selector {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .role-selector button {
      flex: 1;
      padding: 10px 0;
      border: none;
      font-weight: bold;
      cursor: pointer;
      background-color: #e0e0e0;
      color: #333;
      transition: background-color 0.3s ease;
    }

    .role-selector button.active {
      background-color: #007bff;
      color: white;
    }

    .form-section {
      display: none;
    }

    .form-section.active {
      display: block;
    }
  </style>
  <script>
    function showForm(role) {
      document.getElementById('admin-form').classList.remove('active');
      document.getElementById('student-form').classList.remove('active');
      document.getElementById(role + '-form').classList.add('active');

      document.getElementById('admin-btn').classList.remove('active');
      document.getElementById('student-btn').classList.remove('active');
      document.getElementById(role + '-btn').classList.add('active');
    }

    window.onload = function() {
      showForm('admin'); // default view
    };
  </script>
</head>
<body>

  <div class="logo-container">
    <img src="relate/uptm logo.png" alt="UPTM Logo">
  </div>

  <div class="login-container">
    <h2>Register Page</h2>

    <?php if (!empty($error)): ?>
      <div class="error-box">
        ⚠️ <?= htmlspecialchars($error) ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="role-selector">
      <button type="button" id="admin-btn" onclick="showForm('admin')">Admin</button>
      <button type="button" id="student-btn" onclick="showForm('student')">Student</button>
    </div>

    <!-- Admin Registration Form -->
    <form id="admin-form" class="form-section" action="backN/register_process.php" method="POST">
      <input type="hidden" name="role" value="Admin">

      <label for="username">USERNAME</label>
      <input type="text" id="username" name="username" placeholder="admin123" required>

      <label for="email">EMAIL</label>
      <input type="email" id="email" name="email" placeholder="admin@example.com" required>

      <label for="password">PASSWORD</label>
      <input type="password" id="password" name="password" placeholder="********" required>

      <label for="confirm_password">CONFIRM PASSWORD</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="********" required>

      <button type="submit">REGISTER AS ADMIN</button>
    </form>

    <!-- Student Registration Form -->
    <form id="student-form" class="form-section" action="backN/register_process.php" method="POST">
      <input type="hidden" name="role" value="Student">

      <label for="username">USERNAME</label>
      <input type="text" id="username" name="username" placeholder="Username" required>

      <label for="email">EMAIL</label>
      <input type="email" id="email" name="email" placeholder="student@example.com" required>

      <label for="studentId">STUDENT ID</label>
      <input type="text" id="studentId" name="studentId" placeholder="Insert Student ID" required>

      <label for="password">PASSWORD</label>
      <input type="password" id="password" name="password" placeholder="********" required>

      <label for="confirm_password">CONFIRM PASSWORD</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="********" required>

      <label for="studentName">FULL NAME</label>
      <input type="text" id="studentName" name="studentName" placeholder="Insert Full Name" required>

      <label for="faculty">FACULTY</label>
      <input type="text" id="faculty" name="faculty" placeholder="Insert Faculty" required>

      <label for="course">COURSE</label>
      <input type="text" id="course" name="course" placeholder="Insert Course" required>

      <label for="semester">SEMESTER</label>
      <input type="number" id="semester" name="semester" min="1" max="8" required>

      <button type="submit">REGISTER AS STUDENT</button>
    </form>
  </div>

</body>
</html>
