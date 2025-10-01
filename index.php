<?php
session_start();
require 'db_connects.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT userID, passwordHash, userRole FROM Users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // For now, compare plain password
    if ($user['passwordHash'] === $password) {
      $_SESSION['username'] = $username;
      $_SESSION['role'] = $user['userRole'];

      switch ($user['userRole']) {
        case 'Admin':
          header('Location: admin/admin_dashboard.php');
          exit;
        case 'Staff':
          header('Location: staff/staff_dashboard.php');
          exit;
        case 'Student':
          header('Location: student/student_dashboard.php');
          exit;
      }
    } else {
      echo "<script>alert('Incorrect password');</script>";
    }
  } else {
    header('Location: error.php');
    exit;
  }

  $stmt->close();
  $conn->close();
}
?>
