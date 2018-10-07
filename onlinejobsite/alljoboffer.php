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

$msg="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST["type"])){
		$type=$_POST["type"];
		$msg="Job Offers from ".$type." type organizations";
		$sql = "SELECT job_offer.Job_ID,job_offer.Job_title,job_offer.Category, job_offer.Req_skill,job_offer.Designation,job_offer.Timestamp,job_offer.Ad_username FROM job_offer,organization,posts WHERE organization.Type='$type' AND organization.Name=posts.Org_name AND posts.Job_ID=job_offer.Job_ID ORDER BY job_offer.Job_ID DESC";
		$result = mysqli_query($conn, $sql);
	}
	
}
else{
	$sql = "SELECT * FROM job_offer ORDER BY Job_ID  DESC";
	$result = mysqli_query($conn, $sql);
	$msg="All Job Offers";
}


?>
<html>
<head>
	<title>All Job Offer</title>
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
		<table class="alljob">
			<tr>
				<td class="proh2"><h2><?php echo $msg;?></h2></td>
			</tr>

			<tr>
				<td>

				<?php

				 if ($result->num_rows > 0) {
				    // output data of each row
				    while($row = $result->fetch_assoc()) {
				    	$job_id=$row["Job_ID"];
				    	$job_title=$row["Job_title"];
				    	$category=$row["Category"];
				    	$req_skill=$row["Req_skill"];
				    	$designation=$row["Designation"];
				    	$time=$row["Timestamp"];
				    	

				    	if($row["Ad_username"]!="")
				    	{
				    	echo
				    	'<form action="detailjoboffer.php" method="post">
				    	<table class="offer">
						<tr>
							<td colspan="2"><h4>
							<input type="submit" name="" value="Job ID:'.$job_id.'" class="detoffer">
							
							</h4></td>
							<td style="text-align:right;"><h4>
							<input type="text" name="job_id" value="'.$job_id.'" readonly="true" id="del">
							Posted on: '.$time.'   
							<input type="submit" name="" value="Details" class="detoffer">
							</h4></td>
						</tr>
						<tr>
							<td>Job Title</td>
							<td>:</td>
							<td>'.$job_title.'</td>
						</tr>
						<tr>
							<td>Category</td>
							<td>:</td>
							<td>'.$category.'</td>
						</tr>
						<tr>
							<td>Required Skill</td>
							<td>:</td>
							<td>'.$req_skill.'</td>
						</tr>
						<tr>
							<td>Designation</td>
							<td>:</td>
							<td>'.$designation.'</td>
						</tr>
					</table>
					</form>';
						}

				    }
				} else {
				    echo "0 results";
				}
				$conn->close();
				?>



					
				</td>
			</tr>
		</table>
		<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table class="category">
			<tr>
				<td><h3 class="ctitle">Organization Type</h3></td>
			</tr>
			<tr>
				<td><input type="submit" name="type" value="Government"></td>
			</tr>
			<tr>
				<td><input type="submit" name="type" value="Semi Government"></td>
			</tr>
			<tr>
				<td><input type="submit" name="type" value="NGO"></td>
			</tr>
			<tr>
				<td><input type="submit" name="type" value="Private Firm/Company"></td>
			</tr>
			<tr>
				<td><input type="submit" name="type" value="International Agencies"></td>
			</tr>
			<tr>
				<td><input type="submit" name="type" value="Others"></td>
			</tr>
		</table>
		</form>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>