<?php
    session_start();

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
	.header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .action {
            display: inline-block;
            margin: 10px;
            color: #fff;
            text-decoration: none;
        }
        .action:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }
        /* Position the Log Out button */
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .latest {
            margin: 20px auto;
            text-align: center;
        }
        .latest h2 {
            margin-bottom: 10px;
        }
        .user-table {
            margin-top: 20px;
        }
        .user-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-table th, .user-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .user-table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .user-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .user-table tr:hover {
            background-color: #ddd;
        }
        .sit-in-form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .sit-in-form button:hover {
            background-color: #0056b3;
        }
		/* Styles for form container */
form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

/* Styles for form inputs */
input[type="text"],
textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

/* Styles for form button */
button[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}

/* Placeholder style */
input[type="text"][data-placeholder]:empty::before,
textarea[data-placeholder]:empty::before {
  content: attr(data-placeholder);
  color: #999;
}

/* Hide placeholder when input is focused */
input[type="text"]:focus[data-placeholder]:empty::before,
textarea:focus[data-placeholder]:empty::before {
  content: none;
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
		<li><a href="adminbooking.php">Booking Request</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
	
        
		<form action="createannouncement.php" method="POST">
				<input type="text" name="title" placeholder="Title" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Title" required>
				<textarea name="content" placeholder="Announcement"  onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Announcement"required></textarea>
				<button type="submit">Create Announcement</button>
			</form>
    </div>
</main>
</body>
</html>