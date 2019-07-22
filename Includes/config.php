<?php
	ob_start();
	session_start();
	
	require_once('Medoo.php');
	use Medoo\Medoo;
	
	$database = new Medoo([
		'database_type' => 'mysql',
		'database_name' => 'beammob',
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'root'
	]);

	$timezone = date_default_timezone_set("America/New_York");

	$con = mysqli_connect("localhost", "root", "root", "beammob");

	if(mysqli_connect_errno()){
		echo "Failed to connect: " .mysqli_connect_errno();
	}



?>