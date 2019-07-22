<?php 

function sanitizeFormArtistPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormArtistUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormArtistString($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}


if(isset($_POST['artistRegisterButton'])) {
	//artistRegister button was pressed
	$artistUsername = sanitizeFormArtistUsername($_POST['artistUsername']);
	$firstName = sanitizeFormArtistString($_POST['firstName']);
	$lastName = sanitizeFormArtistString($_POST['lastName']);
	$email = sanitizeFormArtistString($_POST['email']);
	$email2 = sanitizeFormArtistString($_POST['email2']);
	$password = sanitizeFormArtistPassword($_POST['password']);
	$password2 = sanitizeFormArtistPassword($_POST['password2']);

	$wasSuccessful = $artistAccount->register($artistUsername, $firstName, $lastName, $email,
	$email2, $password, $password2);

	if($wasSuccessful == true) {
		$_SESSION['userLoggedIn'] = $artistUsername;
		header("Location: uploadSong.php");
	}

}
?>

