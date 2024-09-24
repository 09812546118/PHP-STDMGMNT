<?php
session_start();
// Include the database connection file
include("connection.php");

// Check if the user's session data exists and is valid
if (!isset($_SESSION['idno'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the user's idno from the session
$idno = $_SESSION['idno'];

// Prepare and execute query to check if the user exists in the users table
$sql = "SELECT * FROM users WHERE idno = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idno);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows are returned
if ($result->num_rows === 0) {
    // Redirect to the login page if user does not exist
    header("Location: login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $message = $_POST['message'];

    // Prepare and execute query to insert data into feedback table
    $sql = "INSERT INTO feedback (idno, title, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iss", $idno, $title, $message);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Alert the user about successful submission
        echo "<script>alert('Submitted successfully!');</script>";
        // Redirect back to the original page after form submission
        echo '<script>window.location.href = "feedback.php";</script>';
        exit(); // Ensure that script execution stops after redirection
    } else {
        // If there's an error, display a generic error message
        echo "<script>alert('An error occurred. Please try again later.');</script>";
    }

    // Close prepared statement
    $stmt->close();
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
.feedback-form {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.feedback-form label {
    font-weight: bold;
}

.feedback-form input[type="text"],
.feedback-form textarea {
    width: 100%;
    padding: 8px;
    margin: 6px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.feedback-form button {
    background-color: #4caf50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.feedback-form button:hover {
    background-color: #45a049;
}

/* Styles for welcome message */
.welcome-user {
    text-align: center;
    margin-top: 20px;
}

.welcome-user h1 {
    font-size: 24px;
}

.welcome-user h2 {
    font-size: 20px;
    color: #333;
}

/* Styles for menu button */
.men {
    text-align: center;
    margin-top: 20px;
}

.men-btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.men-btn:hover {
    background-color: #0056b3;
}

/* Styles for logout button */
.logout-container {
    text-align: center;
    margin-top: 20px;
}

.logout-button {
    background-color: #dc3545;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
  
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
        <li><a href="editprofile.php">Editprofile</a></li>
        <li><a href="homeview.php">ViewRemainingSession</a></li>
        <li><a href="sitinhistory.php">LoginHistory</a></li>
        <li><a href="makereservation.php">MakeReservation</a></li>
	<li><a href="feedback.php">Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>

    <!-- Main Content -->
	<div class="col-sm-9 main-content">
      <div class="well">
        <h2 class="heading">Welcome to the Student Dashboard</h2>
        
      </div>


<main>
    <div class="latest">
        <h2>Feedback</h2>
		<hr>
        <button class="feedback-btn" type="button" onclick="toggleFeedbackForm()">Compose</button>
        <button class="feedback-btn" type="button" onclick="toggleFeedback()">View</button>
		
		<div id="feedback-table" style="display: none;">
            <?php
            // Retrieve and display feedback entries for the logged-in user
            $feedback_sql = "SELECT * FROM feedback WHERE idno = ?";
            $feedback_stmt = $con->prepare($feedback_sql);
            $feedback_stmt->bind_param("i", $idno);
            $feedback_stmt->execute();
            $feedback_result = $feedback_stmt->get_result();

            if ($feedback_result->num_rows > 0) {
                echo "<hr>";
                echo "<br>";
                echo "<div class='feedback-table'>";
                echo "<table>";
                echo "<tr><th>Title</th><th>Message</th></tr>";
                while ($row = $feedback_result->fetch_assoc()) {
                    echo "<tr><td>" . $row["title"] . "</td><td>" . $row["message"] . "</td></tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "<br>";
            } else {
                echo "<p>No feedback entries yet!</p>";
            }

            // Close statement
            $feedback_stmt->close();
            ?>
        </div>
		
		<div class="feedback-form">
		<hr>
		<br>
            <form method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter title" required>
                <br>
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Enter your message" rows="4" required></textarea>
                <br>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
		<br>
    </div>
	
	
        <div class="welcome-user">
            <h1>Welcome student,</h1>
            <h2><?php echo $firstName; ?>!</h2>
        </div>
       
        
        
    </div>
</main>

<script>
    function toggleFeedbackForm() {
        var feedbackForm = document.querySelector('.feedback-form');
        feedbackForm.style.display = feedbackForm.style.display === 'block' ? 'none' : 'block';
    }

    function toggleFeedback() {
        var feedbackTable = document.getElementById("feedback-table");
        if (feedbackTable.style.display === "none") {
            feedbackTable.style.display = "block";
        } else {
            feedbackTable.style.display = "none";
        }
    }
</script>
</body>
</html>