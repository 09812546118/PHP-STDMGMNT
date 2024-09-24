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

// Get the user's ID number from the session
$idno = $_SESSION['idno'];

// Query to fetch user data from the database
$query = "SELECT * FROM users WHERE idno = '$idno'";
$result = mysqli_query($con, $query);

// Check if the query was successful and if there's any data returned
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the user's data as an associative array
    $userData = mysqli_fetch_assoc($result);

    // Assign the user's data to variables
    $firstName = $userData['firstName'];
    $middleName = $userData['middleName'];
    $lastName = $userData['lastName'];
    $age = $userData['age'];
    $gender = $userData['gender'];
    $email = $userData['email'];
    $address = $userData['address'];
} else {
    // Handle error if user data retrieval fails
    // For example, redirect to an error page or display a message
    echo "Error: Failed to fetch user data";
    // Redirect back to the search page after resetting
    header("Location: editprofile.php");
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
.edit-profile-form {
    margin-top: 20px;
    padding: 90px;
    border: 1px solid #dddddd;
    border-radius: 6px;
    background-color: #42daf5;
}

.edit-profile-form label {
    margin-right: 5px;
}

.edit-profile-form input[type="text"],
.edit-profile-form input[type="number"],
.edit-profile-form input[type="email"],
.edit-profile-form select {
    margin-bottom: 10px;
    padding: 20px;
    border: 1px solid #dddddd;
    border-radius: 11px;
}

.edit-profile-form button {
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

.edit-profile-form button:hover {
    background-color: #45a049;
}

/* Optional: Add some margin to the form container */
.latest {
    margin-top: 20px;
    background-color:#fff;
}

/* Optional: Style for the heading */
.latest h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

/* Optional: Style for the link */
.latest .rules {
    color: blue;
    text-decoration: none;
}

.latest .rules:hover {
    text-decoration: underline;
}

/* Optional: Style for horizontal line */
.latest hr {
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
        <h2>Edit profile</h2>
		
		
		
        <div class="edit-profile-form">
            <form action="updateprofile.php" method="post">
                <label for="idno">ID Number:</label>
                <input type="text" id="idno" name="idno" value="<?php echo $idno; ?>" disabled><br>
			
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>"><br>

                <label for="middleName">Middle Name:</label>
                <input type="text" id="middleName" name="middleName" value="<?php echo $middleName; ?>"><br>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>"><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $age; ?>"><br>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Female" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                </select><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>"><br>

                <button type="submit">Update profile</button>
            </form>
        </div>
    </div>

    
       
        
      
    </div>
</main>
</body>
</html>
