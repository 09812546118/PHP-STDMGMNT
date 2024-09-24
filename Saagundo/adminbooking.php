<?php
    session_start();
	include 'connection.php';

    // Check if the user is logged in
    if (!isset($_SESSION['firstname'])) {
        // Redirect to the login page if not logged in
        header("Location: adminlogin.php");
        exit;
    }

    // Get the user's first name from the session
    $firstname = $_SESSION['firstname'];

    // Check if the Approve button is clicked
    if (isset($_POST['approve'])) {
        $id = $_POST['approve'];
        // Update the status of the entry in the reserve table to 1
        $update_query = "UPDATE reserve SET status = 1 WHERE id = $id";
        mysqli_query($con, $update_query);
    }

    // Check if the Decline button is clicked
    if (isset($_POST['decline'])) {
        $id = $_POST['decline'];
        // Delete the entry from the reserve table
        $delete_query = "DELETE FROM reserve WHERE id = $id";
        mysqli_query($con, $delete_query);
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
		/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}

th, td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

/* Button Styling */
button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 6px 12px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    cursor: pointer;
    margin-right: 4px;
}

button:hover {
    background-color: #45a049;
}

h2 {
    color: green;
    margin: 0;
    padding: 0;
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
    <div class="col-sm-9 main-content">
        <h1>List of booking/reservations</h1>
		<hr>
		<br>
		<div class="view-container">
			<table class="booking-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Computer Number</th>
						<th>Purpose</th>
						<th>Lab</th>
						<th>Reserved Date</th>
						<th>Reserved Time</th>
						<th>ID Number</th>
						<th>Status</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						// SQL query to select all data from the reserve table
						$query = "SELECT * FROM reserve";

						// Execute the query
						$result = mysqli_query($con, $query);

						// Check if there are any rows returned
						if (mysqli_num_rows($result) > 0) {
							// Loop through each row of data
							while ($row = mysqli_fetch_assoc($result)) {
								// Output the data in table rows
								echo "<tr>";
								echo "<td>" . $row['id'] . "</td>";
								echo "<td>" . $row['pcnum'] . "</td>";
								echo "<td>" . $row['purpose'] . "</td>";
								echo "<td>" . $row['lab'] . "</td>";
								echo "<td>" . $row['resdate'] . "</td>";
								echo "<td>" . $row['restime'] . "</td>";
								echo "<td>" . $row['idno'] . "</td>";
								echo "<td>" . $row['status'] . "</td>";
                                echo "<td>";
                                // Check if the status is approved
                                if ($row['status'] == 1) {
                                    echo "<h2 style='color: green;'>Approved</h2>";
                                } else {
                                    echo "<form method='post'>";
                                    // Approve button
                                    echo "<button type='submit' name='approve' value='" . $row['id'] . "'>Approve</button>";
                                    // Decline button
                                    echo "<button type='submit' name='decline' value='" . $row['id'] . "'>Decline</button>";
                                    echo "</form>";
                                }
                                echo "</td>";
								echo "</tr>";
							}
						} else {
							// If no rows returned, display a message
							echo "<tr><td colspan='9'>No booking records found</td></tr>";
						}

						// Close database connection
						mysqli_close($con);
					?>
				</tbody>
			</table>
		</div>
    </div>
	
	
		
		
	</div>
</main>

<script>
    function clearPlaceholder(element) {
        element.placeholder = '';
    }

    function restorePlaceholder(element) {
        element.placeholder = element.dataset.placeholder;
    }
</script>
</body>
</html>
