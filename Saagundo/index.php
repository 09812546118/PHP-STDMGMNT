<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="indexstyle.css">
</head>
<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
	font-family: Verdana, sans-serif;
    background-color: #86A8E7;
}

.img-container {
    display: flex;
	text-align: center;
    justify-content: space-around;
    padding: 10px; /* Add padding to create separation between border and images */
}

.admin-img,
.student-img {
    margin: 50px; /* Add margin between images */

}

.student-img,
.admin-img {
	display: inline-block;
    margin: 50px;
    border-radius: 10px; /* Rounded border */
    transition: border-color 0.3s; /* Smooth transition for border color change */
    width: 300px; /* Set width to your desired size */
    height: auto; /* Maintain aspect ratio */
    border: 2px solid black; /* Add border here */
    padding: 10px; /* Add padding to create separation between images and border */
}

.student-wrapper h2,
.admin-wrapper h2{
	text-align: center;
}

.student-wrapper a,
.admin-wrapper a{
	text-decoration: none;
	color: black;
}

.student-img:hover {
	border-color: #343434; /* Change border color to blue on hover */
	border: 10px solid #343434;
	color: #343434;
}
.admin-img:hover {
    border-color: #6C3483; /* Change border color to blue on hover */
	border: 10px solid #6C3483;
	color: #6C3483
}
</style>
<body>
	<div class="img-container">
		<div class="student-wrapper">
			<a href="login.php">
				<div class="student-img">
					<img src="./images/download.png">
					<h2>STUDENT</h2>
				</div>
			</a>
		</div>
		<div class="admin-wrapper">
			<a href="adminlogin.php">
				<div class="admin-img">
					<img src="./images/download -2.png">
					<h2>ADMIN</h2>
				</div>
			</a>
		</div>
	</div>
</body>
</html>
