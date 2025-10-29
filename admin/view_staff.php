<?php

// 🔐 Basic secure session setup
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
session_start();
$isAdmin = ($_SESSION['role'] === 'Admin');
// ✅ Check if user is logged in and has correct role
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
  header('Location: ../index.html');
  exit;
}

// ✅ Optional: clear 2FA code after login
unset($_SESSION['2fa_code'], $_SESSION['2fa_expiry']);

include '../db_connects.php'; // adjust path if needed

function fetchStaff($conn) {
    $staff = [];
    $query = "SELECT userID, username, email, userRole, createdAt, status FROM users ORDER BY createdAt DESC";
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
.status-toggle-btn {
  padding: 8px 14px;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.status-toggle-btn.activate {
  background-color: #28a745;
  color: white;
}
.status-toggle-btn.activate:hover {
  background-color: #218838;
}

.status-toggle-btn.deactivate {
  background-color: #ffc107;
  color: black;
}
.status-toggle-btn.deactivate:hover {
  background-color: #e0a800;
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
    <?php if ($isAdmin): ?>
      <th>Status</th>
    <?php endif; ?>
    <th>Actions</th>
  </tr>
</thead>

<?php foreach ($staffList as $staff): ?>
<tr>
  <td><?php echo htmlspecialchars($staff['userID']); ?></td>
  <td><?php echo htmlspecialchars($staff['username']); ?></td>
  <td><?php echo htmlspecialchars($staff['email']); ?></td>
  <td><?php echo htmlspecialchars($staff['userRole']); ?></td>
  <td><?php echo htmlspecialchars($staff['createdAt']); ?></td>

  <?php if ($isAdmin): ?>
    <td>
      <?php echo htmlspecialchars($staff['status']); ?>
<form method="POST" action="toggle_status.php" style="display:inline;">
  <input type="hidden" name="userID" value="<?php echo $staff['userID']; ?>">
  <input type="hidden" name="currentStatus" value="<?php echo $staff['status']; ?>">
  <button type="submit"
          class="status-toggle-btn <?php echo ($staff['status'] === 'Active') ? 'deactivate' : 'activate'; ?>">
    <?php echo ($staff['status'] === 'Active') ? 'Deactivate' : 'Activate'; ?>
  </button>
</form>

    </td>
  <?php endif; ?>

  <td class="action-buttons">
    <button class="update-btn" onclick="location.href='edit_staff.php?id=<?php echo $staff['userID']; ?>'">Update</button>
    <button class="delete-btn" onclick="confirmDelete(<?php echo $staff['userID']; ?>)">Delete</button>
  </td>
</tr>
<?php endforeach; ?>

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
