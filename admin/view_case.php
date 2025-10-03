
<?php

include '../db_connects.php'; // adjust path if needed
$cases = fetchDisciplinaryCases($conn);


function fetchDisciplinaryCases($conn) {
    $cases = [];

    $query = "SELECT caseID, studentID, caseDate, offenseType, status FROM disciplinary_cases ORDER BY caseDate DESC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $cases[] = $row;
    }

    return $cases;
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

    .action-buttons button {
      padding: 6px 12px;
      margin-right: 5px;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }

    .update-btn {
      background-color: #ffc107;
      color: black;
    }

    .view-btn {
      background-color: #0078D7;
      color: white;
    }

    .update-btn:hover {
      background-color: #e0a800;
    }

    .view-btn:hover {
      background-color: #005fa3;
    }

    .generate-btn {
      background-color: #28a745;
      color: white;
    }

    .generate-btn:hover {
      background-color: #1e7e34;
    }

    .nav-title{
      color:black;
    }
    .delete-btn {
  background-color: #dc3545;
  color: white;
}
.delete-btn:hover {
  background-color: #c82333;
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
    <button onclick="location.href='../index.html'">Logout</button>
  </div>
</div>

<div class="main-content">
  <h2>Current Disciplinary Cases</h2>

  <table>
    <thead>
      <tr>
        <th>Case ID</th>
        <th>Student ID</th>
        <th>Offense Type</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($cases as $case): ?>
<tr>
  <td><?php echo htmlspecialchars($case['caseID']); ?></td>
  <td><?php echo htmlspecialchars($case['studentID']); ?></td>
  <td><?php echo htmlspecialchars($case['offenseType']); ?></td>
  <td><?php echo htmlspecialchars($case['caseDate']); ?></td>
  <td><?php echo htmlspecialchars($case['status']); ?></td>
  <td class="action-buttons">
    <button class="update-btn" onclick="location.href='update_case.php?id=<?php echo $case['caseID']; ?>'">Update</button>
    <button class="generate-btn" onclick="location.href='generate_pdf.php?id=<?php echo $case['caseID']; ?>'">Download Report</button>
    <button class="view-btn" onclick="location.href='view_record.php?id=<?php echo $case['caseID']; ?>'">View Record</button>
    <button class="delete-btn" onclick="confirmDelete(<?php echo $case['caseID']; ?>)">Delete</button>
  </td>
</tr>
<?php endforeach; ?>

    </tbody>
  </table>
</div>

</body>
<script>
function confirmDelete(caseID) {
  if (confirm("Are you sure you want to delete Case ID " + caseID + "? This action cannot be undone.")) {
    window.location.href = "delete_case.php?id=" + caseID;
  }
}
</script>

</html>
