<?php
// Start the session
session_start();

// Include the database connection file
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['firstname'])) {
    // Redirect to the login page if not logged in
    header("Location: adminlogin.php");
    exit;
}

// Get the user's first name from the session
$firstname = $_SESSION['firstname'];

// Search functionality
if(isset($_GET['search'])) {
    // Retrieve student data based on input idno
    $idno = $_GET['idno'];
    $query = "SELECT * FROM users WHERE idno = '$idno'";
    $result = mysqli_query($con, $query);
    if($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
        $idno = $student['idno'];
        $firstName = $student['firstName'];
        $middleName = $student['middleName'];
        $lastName = $student['lastName'];
        $password = $student['password'];
        $age = $student['age'];
        $gender = $student['gender'];
        $contact = $student['contact'];
        $email = $student['email'];
        $address = $student['address'];
        $purpose = $student['purpose'];
        $lab = $student['lab'];
        $session = $student['session'];
        $timein = $student['timein'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sitin'])) {
    // Retrieve form data
	$idno = $student['idno'];
	$firstName = $student['firstName'];
    $middleName = $student['middleName'];
    $lastName = $student['lastName'];
    $password = $student['password'];
    $age = $student['age'];
    $gender = $student['gender'];
    $contact = $student['contact'];
    $email = $student['email'];
    $address = $student['address'];
    $purpose = $_POST['purpose'];
    $lab = $_POST['lab'];
    $session = $student['session'];
	$timein = $student['timein'];

    // Get the current time
    $currentTime = date("Y-m-d H:i:s");

    // Check if there's an identical entry in users_sitin
    $checkDuplicateQuery = "SELECT * FROM users_sitin WHERE idno = '$idno'";
    $duplicateResult = mysqli_query($con, $checkDuplicateQuery);

    if ($duplicateResult && mysqli_num_rows($duplicateResult) > 0) {
        // If entry exists, update it
        $updateQuery = "UPDATE users_sitin SET timein = '$currentTime', firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', password = '$password', age = '$age', gender = '$gender', contact = '$contact', email = '$email', address = '$address', purpose = '$purpose', lab = '$lab' WHERE idno = '$idno'";
        $updateResult = mysqli_query($con, $updateQuery);
        if (!$updateResult) {
            die('Error updating entry: ' . mysqli_error($con));
        }
    } else {
        // If entry does not exist, insert it
        $insertQuery = "INSERT INTO users_sitin (idno, firstName, middleName, lastName, password, age, gender, contact, email, address, purpose, lab, session, timein) VALUES ('$idno', '$firstName', '$middleName', '$lastName', '$password', '$age', '$gender', '$contact', '$email', '$address', '$purpose', '$lab', '$session', '$currentTime')";
        $insertResult = mysqli_query($con, $insertQuery);
        if (!$insertResult) {
            die('Error inserting entry: ' . mysqli_error($con));
        }
    }

    // Update the current time, purpose, and lab in the "users" table
    $updateUserQuery = "UPDATE users SET timein = '$currentTime', firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', password = '$password', age = '$age', gender = '$gender', contact = '$contact', email = '$email', address = '$address', purpose = '$purpose', lab = '$lab' WHERE idno = '$idno'";
    $updateUserResult = mysqli_query($con, $updateUserQuery);
    if (!$updateUserResult) {
        die('Error updating user data: ' . mysqli_error($con));
    }
    header("Location: adminview.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        /* Center align the content */
    }

    #logo img {
        height: 40px;
        /* Adjust the height as needed */
        width: auto;
        /* Maintain aspect ratio */
        vertical-align: middle;
        /* Align vertically in the navbar */
    }

    .searchform {
        display: inline-block;
        /* Display inline-block to center horizontally */
        margin-bottom: 10px;
    }

    .searchform input[type="text"] {
        padding: 10px;
        width: 200px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .searchform button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .studentForm {
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #ccc;
        text-align: center;
        margin-top: 20px;
    }

    /* Add other styles as needed */

    /* Navbar styles */

    #utility button {
        border: none;
        background: none;
        cursor: pointer;
        color: #fff;
        font-size: 16px;
        padding: 5px;
    }
	#logo img {
        height: 40px;
        /* Adjust the height as needed */
        width: auto;
        /* Maintain aspect ratio */
        vertical-align: middle;
        /* Align vertically in the navbar */
    }
	:root {
    --text-01: #45413E;
    --light-01: #F9F9F9;
    --light-02: #FFFFFF;
    --primary-01: #2A66FF;
    --gray-01: #757575;
    --gray-02: #AFAFAF;
    --gray-03: #E0E0E0;
    --gray-04: #EEEEEE;
    --border-01: #E5E5E5;
    --error: #FF0000;
    --success: #00FF00;
    --warning: #FFA500;
}
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: var(--light-02);
    color: var(--text-01);
}
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
}
header {
    background-color: #2c3e50;
    padding: 20px 0;
    color: var(--light-02);
}
header h1 {
    margin: 0;
}
.main-content {
    margin-top: 20px;
}
.searchbar {
    margin-bottom: 20px;
}
.searchbar input[type="text"] {
    padding: 10px;
    width: 200px;
    border-radius: 5px;
    border: 1px solid var(--gray-03);
}
.searchbar button {
    padding: 10px 20px;
    background-color: var(--primary-01);
    color: var(--light-02);
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.student-info {
    background-color: var(--light-04);
    padding: 20px;
    border-radius: 10px;
    border: 1px solid var(--border-01);
    text-align: left;
}
.sitin-options {
    margin-top: 20px;
}
.sitin-options label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.sitin-options select {
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid var(--gray-03);
    margin-bottom: 10px;
}
.sitin-options textarea {
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid var(--gray-03);
    margin-bottom: 10px;
}
.sitin-options button {
    padding: 10px 20px;
    background-color: var(--primary-01);
    color: var(--light-02);
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
</style>
</head>

<body>
    <header>
        <div class="container">
            <h1>Welcome, <?php echo $firstname; ?></h1>
            <nav id="utility">
                <button onclick="window.location.href='logout.php'">Logout</button>
            </nav>
        </div>
    </header>
    <div class="container main-content">
        <h2>Search Students</h2>
        <form method="get" class="searchbar">
            <input type="text" name="idno" placeholder="Enter ID Number">
            <button type="submit" name="search">Search</button>
        </form>
        <?php if(isset($student)) : ?>
        <div class="student-info">
            <h3>Student Information</h3>
            <p>ID Number: <?php echo $idno; ?></p>
            <p>Name: <?php echo $firstName.' '.$middleName.' '.$lastName; ?></p>
            <p>Age: <?php echo $age; ?></p>
            <p>Gender: <?php echo $gender; ?></p>
            <p>Contact: <?php echo $contact; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Address: <?php echo $address; ?></p>
            <p>Purpose: <?php echo $purpose; ?></p>
            <p>Lab: <?php echo $lab; ?></p>
            <p>Session: <?php echo $session; ?></p>
            <p>Time In: <?php echo $timein; ?></p>
        </div>
        <div class="sitin-options">
                <!-- Sit-in submission form -->
                <form method="post">
                    <label for="purpose">Purpose:</label>
                    <select name="purpose" id="purpose">
                        <option value="Java">Java</option>
                        <option value="C#">C#</option>
                        <option value="Python">Python</option>
                        <option value="C">C</option>
                        <option value="C++">C++</option>
                        <option value="JavaScript">JavaScript</option>
                        <!-- Add more options as needed -->
                    </select>
                    <br>
                    <label for="lab">Lab:</label>
                    <select name="lab" id="lab">
                        <option value="Lab 542">Lab 542</option>
                        <option value="Lab 528">Lab 528</option>
                        <option value="Lab 524">Lab 524</option>
                        <option value="Lab 526">Lab 526</option>
                        <option value="Lab 529">Lab 529</option>
                        <option value="Lab 544">Lab 544</option>
                        <!-- Add more options as needed -->
                    </select>
                    <br>
                    <label for="session">Session:</label>
                    <input type="number" name="session" value=<?php echo $session; ?> disabled>
                    <br>
                    <button type="submit" name="sitin">Sit in</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
