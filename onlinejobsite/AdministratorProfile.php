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

$loginUser=$_SESSION["Username"];
$sql = "SELECT * FROM administrator WHERE Username = '$loginUser'";
$result = mysqli_query($conn, $sql);

$name = $email = $username ="";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name =$row["Name"];
        $email = $row["Email"];
        $username = $row["Username"];
    }
} else {
    echo "0 results";
}
$conn->close();
?> 

<html>
<head>
	<title>Profile Administrator</title>
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
		<form>
		<table class="protable">
			<tr>
				<td colspan="3" class="proh2"><h2>Administrator Profile</h2></td>
				<td style="text-align:right;"><h4><a href="logout.php">Logout</a></h4></td>
			</tr>
			<tr>
				<td>Name</td>
				<td>:</td>
				<td><?php echo $name?></td>
				<td rowspan="2"><center><h3><a href="approvejoboffer.php">Unapproved Job Offers</a></h3></center></td>
			</tr>
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><?php echo $email?></td>
			</tr>
			<tr>
				<td>Username</td>
				<td>:</td>
				<td><?php echo $username?></td>
				<td rowspan="2"><center><h3><a href="deletejoboffer.php">Delete A Job Offer</a></h3></center></td>
			</tr>
		</table>
			
		</form>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>