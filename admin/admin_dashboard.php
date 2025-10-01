<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Page – UPTM System</title>
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
      text-align: center;
    }

    .metrics-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
    }

    .metric-box {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 250px;
    }

    .metric-title {
      font-size: 16px;
      color: #333;
      margin-bottom: 10px;
    }

    .metric-value {
      font-size: 28px;
      font-weight: bold;
      color: #0078D7;
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
    <h2>Welcome to the Admin Dashboard!</h2>

    <div class="metrics-grid">
      <div class="metric-box">
        <div class="metric-title">NUMBER OF STAFF</div>
        <div class="metric-value">42</div>
      </div>

      <div class="metric-box">
        <div class="metric-title">NUMBER OF ADMINISTRATORS</div>
        <div class="metric-value">5</div>
      </div>

      <div class="metric-box">
        <div class="metric-title">NUMBER OF CASES</div>
        <div class="metric-value">63</div>
      </div>

      <div class="metric-box">
        <div class="metric-title">NUMBER OF STUDENTS</div>
        <div class="metric-value">6256</div>
      </div>
    </div>
  </div>

</body>
</html>
