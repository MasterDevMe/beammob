<?php
require_once('../../config.php');
require_once('../../uploadFuncs.php');
require_once('../../classes/Artist.php');

$action = $_GET['action'];

switch($action) {
	case 'createAlbum':
		
		$album = array(
			'title' => $_POST['albumTitle'],
			'price' => (float) $_POST['albumPrice'],
			'file'  => $_FILES['albumPhoto'],
			'albumGenre'  => $_POST['albumGenre']
		);
				
		$file = uploadAlbumPhoto();
		
		if( isset($file['filename'])
			&& $album['title'] ) {
			$album['file'] = 'uploads/album-pics/' . $file['filename'];
		
			$data = $database->insert('albums', [
                'title'       => $album['title'],
                'artist'      => Artist::getLoggedIn()->getId(),
                'albumPrice'  => $album['price'],
                'artworkPath' => $album['file'],
                'genre'       => $album['albumGenre'],
			]);
			
			if( $data->rowCount() )
				echo json_encode([
					'status' => 'done',
					'id' => $database->id(),
					'title' => $album['title']
				]);
			else
				echo json_encode([
					'msg' => $database->error(),
				]);
		}
		
		break;
		
	case 'uploadSong':
		$song = array(
            'songOrder'    => (int) $_POST['songOrder'],
            'title'        => $_POST['songTitle'],
            'album'        => (int) $_POST['albumId'],
            'featuredBy'   => $_POST['featuredBy'],
            'producedBy'   => $_POST['producedBy'],
            'privacy'      => (int) $_POST['songPrivacy'],
            'albumGenre'   => (int) $_POST['albumGenre'],
            'price'        => (float) $_POST['songPrice'],
            'vocalFile'    => $_FILES['vocalFile'],
            'beatFile'     => $_FILES['beatFile'],
            'fullsongFile' => $_FILES['fullsongFile'],
		);
		
		$files = uploadSongFiles();
		
		if( is_array($files) && count($files) == 3 ) {
			$song['vocalFile'] = 'uploads/music/' . $files[0]['filename'];
			$song['beatFile'] = 'uploads/music/' . $files[1]['filename'];
			$song['fullsongFile'] = 'uploads/music/' . $files[2]['filename'];
			
			$data = $database->insert('songs', [
				'title'      => $song['title'],
				'artist'     => Artist::getLoggedIn()->getId(),
				'albumOrder' => $song['songOrder'],
				'album'      => $song['album'],
				'feature'    => 'Featuring ' . $song['featuredBy'],
				'producer'   => $song['producedBy'],
				'privacy'    => $song['privacy'],
				'genre'      => $song['albumGenre'],
				'price'      => $song['price'],
				'path1'      => $song['vocalFile'],
				'path2'      => $song['beatFile'],
				'mixdown'    => $song['fullsongFile'],
			]);
			
			if( $data->rowCount() )
				echo json_encode([
					'status' => 'done',
					'title' => $song['title'],
					'id' => $database->id(),
				]);
			else
				echo json_encode([
					'msg' => $database->error(),
				]);
		}
		
		break;
	
	case 'uploadBeambag':		
		$beambag = array(
			'beambagName' => $_POST['beambagName'],
			'price'       => (float) $_POST['beambagPrice'],
			'beambagFile' => $_FILES['beambagFile'],
		);
		
		$file = uploadBeambagFile();
		
		if( isset($file['filename']) ) {
			$beambag['beambagFile'] = 'uploads/beambags/' . $file['filename'];
			
			$data = $database->insert('beambags', [
				'artist'   => Artist::getLoggedIn()->getId(),
				'bagName'  => $beambag['beambagName'],
				'bagPrice' => $beambag['price'],
				'bagPath'  => $beambag['beambagFile']
			]);
			
			if( $data->rowCount() )
				echo json_encode([
					'status' => 'done',
					'id' => $database->id(),
					'title' => $beambag['beambagName']
				]);
			else
				echo json_encode([
					'msg' => $database->error(),
				]);
		}
		break;
	case 'uploadProfilePic':
		$profilePhoto = array(

			'profilePhotoFile' => $_FILES['profilePhotoFile'],
		);
		
		$file = uploadProfilePhotoFile();
		
		if( isset($file['filename']) ) {
			$profilePhoto['profilePhotoFile'] = 'uploads/artist-pic/' . $file['filename'];
			
			$data = $database->update('artists', [
				'artistPic'  => $profilePhoto['profilePhotoFile'],
			], [
				"id" => Artist::getLoggedIn()->getId()
			]);
			
			if( $data->rowCount() ) {
				$_SESSION['photo_path'] = $profilePhoto['profilePhotoFile'];
				echo json_encode([
					'status' => 'done',
					'title' => $profilePhoto['profilePhotoFile']
				]);
			}
			else
				echo json_encode([
					'msg' => $database->error(),
				]);
		}
		break;
}
?>