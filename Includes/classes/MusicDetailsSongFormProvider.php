<?php
class MusicDetailsSongFormProvider {
	public function __construct() {
	}

	public function createUploadForm($is_album, $frmClasses) {
        $albumTitleInput   = $this->createAlbumTitleInput();
        $albumPriceInput   = $this->createAlbumPriceInput();
        $fileAlbumPicInput = $this->createAlbumPicFileInput();
        $fileInput         = $this->createFileInput();
        $fileSecondInput   = $this->createSecondFileInput();
        $fileMixdownInput  = $this->createMixdownFileInput();
        $fileSongPicInput  = $this->createSongPicFileInput();
        $fileBeambagInput  = $this->createBeambagFileInput();
        $beamBagNameInput  = $this->createbeamBagNameInput();
        $beamBagPriceInput = $this->createbeamBagPriceInput();
        $songTitleInput    = $this->createSongTitleInput();
        $songPriceInput    = $this->createSongPriceInput();
        $songFeaturesInput = $this->createSongFeaturesInput();
        $SongProducerInput = $this->createSongProducerInput();
        $descriptionInput  = $this->createDescriptionInput();
        $privacyInput      = $this->createPrivacyInput();
        $categoriesInput   = $this->createCategoriesInput();
        $uploadButton      = $this->createUploadButton();
		
		$fields = [
			$this->formHeader($frmClasses),
			$is_album ? implode([$albumTitleInput, $albumPriceInput, $fileAlbumPicInput, $categoriesInput, $this->createUploadButton(false), $this->formEnd()]) : '',			
			$is_album ? '<h5 class="text-center mt-3 mb-3"><span class="oi oi-musical-note"></span>&nbsp;SONGS <span class="badge badge-secondary bg-danger">1 file</span></h5><div class="songs-container"><div class="song">' : '',
			$songTitleInput,
			$songFeaturesInput,
			$SongProducerInput,
			$privacyInput,
			$categoriesInput,
			$songPriceInput,
			$fileInput,
			$fileSecondInput,
			$fileMixdownInput,
			$fileSongPicInput,
			$is_album ? '</div></div>' : '',
			$uploadButton,
			$is_album ? '' : $this->formEnd()
		];

		return implode($fields);
	}
	
	private function formHeader($frmClasses) {
		return "<form class=\"songUpload " . implode($frmClasses, ',') . "\" action=\"\" method=\"POST\" novalidate enctype=\"multipart/form-data\">";
	}
	
	private function formEnd() {
		return "</form>";
	}

	private function createFileInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Vocal file</div>
			</div>
			<div class="custom-file">
				<input name="vocalFile" type="file" class="custom-file-input song-validation" required>
				<label class="custom-file-label">Choose file</label>
			</div>
		</div>
EOF;
	}
	
	private function createAlbumTitleInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend"><span class="input-group-text">Album Title</span></div>
			<input name="albumTitle" type="text" class="form-control" required>
		</div>
EOF;
	}

	private function createAlbumPriceInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend"><span class="input-group-text">Price</span></div>
			<input name="albumPrice" type="text" class="form-control" placeholder="0.0" pattern="[\d]+[\.]*[\d]*" step="1">
			<div class="input-group-append">
				<span class="input-group-text">$</span>
			</div>
			<div class="invalid-feedback">Please enter a numberic price</div>
		</div>
EOF;
	}

	private function createAlbumPicFileInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-camera-slr"></span>&nbsp;Album photo</div>
			</div>
			<div class="custom-file">
				<input name="albumPhoto" type="file" class="custom-file-input photo-validation" name='fileInput'  required>
				<label class="custom-file-label">Choose file</label>
			</div>
		</div>
EOF;
	}
	
	private function createSecondFileInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Beat file</div>
			</div>
			<div class="custom-file">
				<input name="beatFile" type="file" class="custom-file-input song-validation" required/>
				<label class="custom-file-label">Choose file</label>
			</div>
		</div>
