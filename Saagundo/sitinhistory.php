<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['idno'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Include the database connection file
include("connection.php");

// Get the user's idno from the session
$idno = $_SESSION['idno'];

// Fetch data from the login_history table for the current user
$query = "SELECT * FROM mydb.login_history WHERE idno = ?";
$statement = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($statement, 'i', $idno);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

// Check if query was successful
if (!$result) {
    die('Error fetching data: ' . mysqli_error($con));
}
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
    .row.content {
      height: 1050px
    }
    
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
    /* Table styling */
    #generateReport {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    #generateReport th, #generateReport td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    #generateReport th {
      background-color: #f2f2f2;
      color: #333;
      font-weight: bold;
    }

    #generateReport tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .well{
      background-color:#fff;
    }

    .latest {
      background-color:#fff;
    }

    .th-id{
      background-color:black;
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
        <li><a href="editprofile.php">Edit profile</a></li>
        <li><a href="homeview.php">View Remaining Session</a></li>
        <li><a href="sitinhistory.php">Sitin History</a></li>
        <li><a href="reserve.php">Make Reservation</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <!-- Main Content -->
	<div class="col-sm-9 main-content">
      <div class="well">
        <h2 class="heading">Welcome to the Student Dashboard</h2>
        <main>
    <div class="latest">
        <h2>Login History</h2>
		<br>
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <table id='generateReport'>
                <tr>
                    <th class="latest">ID Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Purpose</th>
                    <th>Lab</th>
                    <th>Session</th>
                    <th>Time in</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['idno']; ?></td>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['purpose']; ?></td>
                        <td><?php echo $row['lab']; ?></td>
                        <td><?php echo $row['session']; ?></td>
                        <td><?php echo $row['timein']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
			<br>
			<button onclick="downloadReport()" class="download-report">Download login history</button>
        <?php else : ?>
            <p>No login history found for this user.</p>
        <?php endif; ?>
    </div>

    <div class="main-container">
        <div class="main-user">
                   </div>
        
        </main>
      </div>
      
    </div>
    
</body>
</html>

<header class="homelogo">  
</header>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.39/jspdf.plugin.autotable.min.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script> 

<script>
    function downloadReport() {
        if (confirm("Do you want to download Student Login History?")) {
            var table = document.getElementById('generateReport');
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(table);
            XLSX.utils.book_append_sheet(wb, ws, "Student Login History");
            XLSX.writeFile(wb, 'student-login-history.xlsx');
        }
    }
</script>
</body>
</html>
