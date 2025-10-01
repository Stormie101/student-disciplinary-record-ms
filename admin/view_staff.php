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
  <h2>Staff & User Directory</h2>

  <table>
    <thead>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <!-- Dummy Data Rows -->
      <tr>
        <td>1</td>
        <td>admin1</td>
        <td>stormieswordk@gmail.com</td>
        <td>Admin</td>
        <td>2025-09-30 09:11:00</td>
      </tr>
      <tr>
        <td>2</td>
        <td>staff1</td>
        <td>alfib@learning@gmail.com</td>
        <td>Staff</td>
        <td>2025-09-30 09:12:00</td>
      </tr>
      <tr>
        <td>3</td>
        <td>student1</td>
        <td>student@gmail.com</td>
        <td>Student</td>
        <td>2025-09-30 09:13:00</td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