EOF;
	}

	private function createMixdownFileInput() {

		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Full song file</div>
			</div>
			<div class="custom-file">
				<input name="fullsongFile" type="file" class="custom-file-input song-validation" name='fileInput' required>
				<label class="custom-file-label">Choose file</label>
			</div>
		</div>
EOF;
	}

	private function createSongPicFileInput() {

		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-camera-slr"></span>&nbsp;Song photo file</div>
			</div>
			<div class="custom-file">
				<input type="file" class="custom-file-input photo-validation" name='songPhotoFile' required>
				<label class="custom-file-label">Choose file</label>
			</div>
		</div>
EOF;
	}

	public function beambagFrm() {
		$str  = $this->formHeader(array('beambagUpload'));
		$str .= $this->createBeambagFileInput();
		$str .= $this->createbeamBagNameInput();
		$str .= $this->createbeamBagPriceInput();
		$str .= $this->createUploadButton();
		$str .= $this->formEnd();
		return $str;
	}

	public function profilePicFrm() {
		$str  = $this->formHeader(array('profilePicUpload'));
		$str .= $this->createFileProfilePicInput();
		$str .= $this->createUploadButton();

		return $str;	
	}

	private function createBeambagFileInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Beambag file</div>
			</div>
			<div class="custom-file">
				<input required type="file" class="custom-file-input beambag-validation" name='beambagFile' required>
				<label class="custom-file-label">Choose file (your zip file can only be 200MB Max)</label>
			</div>
		</div>
EOF;
	}

	private function createbeamBagNameInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend"><span class="input-group-text">Beambag Name</span></div>
			<input required type="text" name="beambagName" class="form-control" required>
		</div>
EOF;
	}

	private function createbeamBagPriceInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend"><span class="input-group-text">Price</span></div>
			<input required type="text" name="beambagPrice" class="form-control" pattern="[\d]+[\.]*[\d]*" placeholder="0.0" required>
			<div class="input-group-append">
				<span class="input-group-text">$</span>
			</div>
			<div class="invalid-feedback">Please enter a numberic price</div>
		</div>
EOF;
	}

	private function createSongTitleInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend"><span class="input-group-text">Song title</span></div>
			<input name="songTitle" type="text" class="form-control" required>
		</div>
EOF;
	}

	private function createSongPriceInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend"><span class="input-group-text">Price</span></div>
			<input name="songPrice" type="text" class="form-control" placeholder="1.00" pattern="[\d]+[\.]*[\d]*" required>
			<div class="input-group-append">
				<span class="input-group-text">$</span>
			</div>
			<div class="invalid-feedback">Please enter a numberic price</div>
		</div>
EOF;
	}


	private function createSongFeaturesInput() {
		return <<<EOF
		<div class="input-group">
			<div class="input-group-prepend"><span class="input-group-text">Featuring by</span></div>
			<input type="text" name="featuredBy" aria-describedby="featuredHelpBlock" class="form-control" required>
		</div>
		<small class="form-text text-muted mb-3" id="featuredHelpBlock">(Separate by commas)</small>
EOF;
	}

	private function createSongProducerInput() {
		return <<<EOF
		<div class="input-group">
			<div class="input-group-prepend"><span class="input-group-text">Produced by</span></div>
			<input name="producedBy" type="text" aria-describedby="productedHelpBlock" class="form-control" required>
		</div>
		<small class="form-text text-muted mb-3" id="productedHelpBlock">(Separate by commas)</small>
EOF;
	}

	private function createDescriptionInput() {
		return "<div class='form-group'>
					<textarea class='form-control' placeholder='Description' name='descriptionInput' rows='3'></textarea>
				</div>";
	}

	private function createPrivacyInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-pretend"><label for="" class="input-group-text">Privacy</label></div>
			<select name="songPrivacy" id="" class="custom-select">
				<option value='0'>Private (for sale only)</option>
				<option value='1'>Public (stream promo only)</option>
			</select>
		</div>
EOF;
	}

	private function createCategoriesInput() {
		global $database;

		$result = $database->select('genres', '*');
		
		$html = '<div class="input-group mb-3"><div class="input-group-pretend"><label for="" class="input-group-text">Category</label></div><select name="albumGenre" class="custom-select">';

	   foreach($result as $row) {
			$id = $row["id"];
			$name = $row["name"];
			$html .= "<option value='$id'>$name</option>";
		}

		$html .= "</select>
				</div>";

		return $html;

	}

	private function createFileProfilePicInput() {
		return <<<EOF
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<div class="input-group-text"><span class="oi oi-camera-slr"></span>&nbsp;Profile photo file</div>
			</div>
			<div class="custom-file">
				<input type="file" class="custom-file-input photo-validation" name='profilePhotoFile' name='fileInput' required>
				<label class="custom-file-label">Choose file</label>
			</div>
		</div>
EOF;
	}

	private function createUploadButton($visible = true) {
		return "<button type='submit' class='btn btn-primary " . ($visible ? '' : 'invisible') . "' name='uploadButton'>Upload</button>";
	}
}
?>
