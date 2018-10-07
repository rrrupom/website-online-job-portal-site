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

if(isset($_SESSION["Username"])){
	$loginUser=$_SESSION["Username"];
	$flag=1;
}
else{
	$loginUser="";
	$flag=0;
}
$sql = "SELECT * FROM employer WHERE Username = '$loginUser'";
$result = mysqli_query($conn, $sql);

$name = $email = $contactNo = $username = $org_name ="";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name =$row["Name"];
        $email = $row["Email"];
        $contactNo = $row["ContactNo"];
        $username = $row["Username"];
        $password = $row["Password"];
        $org_name = $row["Org_name"];
    }
} else {
    echo "0 results";
}

$_SESSION["org_name"]=$org_name;

$sql = "SELECT * FROM organization WHERE Name = '$org_name'";
$result = mysqli_query($conn, $sql);

$org_loc=$org_type="";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $org_loc=$row["Location"];
        $org_type=$row["Type"];
    }
} else {
    echo "0 results";
}

$conn->close();
?> 

<html>
<head>
	<title>Profile Employer</title>
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
		'<form method="post" action="EmployerReg.php>
		<center>
			<table class="protable">
				<tr>
					<td colspan="6" class="proh2"><h2>Employer Profile</h2></td>
					<td style="text-align:right;"><h4><a href="logout.php">Logout</a></h4></td>
				</tr>
				<tr>
					<td colspan="3" class="proh2">Personal Details</td>
					<td colspan="3" class="proh2">Organization Details</td>
					<td rowspan="2"><center><h3><a href="postjoboffer.php">Post A Job Offer</a></h3></center></td>
				</tr>
				<tr>
					<td>Name</td>
					<td>:</td>
					<td><input type="text" name="name" value="'.$name.'" readonly="true" class="del2"></td>
					<td>Organization</td>
					<td>:</td>
					<td><input type="text" name="org_name" value="'.$org_name.'" readonly="true" class="del2"></td>
					
				</tr>
				<tr>
					<td>Email</td>
					<td>:</td>
					<td><input type="text" name="email" value="'.$email.'" readonly="true" class="del2"></td>
					<td>Location</td>
					<td>:</td>
					<td>'.$org_loc.'</td>
					<td rowspan="2"><center><h3><a href="myoffer.php">My Job Offer</a></h3></center></td>
				</tr>
				<tr>
					<td>Contact No</td>
					<td>:</td>
					<td><input type="text" name="contactNo" value="'.$contactNo.'" readonly="true" class="del2"></td>
					<td>Type</td>
					<td>:</td>
					<td>'.$org_type.'</td>
				</tr>
				<tr>
					<td>Username</td>
					<td>:</td>
					<td><input type="text" name="username" value="'.$username.'" readonly="true" class="del2"></td>
					<td></td>
					<td></td>
					<td></td>
					<td rowspan="2"><center><h3><a href="alljoboffer.php">Browse All Job Offer</a></h3></center></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="edit" value="Edit My Profile"></td>
					<td colspan="3"><h4><a href="editorg.php">Edit Organization Details</a></h4></td>
				</tr>
			</table>
		</center>
		</form>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>