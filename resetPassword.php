<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<div class="sexyBeast"> 


<?php 
include("includes/config.php");

if(!isset($_GET["code"])) {
	exit("can't find page dude");
}

$code = $_GET["code"];

$getEmailQuery = mysqli_query($con, "SELECT email FROM resetPasswords WHERE code= '$code'");
if(mysqli_num_rows($getEmailQuery) == 0) {
	exit("can't find page dude or dudette");

}

if(isset($_POST["password"])) {
	$pw = $_POST["password"];
	$pw = md5($pw);

	$row = mysqli_fetch_array($getEmailQuery);
	$email = $row["email"];

	$query = mysqli_query($con,"UPDATE users SET password='$pw'  WHERE email='$email'");

	if($query) {
		$query = mysqli_query($con,"DELETE FROM resetPasswords  WHERE code='$code'");
		exit("Password updated");
	}
	else("something went wrong");
}

?>
</div>


</body>
</html>














<link rel="stylesheet" type="text/css" href="assets/css/style.css">


  <div class="userDetails">
        <div class="container borderBottom">


 <form method="POST">
 	<input type="password" name="password" placeholder="New password">
 	<br>
 	<button class="button">Update Password</button>

 	        </div>
 </div>
 	
 </form>

