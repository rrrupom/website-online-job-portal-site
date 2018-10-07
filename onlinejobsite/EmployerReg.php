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


if(isset($_SESSION["fl"])){
	$fl=1;
	$head="Edit My Profile";
}
else{
	$fl=0;
	$head="Employer Registration Form";
}


$name = $email = $contactNo = $org_name =$username = $password =$password2= "";
$nameErr =$emailErr =$contactNoErr =$org_nameErr=$usernameErr =$passwordErr =$password2Err= "";
if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST["edit"])){
		$_SESSION["fl"]=1;
		$fl=1;
	}
	else{
		$password2=$_POST["password2"];
	}

	if (empty($_POST["name"])) {
		$nameErr="Name is required";
	}else{
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			 $nameErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["email"])) {
		$emailErr="Email is required";
	}else{
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			 $emailErr = "Invalid email format";
		}
	}

	if (empty($_POST["contactNo"])) {
		$contactNoErr="Contact Number is required";
	}else{
		$contactNo = test_input($_POST["contactNo"]);
		if (!preg_match("/^[0-9]*$/",$contactNo)) {
			 $contactNoErr = "Invalid contact number";
		}
	}

	if (empty($_POST["org_name"])) {
		$org_nameErr="Organization Name is required";
	}else{
		$org_name = test_input($_POST["org_name"]);
	}


	if (empty($_POST["username"])) {
		$usernameErr="Username is required";
	}else{
		$username = test_input($_POST["username"]);
		if($fl==0){
			$sql = "SELECT Username FROM employer WHERE Username = '$username'";
			$result = mysqli_query($conn, $sql);
			if ($result->num_rows > 0){
				$usernameErr="This username is already used<br>Try another one!!";
			}
		}
	}

	if (empty($_POST["password"])) {
		$passwordErr="Password is required";
	}else{
		$password = test_input($_POST["password"]);
		if($password!=$password2){
			$password2Err="Passwords do not match";
		}
	}


	if($nameErr=="" && $emailErr=="" && $contactNoErr=="" && $org_nameErr=="" && $usernameErr=="" && $passwordErr=="" && $password2Err=="" && $fl==0){
		$sql = "INSERT INTO employer (Name, Email, ContactNo, Username, Password, Org_name)
		VALUES ('$name', '$email', '$contactNo','$username','$password','$org_name')";
		$result = mysqli_query($conn, $sql);
		if($result==true){
			$sql="SELECT Name FROM organization WHERE Name='$org_name'";
			$result = mysqli_query($conn, $sql);
			if ($result->num_rows > 0){
				$_SESSION["Message"]="You are successfully registered!!";
				header("location: login.php");
			}else{
				$sql="INSERT INTO organization (Name) VALUES ('$org_name')";
				$result = mysqli_query($conn, $sql);
				if($result==true){
					$_SESSION["Message"]="You are successfully registered!!";
					header("location: login.php");
				}
			}
		}
	}

	if($nameErr=="" && $emailErr=="" && $contactNoErr=="" && $org_nameErr=="" && $usernameErr=="" && $passwordErr=="" && $password2Err=="" && $fl==1){
		$sql = "UPDATE employer SET Name='$name', Email='$email', ContactNo='$contactNo',Password='$password', Org_name='$org_name' WHERE Username='$userProfile'";
		$result = mysqli_query($conn, $sql);
		if($result==true){
			$sql="SELECT Name FROM organization WHERE Name='$org_name'";
			$result = mysqli_query($conn, $sql);
			if ($result->num_rows > 0){
				header("location: EmployerProfile.php");
			}else{
				$sql="INSERT INTO organization (Name) VALUES ('$org_name')";
				$result = mysqli_query($conn, $sql);
				if($result==true){
					header("location: EmployerProfile.php");
				}
			}
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
	<title><?php echo $head; ?></title>
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
		<h2><?php echo $head; ?></h2>
		<p><span class="error">* required field.</span></p><br>
		<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table class="tableform">
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name;?>"></td>
				<td><span class="error">*<?php echo $nameErr; ?></span><br><br></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" value="<?php echo $email;?>"></td>
				<td><span class="error">*<?php echo $emailErr; ?></span><br><br></td>
			</tr>
			<tr>
				<td>Contact No</td>
				<td><input type="text" name="contactNo" value="<?php echo $contactNo; ?>"></td>
				<td><span class="error">*<?php echo $contactNoErr; ?></span><br><br></td>
			</tr>
			<tr>
				<td>Organization</td>
				<td><input type="text" name="org_name" value="<?php echo $org_name; ?>"></td>
				<td><span class="error">*<?php echo $org_nameErr; ?></span><br><br></td>
			</tr>
			<?php 

			if($fl==0){
				echo '
				<tr>
					<td>Username</td>
					<td><input type="text" name="username" value="'.$username.'"></td>
					<td><span class="error">*'.$usernameErr.'</span></td>
				</tr>';

			}
			else{
				echo '
				<tr>
					<td>Username</td>
					<td><input type="text" name="username" value="'.$username.'" readonly class="del3"></td>
					<td></td>
				</tr>';
			}

			?>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" value="<?php echo $password;?>"></td>
				<td><span class="error">*<?php echo $passwordErr; ?></span><br><br></td>
			</tr>
			<tr>
				<td>Confirm Password</td>
				<td><input type="password" name="password2"></td>
				<td><span class="error">*<?php echo $password2Err; ?></span><br><br></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="register" value="SUBMIT"></td>
				<td></td>
			</tr>
		</table>	
		</form>
		</center>
	</div>
	<div class="footer">&copy 2016 cuet cse</div>
</div>
</body>
</html>