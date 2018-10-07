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
?>
<html>
<head>
	<title>Online Job Site</title>
	<link rel="stylesheet" type="text/css" href="index.css">
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
		<img src="images/bigpicture.jpg" alt="" width="960" height="300" />
	</div>
	<div class="content">
		<h2>Welcome</h2>
		<p>Welcome to online Job Site. It provides facility to the Job Seeker to search for various jobs as per his qualification. Here Job Seeker can registered himself on the web portal and create his profile along with his educational information. Job Seeker can search various jobs and apply for the Job.<br>This Portal is also designed for the various employer who required to recruit employees in their organization. Employer can registered himself on the web portal and then he can upload information of various job vacancies in their organization. Employeer can view the applications of Job Seeker and send call latter to the job seekers.</p>
	</div>
	<div class="section">
		<div class="org"><center>
			<form method="post" action="alljoboffer.php">
			<h2>Organization Type</h2>
			<input type="submit" name="type" value="Government"><br>
			<input type="submit" name="type" value="Semi Government"><br>
			<input type="submit" name="type" value="NGO"><br>
			<input type="submit" name="type" value="Private Firm/Company"><br>
			<input type="submit" name="type" value="International Agencies"><br>
			<input type="submit" name="type" value="Others">
			</form>
			</center>
		</div>
		<div class="newjob"><center>
			<h2>Category</h2>
			<form method="post" action="category.php">
			<table style="width:100%">
			
				<tr>
					<td><center><input type="submit" name="type" value="Accounting/Finance/Banking"></center></td>
					<td></td>
					<td><center><input type="submit" name="type" value="Education/Training"></center></td>
				</tr>
				<tr>
					<td><center><input type="submit" name="type" value="Engineer/Architects"></center></td>
					<td></td>
					<td><center><input type="submit" name="type" value="IT and Telecommunication"></center></td>
				</tr>
				<tr>
					<td><center><input type="submit" name="type" value="Marketing/Sales"></center></td>
					<td></td>
					<td><center><input type="submit" name="type" value="Medical/Pharma"></center></td>
				</tr>
				<tr>
					<td><center><input type="submit" name="type" value="Law/Legal"></center></td>
					<td></td>
					<td><center><input type="submit" name="type" value="Garments/Textile"></center></td>
				</tr>
				<tr>
					<td><center><input type="submit" name="type" value="Airline/Travel/Tourism"></center></td>
					<td></td>
					<td><center><input type="submit" name="type" value="Media/Advertising/Event Mgt."></center></td>
				</tr>
				<tr>
					<td><center><input type="submit" name="type" value="Others"></center></td>
					<td></td>
					<td><center><h3><a href="category.php">All Job Offer</a></h3></center></td>
				</tr>
			</table>
			</form>
			</center>
		</div>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>