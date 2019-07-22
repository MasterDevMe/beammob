<?php
require_once("includes/uploadHeader.php");
require_once("includes/classes/MusicDetailsSongFormProvider.php");
?>


<div class="column">
	<nav>
	  <div class="nav nav-tabs" id="nav-tab" role="tablist">
		<a class="nav-item nav-link disabled font-weight-bold" data-toggle="tab" href="#" role="tab" aria-disabled="true"><span class="oi oi-data-transfer-upload"></span>&nbsp;UPLOAD</a>
		<a class="nav-item nav-link active" id="nav-song-tab" data-toggle="tab" href="#nav-song" role="tab" aria-controls="nav-upSong" aria-selected="true">Song</a>
		<a class="nav-item nav-link" id="nav-album-tab" data-toggle="tab" href="#nav-album" role="tab" aria-controls="nav-upAlbum" aria-selected="false">Album or EP</a>
		<a class="nav-item nav-link" id="nav-beambag-tab" data-toggle="tab" href="#nav-beambag" role="tab" aria-controls="nav-upBeamBags" aria-selected="false">Beambags</a>
	  </div>
	</nav>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="nav-song" role="tabpanel" aria-labelledby="nav-upSong">
			<div class="py-3">
				<?php
				$formProvider = new MusicDetailsSongFormProvider();
				echo $formProvider->createUploadForm(false, array('asong-upload'));
				?>
			</div>
		</div>
		<div class="tab-pane fade" id="nav-album" role="tabpanel" aria-labelledby="nav-upAlbum">
			<div class="py-3">
				<?php
				$formProvider = new MusicDetailsSongFormProvider();
				echo $formProvider->createUploadForm(true, array('album-upload'));
				?>
			</div>
		</div>
		<div class="tab-pane fade" id="nav-beambag" role="tabpanel" aria-labelledby="nav-upBeamBags">
			<div class="py-3">
				<?php
				$formProvider = new MusicDetailsSongFormProvider();
				echo $formProvider->beambagFrm();
				?>
			</div>
		</div>
	</div>
</div>

<div id="errorMsg" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title text-danger">Error</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		</div>
		<div class="modal-body"></div>
	</div>
  </div>
</div>
<div id="sucessMsg" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title text-danger">Upload completed</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		</div>
		<div class="modal-body"></div>
	</div>
  </div>
</div>
<script>
<?php
if( isset($_GET['msg']) ) : ?>
	showMsg('<?php echo $_GET['msg']; ?>');
<?php
endif; ?>
</script>



<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">

	  <div class="modal-body">
		Please wait. This might take a while.
		<img src="assets/images/icons/loading-spinner.gif">
	  </div>

	</div>
  </div>
</div>




<?php require_once("includes/uploadFooter.php"); ?>
