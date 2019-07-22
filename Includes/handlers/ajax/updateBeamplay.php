<?php
include("../../config.php");

if(isset($_POST['songId'])) {
	$songId = $_POST['songId'];
	$userId = $_POST['userId'];
	$beamplay = $_POST['beamplay'];

	if( $database->has('beamplays', [
		'AND' => [
			'songId' => $songId,
			'userId' => $userId,
		]
	]) ) {
		$database->update('beamplays', [
			'beamplay' => $beamplay,
		], [
			'songId' => $songId,
			'userId' => $userId
		]);
	} else {
		$database->insert('beamplays', [
			'beamplay' => $beamplay,
			'songId' => $songId,
			'userId' => $userId
		]);
	}
}
?>