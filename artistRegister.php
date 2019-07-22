<?php 
include("includes/config.php");
include("includes/classes/ArtistAccount.php");
include("includes/classes/Constants.php");

$artistAccount = new ArtistAccount($con);

include("includes/handlers/artist-register-handler.php");
include("includes/handlers/artist-login-handler.php");

function getInputValue($name) {
	if(isset($_POST[$name])){
		echo $_POST[$name];
	}
}
?>


<html>
<head>
	<title>Welcome to Beam!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<script src="assets/js/register.js"></script>


</head>
<body>
	<?php

if(isset($_POST['artistRegisterButton'])) {
	echo'<script>
		$(document).ready(function(){
			$("#loginForm").hide();
			$("#registerForm").show();
});
	</script>';


}
	else{
		echo'<script>
		$(document).ready(function(){
			$("#loginForm").show();
			$("#registerForm").hide();
});
	</script>';



	}

	?>









<div id="artistBackground">

		<div id="loginContainer">

			<div id="inputContainer">

			<form id="loginForm" action="artistRegister.php" method="POST">
				<h2>Login to your artist account</h2>
				<p>
					<?php echo $artistAccount->getError(Constants::$loginFailed); ?>
					<label for="artistLoginUsername">Artist name</label>
					<input id="artistLoginUsername" name="artistLoginUsername" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('artistLoginUsername') ?>" required>
				</p>
				<p>
					<label for="artistLoginPassword">Password</label>
					<input id="artistLoginPassword" name="artistLoginPassword" type="password" placeholder="Your password" required>
				</p>

				<button type="submit" name="artistLoginButton">LOG IN</button>


				<div class="hasAccountText">
					<span id="hideLogin">Don't have an account yet? Signup here.</span>
				</div>

				<div class="hasAccountText">
						<span id="hideLogin"><a href="register.php"> I'm not an artist</a></span>
					</div>

				<div class="hasAccountText">
					<span id="hideLogin"><a href="requestReset.php"> Forgot Password?</a></span>
				</div>


				
			</form>



			<form id="registerForm" action="artistRegister.php" method="POST">
				<h2>Create your free artist account</h2>
				<p>
					<?php echo $artistAccount->getError(Constants::$usernameCharacters); ?>
					<?php echo $artistAccount->getError(Constants::$artistUsernameTaken); ?>
					<label for="artistUsername">Artist name</label>
					<input id="artistUsername" name="artistUsername" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('artistUsername') ?>" required>
				</p>

				<p>
					<?php echo $artistAccount->getError(Constants::$firstNameCharacters); ?>
					<label for="firstName">First name</label>
					<input id="firstName" name="firstName" type="text" placeholder="e.g. Bart" value="<?php getInputValue('firstName') ?>" required>
				</p>

				<p>
					<?php echo $artistAccount->getError(Constants::$lastNameCharacters); ?>
					<label for="lastName">Last name</label>
					<input id="lastName" name="lastName" type="text" placeholder="e.g. Simpson" value="<?php getInputValue('lastName') ?>" required>
				</p>

				<p>

					<?php echo $artistAccount->getError(Constants::$emailTaken); ?>
					<?php echo $artistAccount->getError(Constants::$emailsDoNotMatch); ?>
					<?php echo $artistAccount->getError(Constants::$emailInvalid); ?>
					<label for="email">Email</label>
					<input id="email" name="email" type="email" placeholder="e.g. bart@gmail.com" required>
				</p>

				<p>

				
					<label for="email2">Confirm email</label>
					<input id="email2" name="email2" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email') ?>" required>
				</p>

				<p>


					<?php echo $artistAccount->getError(Constants::$passwordsDoNotMatch); ?>
					<?php echo $artistAccount->getError(Constants::$passwordNotAlphanumeric); ?>
					<?php echo $artistAccount->getError(Constants::$passwordCharacters); ?>
					<label for="password">Password</label>
					<input id="password" name="password" type="password" placeholder="Your password" required>
				</p>

				<p>
					<label for="password2">Confirm password</label>
					<input id="password2" name="password2" type="password" placeholder="Your password" required>
				</p>

				<button type="submit" name="artistRegisterButton">SIGN UP</button>

				<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>

					<div class="hasAccountText">
						<span id="hideLogin"><a href="register.php"> I'm not an artist</a></span>
					</div>

					<div class="hasAccountText">
						<span id="hideLogin"><a href="requestReset.php"> Forgot Password?</a></span>
					</div>
	
			</form>

		</div>
<div id="loginText">
				<h1> </h1>
				<h2>   </h2>

				<ul><h2></h2></ul>
				<ul>

					
					<li> </li>
					<li>  </li>
				
					<li>  </li>

				</ul>

			</div>




	</div>
</div>

</body>
</html>