<?php
include("includes/config.php");
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");

//session_destroy(); LOGOUT

if( !isset($_SESSION['userLoggedIn']) ) {
	header("Location: register.php");
}
$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
$username = $userLoggedIn->getUsername();
$id = $userLoggedIn->id;
?>

<html>
<head>
	<title>Welcome to Beammob!</title>
	
	<!--
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<?php
	if(isset($_SESSION['userLoggedIn'])) {
		echo <<<EOF
<script>
		userLoggedIn = '$username';
		userId = $id;
	</script>
EOF;
	} ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!--
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
-->
	<script src="assets/js/script.js"></script>
</head>

<body>

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">
