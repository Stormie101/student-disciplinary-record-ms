<?php
session_start();
session_regenerate_id(true); // Prevent session fixation
require 'db_connects.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // First check in Users table (Admin & Staff)
  $stmt = $conn->prepare("SELECT userID, passwordHash, userRole FROM Users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['passwordHash'])) {
      $_SESSION['username'] = $username;
      $_SESSION['role'] = $user['userRole'];
      $_SESSION['userID'] = $user['userID'];

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

    $stmt->close();
    $conn->close();
    exit;
  }

  // If not found in Users, check in Students table directly
  $stmt = $conn->prepare("SELECT studentID, username, passwordHash FROM students WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();

    if (password_verify($password, $student['passwordHash'])) {
      $_SESSION['username'] = $student['username'];
      $_SESSION['role'] = 'Student';
      $_SESSION['studentID'] = $student['studentID'];

      header('Location: student/student_dashboard.php');
      exit;
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
