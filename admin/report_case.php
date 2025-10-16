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

include '../db_connects.php'; // adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID     = $_POST['studentID'];
    $offenseType   = $_POST['offenseType'];
    $incidentDate  = $_POST['incidentDate'];
    $incidentTime  = $_POST['incidentTime'];
    $description   = $_POST['description'];
    $createdByID   = 1; // Replace with actual staff ID from session if available

    // Handle file upload
    $evidencePath = null;
    if (!empty($_FILES['evidence']['name'])) {
        $targetDir = "../uploads/";
        $filename = basename($_FILES["evidence"]["name"]);
        $targetFile = $targetDir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES["evidence"]["tmp_name"], $targetFile)) {
            $evidencePath = $targetFile;
        }
    }

    // Insert into disciplinary_cases (only studentID, not studentName/faculty/course)
    $query = "INSERT INTO disciplinary_cases (studentID, offenseType, caseDate, caseTime, description, evidencePath, createdByID, status)
              VALUES (?, ?, ?, ?, ?, ?, ?, 'open')";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $studentID, $offenseType, $incidentDate, $incidentTime, $description, $evidencePath, $createdByID);

    if ($stmt->execute()) {
        echo "<script>alert('Case reported successfully.'); window.location.href='view_case.php';</script>";
    } else {
        echo "<script>alert('Failed to report case.');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report New Case – UPTM System</title>
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

    .form-container {
      background-color: white;
      margin: 40px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 600px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #444;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type="file"] {
      margin-top: 10px;
    }

    button[type="submit"] {
      width: 100%;
      padding: 12px;
      margin-top: 30px;
      background-color: #0078D7;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #005fa3;
    }

    .nav-title{
        color:black;
    }
  </style>
</head>
<body>

<div class="navbar">
  <a href="admin_dashboard.php" style="text-decoration: none;"><div class="nav-title">UPTM Discipline Management System</div></a>
  <div class="nav-buttons">
    <button onclick="location.href='report_case.php'">Report New Case</button>
    <button onclick="location.href='view_case.php'">View Case</button>
    <button onclick="location.href='view_staff.php'">View Staff</button>
    <button onclick="location.href='logout.php'">Logout</button>
  </div>
</div>

<div class="form-container">
  <h2>Report New Case</h2>
  <form method="POST" enctype="multipart/form-data">
    <label for="studentID">Student ID</label>
    <input type="text" id="studentID" name="studentID" placeholder="e.g. AM202010">

  <label for="studentName">Student Name</label>
  <input type="text" id="studentName" name="studentName" readonly>

  <label for="faculty">Faculty</label>
  <input type="text" id="faculty" name="faculty" readonly>

  <label for="course">Course</label>
  <input type="text" id="course" name="course" readonly>


    <label for="offenseType">Type of Offense</label>
    <select id="offenseType" name="offenseType">
      <option value="">Select Offense</option>
      <option value="Inappropriate Attire">Inappropriate Attire</option>
      <option value="Disruptive Behavior">Disruptive Behavior</option>
      <option value="Cheating">Cheating</option>
      <!-- Add more as needed -->
    </select>

    <label for="incidentDate">Date of Incident</label>
    <input type="date" id="incidentDate" name="incidentDate">

    <label for="incidentTime">Time of Incident</label>
    <input type="time" id="incidentTime" name="incidentTime">

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4" placeholder="Describe the incident..."></textarea>

    <label for="evidence">Upload Evidence (Images/PDF)</label>
    <input type="file" id="evidence" name="evidence" accept=".jpg,.jpeg,.png,.pdf">

    <button type="submit">SUBMIT</button>
  </form>
</div>
<script>
// Fetch student details when Student ID field loses focus
document.getElementById('studentID').addEventListener('blur', function() {
  const studentID = this.value.trim();
  if (studentID === '') return;

  fetch(`fetch_student.php?studentID=${encodeURIComponent(studentID)}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById('studentName').value = data.studentName;
        document.getElementById('faculty').value = data.faculty;
        document.getElementById('course').value = data.course;
      } else {
        alert('Student not found.');
        document.getElementById('studentName').value = '';
        document.getElementById('faculty').value = '';
        document.getElementById('course').value = '';
      }
    })
    .catch(error => {
      console.error('Error fetching student:', error);
    });
});
</script>

</body>
</html>
