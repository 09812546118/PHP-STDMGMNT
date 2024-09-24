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
	$idno = $_SESSION['idno'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $pcnum = $_POST['pcnum'];
        $purpose = $_POST['purpose'];
        $lab = $_POST['lab'];
        $resdate = $_POST['resdate'];
        $restime = $_POST['restime'];
        $idno = $_POST['idno'];

        // Include database connection
        include_once("connection.php");

        // SQL query to insert reservation data into the reserve table
        $insertQuery = "INSERT INTO reserve (pcnum, purpose, lab, resdate, restime, idno) 
                        VALUES ('$pcnum', '$purpose', '$lab', '$resdate', '$restime', '$idno')";

        // Execute the query
        if (mysqli_query($con, $insertQuery)) {
            echo "<script>alert('Reservation successful!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
		// Redirect back to the search page after resetting
		header("Location: reserve.php");
		exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
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

    .form-container{
      max-width: 1400px; /* Set a max-width for the form container */
      height: 1000px;
      margin-top: 20px; /* Center the form container horizontally */
      margin-left: 30px;
      padding: 120px; /* Adjust padding */
      background-color: #fff; /* Optional: Add background color to the form */
      border-radius: 2px; /* Optional: Add rounded corners to the form */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add shadow to the form */
      font-size: 14px;
      font-weight: bolder;
    }

    .latest {
      align-items: center;
      margin-left: 100px;
    }

    .form-php {
      width: 100%; /* Ensure the form takes full width of its container */
      margin-left: 30px; /* Adjust left margin for positioning */
      padding: 20px; /* Add padding inside the form */
      background-color: #f9f9f9; /* Optional: Background color for better contrast */
      border-radius: 8px; /* Optional: Rounded corners */
    }

        /* Ensure the form takes full width of its container */
      .form-php {
      width: 50%;
      margin: 0 auto; /* Center the form horizontally */
      padding: 20px; /* Add padding inside the form */
      background-color: #f9f9f9; /* Background color for the form */
      border-radius: 8px; /* Rounded corners */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow for form */
      }

      /* Style labels */
      .form-php label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      color: #34495e;
      }

      /* Style input fields */
      .form-php input[type="text"],
      .form-php input[type="date"],
      .form-php input[type="time"],
      .form-php select {
      width: calc(100% - 22px); /* Adjust width to fit padding and borders */
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 15px; /* Space between fields */
      font-size: 14px;
      }

      /* Style the submit button */
      .form-php button[type="submit"] {
      background-color: #3498db; /* Button background color */
      color: #fff; /* Text color */
      border: none; /* Remove border */
      padding: 10px 20px; /* Button padding */
      border-radius: 4px; /* Rounded corners */
      cursor: pointer; /* Pointer cursor on hover */
      font-size: 16px;
      }

      /* Change button color on hover */
      .form-php button[type="submit"]:hover {
      background-color: #2980b9; /* Darker blue for hover effect */
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
<main>
    <div class="latest">
        <h2>Reservation</h2>
        <a href="homerules.php" class="rules"><p>Sit-in rules</p></a>
        <hr>
        <br>
        <div class="form-container">
            <form class="form-php" action="reserve.php" method="post">
                <label for="pcnum">Computer number:</label>
                <input type="text" id="pcnum" name="pcnum" required><br>

                <label for="purpose">Purpose:</label>
                <select id="purpose" name="purpose" required>
                    <option value="Java">Java</option>
                    <option value="C#">C#</option>
                    <option value="Python">Python</option>
                    <option value="C">C</option>
                    <option value="C++">C++</option>
                    <option value="JavaScript">JavaScript</option>
                </select><br>

                <label for="lab">Laboratory number:</label>
                <select id="lab" name="lab" required>
                    <option value="Lab 542">Lab 542</option>
                    <option value="Lab 528">Lab 528</option>
                    <option value="Lab 524">Lab 524</option>
                    <option value="Lab 526">Lab 526</option>
                    <option value="Lab 529">Lab 529</option>
                    <option value="Lab 544">Lab 544</option>
                </select><br>

                <label for="resdate">Reserved date:</label>
                <input type="date" id="resdate" name="resdate" required><br>

                <label for="restime">Reserved time:</label>
                <input type="time" id="restime" name="restime" required><br>

                <label for="idno">ID number:</label>
                <input type="text" id="idno" name="idno" value="<?php echo $idno; ?>" disabled><br>

                <button type="submit">Submit</button>
            </form>
		</div>
    </div>

    
       
        
        <div class="logout-container">
            <a href="login.php">
               
            </a>
        </div>
    </div>
</main>
</body>
</html>
