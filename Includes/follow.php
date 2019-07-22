<?php
require_once("../../config.php");
include("../../classes/User.php");

$followTo = 0;
if(isset($_GET['id']))
{
	$followTo = $_GET['id'];
}
else if(isset($_POST['id']))
{
	$followTo = $_POST['id'];
}
if( isset($_SESSION['userLoggedIn']) && $followTo ) {
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	
	if( !$database->has('follows', ['AND' => ['followFrom' => $userLoggedIn->id, 'followTo' => $followTo ]]) ) {
		$database->insert('follows', [
			'followFrom' => $userLoggedIn->id,
			'followTo' => $followTo
		]);
		echo 'followed';
	} else {
		$database->delete('follows', ['AND' => ['followFrom' => $userLoggedIn->id, 'followTo' => $followTo ]]);
		echo 'unfollowed';
	}
	
}
?>
