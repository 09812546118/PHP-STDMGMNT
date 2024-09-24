<?php
session_start();

include("connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check username and password against database (replace this with your authentication logic)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Assuming successful authentication
    // Fetch user information from the database
    $query = "SELECT idno, firstName, middleName, lastName, email, session FROM users WHERE email = '$email' AND password = '$password'";
    // Execute query and fetch user data
    $userData = mysqli_query($con, $query);
    if ($userData && mysqli_num_rows($userData) == 1) {
        // Set session variables
        $user = mysqli_fetch_assoc($userData);
        $_SESSION['idno'] = $user['idno'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['middleName'] = $user['middleName'];
        $_SESSION['lastName'] = $user['lastName'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['session'] = $user['session'];
    } else {
        // If authentication fails, display an error message or redirect back to login page with an error
        $error = "Invalid email or password";
    }
}

// Get the user's first name from the session
$idno = $_SESSION['idno'];
$firstName = $_SESSION['firstName'];
$middleName = $_SESSION['middleName'];
$lastName = $_SESSION['lastName'];
$email = $_SESSION['email'];
$session = $_SESSION['session'];
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
        <h2>Student Information</h2>
		<hr>
        <!-- Display user information -->
        <div class="user-info">
            <p>ID Number: <?php echo $idno; ?></p>
            <p>First Name: <?php echo $firstName; ?></p>
            <p>Middle Name: <?php echo $middleName; ?></p>
            <p>Last Name: <?php echo $lastName; ?></p>
            <p>Email: <?php echo $email; ?></p>
			<hr>
            <h2>Remaining Sessions: <?php echo $session; ?><h2>
		</div>
    </div>
    </div>
</main>
</body>
</html>
