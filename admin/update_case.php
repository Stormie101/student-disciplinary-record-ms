
<?php
include '../db_connects.php'; // adjust path if needed

if (!isset($_GET['id'])) {
    die("Missing case ID.");
}

$caseID = $_GET['id'];
$query = "SELECT * FROM disciplinary_cases WHERE caseID = ?";
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

    form { 
        background: white;
        padding: 30px; 
        border-radius: 10px; 
        max-width: 600px; 
        margin: auto; 
        box-shadow: 0 0 10px rgba(0,0,0,0.1); 
    }
    
    label { 
        display: block; 
        margin-top: 15px; 
        font-weight: bold; 
    }
    input, textarea, select { 
        width: 100%; 
        padding: 10px; 
        margin-top: 5px; 
        border-radius: 5px; 
        border: 1px solid #ccc; 
    }
    button { 
        margin-top: 20px; 
        padding: 10px 20px; 
        background-color: #0078D7; 
        color: white; border: none; 
        border-radius: 5px; 
        cursor: pointer; 
    }
    button:hover { 
        background-color: #005fa3; 
    }

  </style>
</head>
<body>

<div class="navbar">
  <a href="staff_dashboard.php" style="text-decoration: none; color: black;"><div class="nav-title">UPTM Discipline Management System</div></a>
  <div class="nav-buttons">
    <button onclick="location.href='report_case.php'">Report New Case</button>
    <button onclick="location.href='view_case.php'">View Case</button>
    <button onclick="location.href='view_staff.php'">View Staff</button>
    <button onclick="location.href='../index.html'">Logout</button>
  </div>
</div>

<div class="main-content">
<h2>Update Disciplinary Case</h2>
<form method="POST">
  <label>Student ID</label>
  <input type="text" name="studentID" style="cursor:pointer;" value="<?php echo htmlspecialchars($case['studentID']); ?>" readonly> 

  <label>Case Date</label>
  <input type="date" name="caseDate" value="<?php echo htmlspecialchars($case['caseDate']); ?>" required>

  <label>Offense Type</label>
  <input type="text" name="offenseType" value="<?php echo htmlspecialchars($case['offenseType']); ?>" required>

  <label>Description</label>
  <textarea name="description"><?php echo htmlspecialchars($case['description']); ?></textarea>

  <label>Status</label>
  <select name="status">
    <option value="open" <?php if ($case['status'] == 'open') echo 'selected'; ?>>open</option>
    <option value="closed" <?php if ($case['status'] == 'closed') echo 'selected'; ?>>closed</option>
  </select>

  <button type="submit" name="update">Update Case</button>
</form>
</div>

</body>
</html>
