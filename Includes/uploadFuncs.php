<?php
require_once('FileUpload/vendor/autoload.php');

function uploadAlbumPhoto() {
	$validator = new FileUpload\Validator\Simple('20M', ['image/jpeg', 'image/pjpeg', 'image/png']);
	$pathResolver = new FileUpload\PathResolver\Simple('../../../uploads/album-pics');
	$fileSystem = new FileUpload\FileSystem\Simple();
	$fileUpload = new FileUpload\FileUpload($_FILES['albumPhoto'], $_SERVER);
	$fileNameGenerator = new FileUpload\FileNameGenerator\Random(16);

	$fileUpload->setFileNameGenerator($fileNameGenerator);
	$fileUpload->setPathResolver($pathResolver);
	$fileUpload->setFileSystem($fileSystem);
	$fileUpload->addValidator($validator);

	if( $fileUpload->validateAll() ) {
		// Doing the deed
		list($files, $headers) = $fileUpload->processAll();

		// Output
		/*
		foreach($headers as $header => $value ) {
			header($header . ': ' . $value);
		}
		*/

		// UPLOAD COMPLETED
		if( $files[0]->completed ) {
			$fname = $files[0]->getFilename();
			
			return array(
				'code' => '200',
				'filename' => $fname,
				'done' => true
			);
		} else {
			return array(
				'code' => $files[0]->errorCode,
				'msg' => sprintf('%s : %s', $_FILES['albumPhoto']['name'], $files[0]->error)
			);
		}
	}
		
	return false;
}

function uploadSongFiles() {	
	$fileUpload = new FileUpload\FileUpload(array(
			$_FILES['vocalFile'],
			$_FILES['beatFile'],
			$_FILES['fullsongFile']
		),
		$_SERVER);
	// $photoUpload = new FileUpload\FileUpload($_FILES['songPhotoFile'], $_SERVER);
	
	$results = array();
	
	$fileNameGenerator = new FileUpload\FileNameGenerator\Random(16);
	
	// PHOTO UPLOADER
	/*
	$validator = new FileUpload\Validator\Simple('20M', ['image/jpeg', 'image/pjpeg', 'image/png']);
	$pathResolver = new FileUpload\PathResolver\Simple('../../../uploads/pictures');
	$photoUpload->setPathResolver($pathResolver);
	$photoUpload->addValidator($validator);
	*/
	
	// SONG UPLOADER
	$validator = new FileUpload\Validator\Simple('200M', ['audio/mpeg3', 'audio/x-mpeg-3', 'audio/mpeg', 'audio/x-mpeg', 'audio/wav', 'audio/x-wav']);
	$pathResolver = new FileUpload\PathResolver\Simple('../../../uploads/music');
	$fileUpload->setPathResolver($pathResolver);
	$fileUpload->addValidator($validator);
			
	$fileSystem = new FileUpload\FileSystem\Simple();
	
	$fileUpload->setFileNameGenerator($fileNameGenerator);
	$fileUpload->setFileSystem($fileSystem);
	
	/*
	$photoUpload->setFileNameGenerator($fileNameGenerator);
	$photoUpload->setFileSystem($fileSystem);
	*/
			
	// Validate all files
	if( $fileUpload->validateAll() ) {
		// Doing the deed
		list($files, $headers) = $fileUpload->processAll();
		// list($pfiles, $headers) = $photoUpload->processAll();
		
		// $files = array_merge($files, $pfiles);
	
		foreach( $files as $key => $file ) {
			if( $file->completed ) {
				$fname = $file->getFilename();
				$status = array(
					'code' => '200',
					'filename' => $fname,
					'done' => true
				);
				
			} else {
				$status = array(
					'code' => $file->errorCode,
					'msg' => sprintf('%s : %s', $_FILES[$key . 'File']['name'], $file->error)
				);
			}
			$results[$key] = $status;
		}
		
		return $results;
	}
	
	return false;	
}

function uploadBeambagFile() {
	$validator = new FileUpload\Validator\Simple('200M', ['application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip']);
	$pathResolver = new FileUpload\PathResolver\Simple('../../../uploads/beambags');
	$fileSystem = new FileUpload\FileSystem\Simple();
	$fileUpload = new FileUpload\FileUpload($_FILES['beambagFile'], $_SERVER);
	$fileNameGenerator = new FileUpload\FileNameGenerator\Random(16);
	
	$fileUpload->setFileNameGenerator($fileNameGenerator);
	$fileUpload->setPathResolver($pathResolver);
	$fileUpload->setFileSystem($fileSystem);
	$fileUpload->addValidator($validator);
	
	
	if( $fileUpload->validateAll() ) {
		// Doing the deed
		list($files, $headers) = $fileUpload->processAll();
		
		// Output
		/*
		foreach($headers as $header => $value ) {
			header($header . ': ' . $value);
		}
		*/
		
		// UPLOAD COMPLETED
		if( $files[0]->completed ) {
			$fname = $files[0]->getFilename();
			
			return array(
				'code' => '200',
				'filename' => $fname,
				'done' => true
			);
		} else {
			return array(
				'code' => $files[0]->errorCode,
				'msg' => sprintf('%s : %s', $_FILES['beambagFile']['name'], $files[0]->error)
			);
		}
	}
	
	return false;
}

function uploadProfilePhotoFile() {

	$validator = new FileUpload\Validator\Simple('20M', ['image/jpeg', 'image/pjpeg', 'image/png']);
	$pathResolver = new FileUpload\PathResolver\Simple('../../../uploads/artist-pic');
	$fileSystem = new FileUpload\FileSystem\Simple();
	$fileUpload = new FileUpload\FileUpload($_FILES['profilePhotoFile'], $_SERVER);
	$fileNameGenerator = new FileUpload\FileNameGenerator\Random(16);

	$fileUpload->setFileNameGenerator($fileNameGenerator);
	$fileUpload->setPathResolver($pathResolver);
	$fileUpload->setFileSystem($fileSystem);
	$fileUpload->addValidator($validator);

	if( $fileUpload->validateAll() ) {
		// Doing the deed
		list($files, $headers) = $fileUpload->processAll();

		// Output
		/*
		foreach($headers as $header => $value ) {
			header($header . ': ' . $value);
		}
		*/

		// UPLOAD COMPLETED
		if( $files[0]->completed ) {

			$fname = $files[0]->getFilename();
			return array(
				'code' => '200',
				'filename' => $fname,
				'done' => true
			);
		} else {
			return array(
				'code' => $files[0]->errorCode,
				'msg' => sprintf('%s : %s', $_FILES['profilePhotoFile']['name'], $files[0]->error)
			);
		}
	}
		
	return false;
}
