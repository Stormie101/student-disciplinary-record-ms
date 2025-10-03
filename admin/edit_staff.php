<?php
include '../db_connects.php';

if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);
    $query = "SELECT username, email, userRole FROM users WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['userRole'];

    $updateQuery = "UPDATE users SET username = ?, email = ?, userRole = ? WHERE userID = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "sssi", $username, $email, $role, $userID);
    mysqli_stmt_execute($updateStmt);

    header("Location: view_staff.php?updated=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Staff – UPTM System</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #edcbf6;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      border-bottom: 2px solid black;
    }

    .nav-title {
      font-size: 20px;
      font-weight: bold;
      color: black;
    }

    .nav-buttons button {
      background-color: white;
      color: black;
      border: none;
      padding: 10px 15px;
      margin-left: 10px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .nav-buttons button:hover {
      background-color: #e0e0e0;
    }

    .main-content {
      padding: 40px;
      max-width: 600px;
      margin: auto;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      margin-top: 40px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    form label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    form input, form select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    button[type="submit"] {
      background-color: #0078D7;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #005fa3;
    }
  </style>
</head>
<body>

<div class="navbar">
  <a href="admin_dashboard.php" style="text-decoration: none;"><div class="nav-title">UPTM Discipline Management System</div></a>
  <div class="nav-buttons">
    <button onclick="location.href='view_staff.php'">View Staff</button>
    <button onclick="location.href='report_case.php'">Report New Case</button>
    <button onclick="location.href='view_case.php'">View Case</button>
    <button onclick="location.href='../index.html'">Logout</button>
  </div>
</div>

<div class="main-content">
  <h2>Edit Staff Details</h2>
  <form method="POST">
    <label>Username:
      <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </label>
    <label>Email:
      <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </label>
    <label>Role:
      <select name="userRole" required>
        <option value="Admin" <?php if ($user['userRole'] === 'Admin') echo 'selected'; ?>>Admin</option>
        <option value="Staff" <?php if ($user['userRole'] === 'Staff') echo 'selected'; ?>>Staff</option>
        <option value="Student" <?php if ($user['userRole'] === 'Student') echo 'selected'; ?>>Student</option>
      </select>
    </label>
    <button type="submit">Update</button>
  </form>
</div>

</body>
</html>
