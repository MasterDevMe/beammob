<?php
require_once("../../config.php");
include("../../classes/User.php");

if( isset($_SESSION['userLoggedIn']) && $_GET['id'] ) {
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	
	if( !$database->has('follows', ['AND' => ['followFrom' => $userLoggedIn->id, 'followTo' => $_GET['id'] ]]) ) {
		$database->insert('follows', [
			'followFrom' => $userLoggedIn->id,
			'followTo' => $_GET['id']
		]);
		echo 'followed';
	} else {
		$database->delete('follows', ['AND' => ['followFrom' => $userLoggedIn->id, 'followTo' => $_GET['id'] ]]);
		echo 'unfollowed';
	}
	
}
?>
