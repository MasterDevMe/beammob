<?php
include("../../config.php");
include("../../classes/User.php");

if(isset($_POST['songId'])) {
	$songId = $_POST['songId'];
	
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	$userId = $userLoggedIn->id;

	// $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");
	if( $database->has('beamplays', [
		'songId' => $songId,
		'userId' => $userId
	]) ) {
		$result = $database->select('songs', [
				'[<]beamplays' => ['id' => 'songId']
			], [
				'songs.id',
				'songs.title',
				'songs.artist',
				'songs.album',
				'songs.genre',
				'songs.duration',
				'songs.path1',
				'songs.path2',
				'songs.mixdown',
				'songs.albumOrder',
				'songs.plays',
				'songs.producer',
				'songs.feature',
				'songs.privacy',

				'beamplays.beamplay'
			], ['songs.id' => $songId, 'beamplays.userId' => $userId]);
	} else {
		$result = $database->select('songs', [
				'id',
				'title',
				'artist',
				'album',
				'genre',
				'duration',
				'path1',
				'path2',
				'songs.mixdown',
				'albumOrder',
				'plays',
				'producer',
				'feature',
				'privacy',


			], ['id' => $songId]);
	}
	
	echo json_encode($result[0]);
}


?>