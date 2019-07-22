<?php  
include("includes/includedFiles.php");
?>

<div class="entityInfo">

	<div class="centerSection">
		<div class="userInfo">
			<div class="profile">
				<img src="<?php echo $userLoggedIn->getprofilePic(); ?>">
			</div>
			<h1><?php echo $userLoggedIn->getUsername(); ?></h1>
			
		</div>
	</div>

	<div class="buttonItems">
		<button class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
		<button class="button" onclick="logout()">LOGOUT</button>
	</div>


</div>
