<?php
// 🔐 Basic secure session setup
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
session_start();

// ✅ Check if user is logged in and has correct role
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
  header('Location: ../index.html');
  exit;
}

// ✅ Optional: clear 2FA code after login
unset($_SESSION['2fa_code'], $_SESSION['2fa_expiry']);
require '../db_connects.php';

// Ensure student is logged in
if (!isset($_SESSION['studentID'])) {
  echo "<script>
    alert('Unauthorized access. Please log in as a student.');
    window.location.href = '../index.html';
  </script>";
  exit;
}

$studentID = $_SESSION['studentID'];

// Fetch disciplinary cases for this student
$stmt = $conn->prepare("SELECT caseID, offenseType, caseDate, status, description FROM disciplinary_cases WHERE studentID = ?");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();

$cases = [];
while ($row = $result->fetch_assoc()) {
  $cases[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cases – UPTM System</title>
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
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #0078D7;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .no-case {
      text-align: center;
      font-size: 18px;
      color: #0078D7;
      margin-top: 50px;
    }
  </style>
</head>
<body>

<div class="navbar">
  <a href="student_dashboard.php" style="text-decoration: none;">
    <div class="nav-title">UPTM Discipline Management System</div>
  </a>
  <div class="nav-buttons">
    <button onclick="location.href='logout.php'">Logout</button>
  </div>
</div>

<div class="main-content">
  <h2>My Disciplinary Cases</h2>

  <?php if (count($cases) === 0): ?>
    <div class="no-case">Great work! You don't have any disciplinary cases!</div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Case ID</th>
          <th>Offense Type</th>
          <th>Date</th>
          <th>Status</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cases as $case): ?>
          <tr>
            <td><?= htmlspecialchars($case['caseID']) ?></td>
            <td><?= htmlspecialchars($case['offenseType']) ?></td>
            <td><?= htmlspecialchars($case['caseDate']) ?></td>
            <td><?= htmlspecialchars($case['status']) ?></td>
            <td><?= htmlspecialchars($case['description']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

</body>
</html>
