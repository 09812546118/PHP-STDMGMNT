<?php
session_start();
include("connection.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check if the user exists
    $query = "SELECT * FROM mydb.admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) == 1) {
        // User exists, set session variables and redirect to home page
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $admin['id'];
        $_SESSION['firstname'] = $admin['firstname'];
        header("location: admin.php");
        exit;
    } else {
        // Invalid credentials, display error message
        echo "<script type='text/javascript'> alert('Invalid email or password!'); window.location='adminlogin.php'; </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #86A8E7; /* Changed background color to light gray */
}

.login-container {
    width: 80%;
    max-width: 400px;
    margin: 50px auto;
    background-color: #fff;
    padding: 30px; /* Increased padding for better spacing */
    border-radius: 10px; /* Increased border radius for rounded corners */
    box-shadow: 0 0 20px rgba(0,0,0,0.1); /* Added subtle box shadow */
}

.login-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333; /* Changed text color to dark gray */
}

.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 12px; /* Increased padding for better appearance */
    border: 1px solid #ddd; /* Changed border color to light gray */
    border-radius: 5px; /* Slightly rounded corners */
    box-sizing: border-box;
    font-size: 16px;
    margin-bottom: 15px; /* Added margin bottom for spacing */
}

.login-button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-button:hover {
    background-color: #0056b3;
}

.message {
    color: green;
    text-align: center;
    margin-bottom: 15px;
}

.login-container p {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.login-container p a {
    color: #007bff;
    text-decoration: none;
}

.login-container p a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>

<?php
if(isset($_GET['registration']) && $_GET['registration'] == 'success') {
    echo '<p style="color: green; text-align: center;">Registration successful!</p>';
}
?>

<div class="login-container">
    <h2>Admin Login</h2>
    <form id="loginForm" action="#" method="post">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="login-button">Login</button>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>
</body>
</html>
<div class="toindex">
	<a href="index.php"><p>to index</p></a>
</div>

</body>
</html>
