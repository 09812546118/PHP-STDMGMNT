<?php
session_start();

// Include the database connection file
include("connection.php");

// Redirect to the login page if not logged in
if (!isset($_SESSION['firstname'])) {
    header("Location: adminlogin.php");
    exit;
}

// Get the user's first name from the session
$firstname = $_SESSION['firstname'];

// Fetch data from the users_sitin table
$query = "SELECT idno, firstName, middleName, lastName, email, purpose, lab, session, timein FROM users_sitin";
$result = mysqli_query($con, $query);

// Check if query was successful
if (!$result) {
    die('Error fetching data: ' . mysqli_error($con));
}

// Handle sit-out action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sitout'])) {
    $idno = $_POST['idno'];
    $session = $_POST['session'];

    // Decrease session by 1 but not below 0
    $session = max(0, $session - 1);
    
    // Update both users and users_sitin tables
    $updateUserQuery = "UPDATE users SET session = '$session' WHERE idno = '$idno'";
    $updateUserResult = mysqli_query($con, $updateUserQuery);
    $updateUserSitinQuery = "UPDATE users_sitin SET session = '$session' WHERE idno = '$idno'";
    $updateUserSitinResult = mysqli_query($con, $updateUserSitinQuery);

    // Check if update queries were successful
    if (!$updateUserResult || !$updateUserSitinResult) {
        die('Error updating user data: ' . mysqli_error($con));
    }

    // Insert entry into login_history
    $insertHistoryQuery = "INSERT INTO login_history (idno, firstName, lastName, purpose, lab, session, timein) 
                           SELECT idno, firstName, lastName, purpose, lab, session, timein 
                           FROM users_sitin 
                           WHERE idno = '$idno'";
    $insertHistoryResult = mysqli_query($con, $insertHistoryQuery);

    // Check if insertion was successful
    if (!$insertHistoryResult) {
        die('Error inserting into login_history: ' . mysqli_error($con));
    }

    // Delete entry from users_sitin
    $deleteSitinQuery = "DELETE FROM users_sitin WHERE idno = '$idno'";
    $deleteSitinResult = mysqli_query($con, $deleteSitinQuery);

    // Check if deletion was successful
    if (!$deleteSitinResult) {
        die('Error deleting entry from users_sitin: ' . mysqli_error($con));
    }

    // Reload the page
    header("Location: adminview.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative; /* Ensure the body has relative positioning */
        }
        .header {
            background-color: #2c3e50;
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
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo $firstname; ?></h1>
        <a href="adminlogin.php" class="logout-btn">Logout</a>
    </header>
    <div class="container">
        <div class="latest">
            <h2>View Sitin Records</h2>
            <div class="user-table">
                <table>
                    <tr>
                        <th>ID Number</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Purpose</th>
                        <th>Lab</th>
                        <th>Session</th>
                        <th>Sit-in Time</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // Display data in table rows
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row['idno']."</td>";
                        echo "<td>".$row['firstName']."</td>";
                        echo "<td>".$row['middleName']."</td>";
                        echo "<td>".$row['lastName']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['purpose']."</td>";
                        echo "<td>".$row['lab']."</td>";
                        echo "<td>".$row['session']."</td>";
                        echo "<td>".$row['timein']."</td>";
                        echo "<td>
                                <form method='post'>
                                    <input type='hidden' name='idno' value='".$row['idno']."'>
                                    <input type='hidden' name='session' value='".$row['session']."'>
                                    <button type='submit' name='sitout'>Time out</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
