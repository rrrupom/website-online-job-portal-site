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

if(isset($_POST["job_id"])){
	$_SESSION["job_id"]=$_POST["job_id"];
	$job_id=$_SESSION["job_id"];
}else{
	if(isset($_SESSION["job_id"])){
		$job_id=$_SESSION["job_id"];
	}else{
		$job_id=0;
	}
}
// Create connection
$conn = new mysqli("localhost", "root", "", "job");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM job_offer WHERE Job_ID='$job_id'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0){
	// output data of each row
	while($row = $result->fetch_assoc()){
		$job_id=$row["Job_ID"];
    	$job_title=$row["Job_title"];
    	$category=$row["Category"];
    	$req_skill=$row["Req_skill"];
    	$designation=$row["Designation"];
    	$salary=$row["Salary"];
    	$time=$row["Timestamp"];

	}
}else {
	    echo "0 results";
}
$sql = "SELECT employer.Name, employer.Email, employer.ContactNo,employer.Org_name, organization.Location,organization.Type FROM employer,posts,organization WHERE employer.Username=posts.E_username AND posts.Job_ID='$job_id' AND organization.Name=posts.Org_name";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0){
	// output data of each row
	while($row = $result->fetch_assoc()){
		$e_name=$row["Name"];
		$e_email=$row["Email"];
		$e_contact=$row["ContactNo"];
		$org_name=$row["Org_name"];
		$org_loc=$row["Location"];
		$org_type=$row["Type"];

	}
}else {
	    echo "0 results";
}

$conn->close();
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
		<table class="protable">
			<tr>
				<td colspan="3" class="proh2"><h2>Job Offer Details</h2></td>
				<td colspan="2" class="proh2"><h2>Organization Details</h2></td>
			</tr>
			<tr>
				<td>Job ID:</td>
				<td>:</td>
				<td><?php echo $job_id?></td>
				<td>Name</td>
				<td>:   <?php echo $org_name?></td>
			</tr>
			<tr>
				<td>Job Title</td>
				<td>:</td>
				<td><?php echo $job_title?></td>
				<td>Location</td>
				<td>:   <?php echo $org_loc?></td>
				<td></td>
			</tr>
			<tr>
				<td>Category</td>
				<td>:</td>
				<td><?php echo $category?></td>
				<td>Type</td>
				<td>:   <?php echo $org_type?></td>
			</tr>
			<tr>
				<td>Designation</td>
				<td>:</td>
				<td><?php echo $designation?></td>
				<td colspan="2" class="proh2"><h2>Employer Details</h2></td>
			</tr>
			<tr>
				<td>Required skill</td>
				<td>:</td>
				<td><?php echo $req_skill?></td>
				<td>Name</td>
				<td>:   <?php echo $e_name?></td>
			</tr>
			<tr>
				<td>Salary</td>
				<td>:</td>
				<td><?php echo $salary?></td>
				<td>Email</td>
				<td>:   <?php echo $e_email?></td>
			</tr>
			<tr>
				<td>Posted On</td>
				<td>:</td>
				<td><?php echo $time?></td>
				<td>Contact No.</td>
				<td>:   <?php echo $e_contact?></td>
			</tr>
		</table>



	<?php

	?>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>