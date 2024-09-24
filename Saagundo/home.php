<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['firstName'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit;
    }

    // Get the user's first name from the session
    $firstName = $_SESSION['firstName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 1050px}
    
    /* Set background color and 100% height for side navigation */
    .sidenav {
      background-color: #2c3e50;
      height: 100%;
    }

    /* Set color and style for side navigation links */
    .sidenav a {
      color: #fff;
      font-size: 16px;
      padding: 10px 15px;
      display: block;
      text-decoration: none;
    }

    /* Set color and style for active side navigation link */
    .sidenav a.active {
      background-color: #34495e;
      color: black;
    }

    .sidenav a.hover {
      background-color: #34495e;
      color: black;
    }

    /* Set padding and background color for main content */
    .main-content {
      padding: 20px;
      background-color: #ecf0f1;
    }

    /* Set color and style for headings */
    .heading {
      color: #34495e;
      font-size: 54px;
      margin-bottom: 20px;
    }

    /* Set color and style for paragraphs */
    p {
      color: #34495e;
      font-size: 16px;
      line-height: 1.6;
    }

    /* Card styling */
    .card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .card h3 {
      color: #34495e;
      font-size: 24px;
      margin-bottom: 10px;
    }

    .card p {
      color: #666;
      font-size: 16px;
      line-height: 1.6;
    }

    .nav nav-pills nav-stacked {
      color: black
    }
  </style>
</head>
<body>

<!-- Side Navigation (Visible only on larger screens) -->
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
     <h2 class="heading" style="color: white; text-align: center;">Student</h2>

      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="home.php">Dashboard</a></li>
        <li class="active"><a href="editprofile.php">Edit profile</a></li>
        <li class="active"><a href="homeview.php">View Remaining Session</a></li>
        <li class="active"><a href="sitinhistory.php">Sitin History</a></li>
        <li class="active"><a href="reserve.php">Make Reservation</a></li>
        <li class="active"><a href="logout.php">Logout</a></li>
      </ul>
    </div>

    <!-- Main Content -->
	<div class="col-sm-9 main-content">
      <div class="well">
        <h2 class="heading">Welcome to the Student Dashboard</h2>
        
      </div>
      
    </div>
    <div class="col-sm-9 main-content">
      <div class="card">
        <h3>System Statistics</h3>
        <p>Here you can find important statistics about the system's performance and usage.</p>
        <!-- Add your statistics or information here -->
      </div>
      <div class="card">
        <h3>User Management</h3>
        <p>Manage users, roles, and permissions to control access to the system.</p>
        <!-- Add user management features or information here -->
      </div>
      <div class="card">
        <h3>Settings</h3>
        <p>Configure system settings and preferences to tailor the dashboard to your needs.</p>
        <!-- Add system settings or preferences here -->
      </div>
    </div>
  </div>
</div>

</body>
</html>
