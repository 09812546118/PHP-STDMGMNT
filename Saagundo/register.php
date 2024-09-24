<?php	
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$idno = $_POST['idno'];
		$firstName = $_POST['firstName'];
		$middleName = $_POST['middleName'];
		$lastName = $_POST['lastName'];
		$password = $_POST['password'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$contact = $_POST['contact'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		
		if(!empty($email) && !empty($password) && !is_numeric($email)) {
			$query = "INSERT INTO users (idno, firstName, middleName, lastName, password, age, gender, contact, email, address) VALUES ('$idno','$firstName','$middleName','$lastName','$password','$age','$gender','$contact','$email','$address')";
			
			// Insert data into users table
			if(mysqli_query($con, $query)) {
				// Insert data into users_sitin table
				$insertSitInQuery = "INSERT INTO users_sitin (idno, firstName, middleName, lastName, password, age, gender, contact, email, address) VALUES ('$idno','$firstName','$middleName','$lastName','$password','$age','$gender','$contact','$email','$address')";
				if(mysqli_query($con, $insertSitInQuery)) {
					echo "<script type='text/javascript'> alert('Registration successful!'); window.location='login.php'; </script>";
					exit;
				} else {
					echo "<script type='text/javascript'> alert('Error in registration!'); window.location='register.php'; </script>";
					exit;
				}
			} else {
				echo "<script type='text/javascript'> alert('Error in registration!'); window.location='register.php'; </script>";
				exit;
			}
		} else {
			echo "<script type='text/javascript'> alert('Invalid information!'); window.location='register.php'; </script>";
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="registerstyle.css">
</head>
<body>
<style>
body {
    font-family: Verdana, sans-serif;
	background-color: #86A8E7;
}

.registration-container {
	display: flex;
	flex-direction: column;
    width: 500px;
    margin: 60px auto;
    background-color: #fff;
    padding-top: 10px;
	padding-left: 20px;
	padding-right: 22px;
	padding-bottom: 10px;
    border-radius: 6px;
    box-shadow: 0px 0px 27px 10px rgba(0, 0, 0, 0.1);
	text-align: center;
}

.registration-container h2 {
    font-size: 35px;
    text-align: center;
    margin-bottom: 30px;
}

.registration-container input[type="text"],
.registration-container input[type="number"],
.registration-container input[type="email"],
.registration-container input[type="password"],
.registration-container input[type="address"]{
	font-weight: 600;
    width: 95%;
    padding: 10px;
    margin-bottom: 15px;
    border: 2px solid #ccc;
    border-radius: 6px;
}

.registration-container select{
	font-weight: 600;
	width: 101%;
	padding: 10px;
    margin-bottom: 15px;
    border: 2px solid #ccc;
    border-radius: 7px;
}

.registration-container input[type="submit"] {
	margin-top: 20px;
	margin-bottom: 20px;
    width: 50%;
    padding: 10px;
    border: none;
    border-radius: 6px;
    background-color: #007FFF;
    color: #fff;
    cursor: pointer;
	display: inline-block;
	font-weight: 600;
}

.registration-container input[type="submit"]:hover {
	font-weight: 600;
	color: #f4f4f4;
    background-color: #0066b2;
	
}

.terms a,p{
	text-decoration: none;
	font-size: 14px;
}
</style>

<div class="registration-container">
    <h2>Sign up</h2>
    <form method="POST">
        <input type="number" placeholder="ID number" name="idno" required>
        <input type="text" placeholder="First Name" name="firstName" required>
        <input type="text" placeholder="Middle Name" name="middleName">
        <input type="text" placeholder="Last Name" name="lastName" required>
        <input type="password" placeholder="Password" name="password" required>
        <input type="password" placeholder="Confirm Password" name="cpassword" required>
        <input type="number" placeholder="Age" name="age" required>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="address" placeholder="Address" rows="4" required>
        <input type="submit" value="Sign up" name="save">
    </form>
	
	<div class="terms">
		<p>By clicking the Sign up button, you agree to our<br>
		<a href="">Terms and Condition</a> and <a href="#">Policy Privacy</a>
		</p>
		<a>Already have an account? <a href="login.php">Login here</a></p>
	</div>

</div>
</body>
</html>
