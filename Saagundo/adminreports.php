<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['firstname'])) {
        // Redirect to the login page if not logged in
        header("Location: adminlogin.php");
        exit;
    }

    // Include the database connection file
    include("connection.php");

    // Get the user's first name from the session
    $firstname = $_SESSION['firstname'];

    // Initialize variables to store form input values
    $selectedPurpose = isset($_POST['purpose']) ? $_POST['purpose'] : "";
    $selectedLab = isset($_POST['lab']) ? $_POST['lab'] : "";
    $studentID = isset($_POST['student']) ? $_POST['student'] : "";
    $result = null; // Initialize result variable

    // Check if the Generate Report button is clicked and form data is submitted via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
        // Retrieve form input values
        $selectedPurpose = $_POST['purpose'];
        $selectedLab = $_POST['lab'];
        $studentID = $_POST['student'];

        // Query to select data from login_history based on the selected criteria
        $query = "SELECT * FROM login_history WHERE purpose = '$selectedPurpose' OR lab = '$selectedLab' OR idno = '$studentID'";
        
        // Add sorting by date if selected
        if (!empty($selectedDate)) {
            // Use timein directly for sorting by DATETIME
            $query .= " ORDER BY timein";
        }
        
        $result = mysqli_query($con, $query);
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
		/* Form Styling */
.generate-report-form {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #dddddd;
    border-radius: 5px;
}

.generate-report-form label {
    margin-right: 10px;
}

.generate-report-form select,
.generate-report-form input[type="text"] {
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #dddddd;
    border-radius: 5px;
}

.generate-report-form button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
}

.generate-report-form button:hover {
    background-color: #45a049;
}

/* Optional: Add some margin to the form container */
.latest {
    margin-top: 20px;
}

/* Optional: Style for horizontal line */
.latest hr {
    border: 0;
    height: 1px;
    background: #dddddd;
    margin-top: 20px;
    margin-bottom: 20px;
}
/* Table Styling */
.report-table {
    margin-top: 20px;
}

.report-table table {
    width: 100%;
    border-collapse: collapse;
}

.report-table th, .report-table td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

.report-table th {
    background-color: #f2f2f2;
}

/* Optional: Style for the 'No data' message */
.report-table h2 {
    color: red;
    margin-top: 20px;
}

/* Optional: Style for horizontal line */
.report-table hr {
    border: 0;
    height: 1px;
    background: #dddddd;
    margin-top: 20px;
    margin-bottom: 20px;
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

	

</head>
<body>

<header class="homelogo">
    <h2>Generate Reports</h2>
</header>

<main>
    	<div class="col-sm-9 main-content">
        <hr>
        <!-- Form to generate reports -->
        <form method="post" class="generate-report-form">
            <label for="purpose">Purpose:</label>
            <select name="purpose" id="purpose">
                <option value="" <?php if ($selectedPurpose === "") echo "selected"; ?>>Select Purpose</option>
                <option value="Java" <?php if ($selectedPurpose === "Java") echo "selected"; ?>>Java</option>
                <option value="C#" <?php if ($selectedPurpose === "C#") echo "selected"; ?>>C#</option>
                <option value="Ruby" <?php if ($selectedPurpose === "Ruby") echo "selected"; ?>>Ruby</option>
                <option value="JavaScript" <?php if ($selectedPurpose === "JavaScript") echo "selected"; ?>>JavaScript</option>
                <option value="Database" <?php if ($selectedPurpose === "C++") echo "selected"; ?>>Database</option>
                <option value="Python" <?php if ($selectedPurpose === "Python") echo "selected"; ?>>Python</option>
            </select>
            <label for="lab">Laboratory:</label>
            <select name="lab" id="lab">
                <option value="" <?php if (	$selectedLab === "") echo "selected"; ?>>Select Laboratory</option>
                <option value="Lab 542" <?php if ($selectedLab === "Lab 542") echo "selected"; ?>>Lab 542</option>
                <option value="Lab 528" <?php if ($selectedLab === "Lab 528") echo "selected"; ?>>Lab 528</option>
                <option value="Lab 528" <?php if ($selectedLab === "Lab 524") echo "selected"; ?>>Lab 524</option>
                <option value="Lab 528" <?php if ($selectedLab === "Lab 526") echo "selected"; ?>>Lab 526</option>
                <option value="Lab 528" <?php if ($selectedLab === "Lab 529") echo "selected"; ?>>Lab 529</option>
                <option value="Lab 528" <?php if ($selectedLab === "Lab 544") echo "selected"; ?>>Lab 544</option>
            </select>
            <label for="student">Student ID:</label>
			<input type="text" name="student" id="student" value="<?php echo $studentID; ?>" placeholder="Enter Student ID">
            <br>
            <button type="submit" name="generate_report">Generate Report</button>
        </form>
		
		<?php 
		if ($result && mysqli_num_rows($result) > 0) {
			// Output the start of the report table
			echo "<br>";
			echo "<hr>";
			echo "<br>";
			echo "<div class='report-table'>";
			echo "<table>";
			echo "<tr>";
			echo "<th>ID Number</th>";
			echo "<th>First Name</th>";
			echo "<th>Last Name</th>";
			echo "<th>Purpose</th>";
			echo "<th>Lab</th>";
			// Add more columns as needed
			echo "</tr>";

			// Loop through each row of the result and output table rows
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $row['idno'] . "</td>";
				echo "<td>" . $row['firstName'] . "</td>";
				echo "<td>" . $row['lastName'] . "</td>";
				echo "<td>" . $row['purpose'] . "</td>";
				echo "<td>" . $row['lab'] . "</td>";
				// Add more columns as needed
				echo "</tr>";
			}

			// Output the end of the report table
			echo "</table>";
			echo "</div>";
		}
		else{
			echo "<br>";
			echo "<hr>";
			echo "<h2>No data</h2>";
		}
		?>
    </div>
	<a href="admin.php" class="button">Return</a>
</main>

</body>
</html>