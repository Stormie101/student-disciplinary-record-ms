<?php
include '../db_connects.php'; // adjust path if needed

function fetchStaff($conn) {
    $staff = [];
    $query = "SELECT userID, username, email, userRole, createdAt FROM users ORDER BY createdAt DESC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $staff[] = $row;
    }

    return $staff;
}

$staffList = fetchStaff($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Staff – UPTM System</title>
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
    
    .action-buttons button {
  padding: 8px 14px;
  margin-right: 6px;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.update-btn {
  background-color: #ffc107;
  color: black;
}
.update-btn:hover {
  background-color: #e0a800;
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
  <h2>Staff & User Directory</h2>

  <table>
    <thead>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Dummy Data Rows -->
<?php foreach ($staffList as $staff): ?>
<tr>
  <td><?php echo htmlspecialchars($staff['userID']); ?></td>
  <td><?php echo htmlspecialchars($staff['username']); ?></td>
  <td><?php echo htmlspecialchars($staff['email']); ?></td>
  <td><?php echo htmlspecialchars($staff['userRole']); ?></td>
  <td><?php echo htmlspecialchars($staff['createdAt']); ?></td>
<td class="action-buttons">
  <button class="update-btn" onclick="location.href='edit_staff.php?id=<?php echo $staff['userID']; ?>'">Update</button>
  <button class="delete-btn" onclick="confirmDelete(<?php echo $staff['userID']; ?>)">Delete</button>
</td>

</tr>
<?php endforeach; ?>

    </tbody>
  </table>
</div>
<script>
function confirmDelete(userID) {
  if (confirm("Are you sure you want to delete User ID " + userID + "? This action cannot be undone.")) {
    window.location.href = "delete_staff.php?id=" + userID;
  }
}
</script>

</body>
</html>
