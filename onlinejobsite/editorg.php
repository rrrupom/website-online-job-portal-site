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

if(isset($_SESSION["org_name"])){
	$org_name=$_SESSION["org_name"];
}
else{
	$org_name="";
}
// Create connection
$conn = new mysqli("localhost", "root", "", "job");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM organization WHERE Name = '$org_name'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $location=$row["Location"];
        $type=$row["Type"];
    }
} else {
    echo "0 results";
}

$locationErr=$typeErr="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if (empty($_POST["location"])) {
		$locationErr="Please enter the location";
	}else{
		$location = test_input($_POST["location"]);
	}
	if (empty($_POST["type"])) {
		$typeErr="Please enter the Organization type";
	}else{
		$type = test_input($_POST["type"]);
	}
	if($locationErr=="" && $typeErr==""){
		$sql = "UPDATE organization SET Location='$location',Type='$type' WHERE Name = '$org_name'";
		$result = mysqli_query($conn, $sql);
		if($result==true){
			header("location: EmployerProfile.php");
		}
	}

$conn->close();
}
function test_input($data){
	$data=trim($data);
	$data=stripslashes($data);
	$data=htmlspecialchars($data);
	return $data;
}


?>
<html>
<head>
	<title>About Us</title>
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
		<center>
		<h2>Edit Organization Details</h2>
		<p><span class="error">* required field.</span></p><br>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table class="tableform">
			<tr>
				<td>Oraganization Name</td>
				<td>:</td>
				<td><input type="text" name="org_name" value="<?php echo $org_name;?>" readonly="true" class="del3"></td>
				<td>To change the organization<br>go to edit my profile</td>
			</tr>
			<tr>
				<td>Location</td>
				<td>:</td>
				<td><input type="text" name="location" value="<?php echo $location;?>"></td>
				<td><span class="error">*<?php echo $locationErr; ?></span></td>
			</tr>
			<tr>
				<td>Type</td>
				<td>:</td>
				<td>
					<input type="radio" name="type"
					<?php if (isset($type) && $type=="Government") echo "checked";?>
		 			value="Government" > Government<br>
					<input type="radio" name="type"
					<?php if (isset($type) && $type=="Semi Government") echo "checked";?> 
					value="Semi Government"> Semi Government<br>
					<input type="radio" name="type"
					<?php if (isset($type) && $type=="NGO") echo "checked";?>
		 			value="NGO" > NGO<br>
					<input type="radio" name="type"
					<?php if (isset($type) && $type=="Private Firm/Company") echo "checked";?> 
					value="Private Firm/Company"> Private Firm/Company<br>
					<input type="radio" name="type"
					<?php if (isset($type) && $type=="International Agencies") echo "checked";?>
		 			value="International Agencies" > International Agencies<br>
					<input type="radio" name="type"
					<?php if (isset($type) && $type=="Others") echo "checked";?> 
					value="Others"> Others

				</td>
				<td><span class="error">*<?php echo $typeErr; ?></span></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><input type="submit" name="submit" value="SUBMIT"></td>
			</tr>
		</table>
		</form>
		</center>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>