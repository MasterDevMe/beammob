<?php 

if(isset($_POST['artistLoginButton'])) {
	//artistLogin button was pressed
	$artistUsername = $_POST['artistLoginUsername'];
	$artistPassword = $_POST['artistLoginPassword'];

	$result = $artistAccount->login($artistUsername, $artistPassword);

	if($result) {
		$_SESSION['userLoggedIn'] = $artistUsername;
		$_SESSION['photo_path'] = $result[7];
		header("Location: uploadSong.php");
	}

}


 ?>