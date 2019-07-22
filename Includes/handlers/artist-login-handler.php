<?php 

if(isset($_POST['artistLoginButton'])) {
	//artistLogin button was pressed
	$artistUsername = $_POST['artistLoginUsername'];
	$artistPassword = $_POST['artistLoginPassword'];

	$result = $artistAccount->login($artistUsername, $artistPassword);

	if($result == true) {
		$_SESSION['userLoggedIn'] = $artistUsername;
		header("Location: uploadSong.php");
	}

}


 ?>