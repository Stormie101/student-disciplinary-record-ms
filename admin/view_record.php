
<?php
include '../db_connects.php'; // adjust path if needed

if (!isset($_GET['id'])) {
    die("Missing case ID.");
}

$caseID = $_GET['id'];
$query = "
  SELECT dc.*, s.studentName, s.faculty, s.course, s.semester
  FROM disciplinary_cases dc
  LEFT JOIN students s ON dc.studentID = s.studentID
  WHERE dc.caseID = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $caseID);
$stmt->execute();
$result = $stmt->get_result();
$case = $result->fetch_assoc();

if (!$case) {
    die("Case not found.");
}
if (isset($_POST['update'])) {
    $studentID = $_POST['studentID'];
    $caseDate = $_POST['caseDate'];
    $offenseType = $_POST['offenseType'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE disciplinary_cases SET studentID=?, caseDate=?, offenseType=?, description=?, status=? WHERE caseID=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssi", $studentID, $caseDate, $offenseType, $description, $status, $caseID);

    if ($stmt->execute()) {
        echo "<script>alert('Case updated successfully.'); window.location.href='view_case.php';</script>";
    } else {
        echo "<script>alert('Update failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Cases – UPTM System</title>
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

    .main-content {
      padding: 40px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    button {
  display: inline-block;
  padding: 10px 20px;
  margin-top: 20px;
  font-weight: bold;
  font-size: 14px;
  color: white;
  background-color: #0078D7;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #005fa3;
}

    
  </style>
</head>
<body>

<div class="navbar">
  <a href="admin_dashboard.php" style="text-decoration: none; color: black;"><div class="nav-title">UPTM Discipline Management System</div></a>
  <div class="nav-buttons">
    <button onclick="location.href='report_case.php'">Report New Case</button>
    <button onclick="location.href='view_case.php'">View Case</button>
    <button onclick="location.href='view_staff.php'">View Staff</button>
    <button onclick="location.href='../index.html'">Logout</button>
  </div>
</div>

<div class="main-content">
<h2>Full Case Record</h2>
<div style="max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <p><strong>Case ID:</strong> <?php echo htmlspecialchars($case['caseID']); ?></p>
  <p><strong>Student ID:</strong> <?php echo htmlspecialchars($case['studentID']); ?></p>
  <p><strong>Student Name:</strong> <?php echo htmlspecialchars($case['studentName'] ?? 'Unknown'); ?></p>
  <p><strong>Faculty:</strong> <?php echo htmlspecialchars($case['faculty'] ?? 'Unknown'); ?></p>
  <p><strong>Course:</strong> <?php echo htmlspecialchars($case['course'] ?? 'Unknown'); ?></p>
  <p><strong>Semester:</strong> <?php echo htmlspecialchars($case['semester'] ?? 'Unknown'); ?></p>
  <p><strong>Case Date:</strong> <?php echo htmlspecialchars($case['caseDate']); ?></p>
  <p><strong>Offense Type:</strong> <?php echo htmlspecialchars($case['offenseType']); ?></p>
  <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($case['description'])); ?></p>
  <p><strong>Status:</strong> <?php echo htmlspecialchars($case['status']); ?></p>
  <?php if (!empty($case['createdByID'])): ?>
    <p><strong>Created By:</strong> <?php echo htmlspecialchars($case['createdByID']); ?></p>
  <?php endif; ?>
  <?php if (!empty($case['evidencePath'])): ?>
  <button onclick="toggleEvidence()">Show Evidence</button>
  <div id="evidenceBox" style="display:none; margin-top:15px;">
    <p><strong>Evidence:</strong><br>
      <?php
        $ext = pathinfo($case['evidencePath'], PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
            echo '<img src="' . htmlspecialchars($case['evidencePath']) . '" style="max-width:300px; border:1px solid #ccc; border-radius:5px;">';
        } elseif (strtolower($ext) === 'pdf') {
            echo '<a href="' . htmlspecialchars($case['evidencePath']) . '" target="_blank">View PDF Evidence</a>';
        } else {
            echo '<a href="' . htmlspecialchars($case['evidencePath']) . '" target="_blank">Download Evidence</a>';
        }
      ?>
    </p>
  </div>
  
<?php endif; ?>
  <button class="generate-btn" onclick="location.href='generate_pdf.php?id=<?php echo $case['caseID']; ?>'">Download Report</button>
  <button onclick="location.href='view_case.php'">Back to Case List</button>

</div>

</div>
<script>
function toggleEvidence() {
  const box = document.getElementById('evidenceBox');
  box.style.display = box.style.display === 'none' ? 'block' : 'none';
}
</script>

</body>
</html>
