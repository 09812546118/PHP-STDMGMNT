<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['firstname'])) {
    // Redirect to the login page if not logged in
    header("Location: adminlogin.php");
    exit;
}

// Get the user's first name from the session
$firstname = $_SESSION['firstname'];
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
    /* Styles for feedback section */
    .latest {
        margin-top: 20px;
      }

    .latest h2 {
        font-size: 24px;
        margin-bottom: 10px;
      }

    .latest hr {
        border: 1px solid #ccc;
        margin-bottom: 20px;
      }

    /* Styles for feedback table */
    .feedback-table {
        width: 100%;
        border-collapse: collapse;
      }

    .feedback-table th, .feedback-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .feedback-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .feedback-table td {
        background-color: #fff;
    }

    .feedback-table tr:nth-child(even) td {
        background-color: #f9f9f9;
    }

    .feedback-table tr:hover td {
        background-color: #e0e0e0;
    }

    .latest{
      
    }
  </style>
</head>
<body>

<!-- Side Navigation (Visible only on larger screens) -->
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
     <h2 class="heading" style="color: white; text-align: center;">Admin</h2>
 <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="adminannouncement.php">Post Announcement</a></li>
		<li><a href="adminsearch.php">Admin Search</a></li>
		<li><a href="admindelete.php">Delete</a></li>
        <li><a href="adminview.php">View Sitin Records</a></li>
        <li><a href="adminreports.php">Generate Report</a></li>
        <li><a href="adminfeedback.php">View Feedback</a></li>
		<li><a href="adminreset.php">Reset Password</a></li>
	<li><a href="feedback.php">Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>

    <!-- Main Content -->
	<div class="col-sm-9 main-content">
      <div class="well">
        <h2 class="heading">Welcome to the Admin Dashboard</h2>



<main>
    <div class="latest">
        <h2>Feedback</h2>
		<hr>
		<?php
			// Retrieve feedback from the database
			$sql = "SELECT idno, title, message FROM feedback";
			$result = mysqli_query($con, $sql);

			// Check if there is any feedback
			if (mysqli_num_rows($result) > 0) {
				echo "<div class='feedback-table'>";
				echo "<table>";
				echo "<tr><th>ID</th><th>Title</th><th>Message</th></tr>";
				while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>". $row["idno"]. "</td><td>". $row["title"]. "</td><td>". $row["message"]. "</td></tr>";
			}
			echo "</table>";
			echo "</div>";
			echo "<br>";
			} else {
			echo "<p>No feedback found.</p>";
			}
		?>
	</div>

    
        <div class="welcome-user">
            <h1>Welcome admin,</h1>
			<h2><?php echo $firstname; ?>!</h2>
       
        
      
    </div>
</main>
</body>
</html>