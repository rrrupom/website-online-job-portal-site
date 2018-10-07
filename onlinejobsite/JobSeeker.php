<!DOCTYPE html>

<?php
session_start();
if(isset($_SESSION["Username"])){
	$userProfile=$_SESSION["Username"];
	$ut=$_SESSION["Usertype"];
	$flag=1;
}
else{
	$flag=0;
}

// Create connection
$conn = new mysqli("localhost", "root", "", "job");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM job_seeker";
$result = mysqli_query($conn, $sql);
?>



<html>
<head>
	<title>Job Seeker</title>
	<link rel="stylesheet" type="text/css" href="all.css">
</head>
<body>
<div class="main">
	<div class="header">
		<img src="images/logo.png" width="300" height="70">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="Employer.php">Employer</a></li>
			<li><a href="JobSeeker.php">Job Seeker</a></li>
			<li><a href="AboutUs.php">About Us</a></li>
			<?php
			if($flag==1){
				if($ut==1){
					echo "<li><a href='JobSeekerProfile.php' style='background: #ffff99;border-radius:10px'>User: ".$userProfile."</a></li>";
				}
				elseif ($ut==2) {
					echo "<li><a href='EmployerProfile.php' style='background: #ffff99;border-radius:10px'>User: ".$userProfile."</a></li>";
				}
				else{
					echo "<li><a href='AdministratorProfile.php' style='background: #ffff99;border-radius:10px'>User: ".$userProfile."</a></li>";
				}
			}
			else{
				echo "
				<li><a href='login.php'>Login</a></li>
				<li><a href='register.php'>Register</a></li>
				";
			}
			?>
		</ul>
		<img id="pic" src="images/bigpicture.jpg" alt="" width="960" height="300" />
	</div>
	<div class="content">
		<center><h2>Our Job Seekers</h2></center>
		<table class="tt">
		<tr>
			<td>Name</td>
			<td>Email</td>
			<td>Contact Number</td>
			<td>Address</td>
		</tr>
		<?php
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	$name=$row["Name"];
		    	$email=$row["Email"];
		    	$contact=$row["ContactNo"];
		    	$address=$row["Address"];
		    	echo "<tr><td>$name</td><td>$email</td><td>$contact</td><td>$address</td></tr>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?> 
		</table><br>
		<center><a href="JobSeekerReg.php">New job seeker? Register here</a></center>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>