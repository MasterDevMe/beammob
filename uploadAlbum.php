<?php 
require_once("includes/uploadHeader.php");
require_once("includes/classes/MusicDetailsAlbumFormProvider.php");
?>


<div class="column">
  <div class="uploTitle"><h3> ALBUM UPLOAD <h3> </div>
      <div class="uploadTitle"><h6> <a href="uploadSong.php"> No, I only have one song </a><h6> </div>



    <?php
    $formProvider = new MusicDetailsAlbumFormProvider($con);
    echo $formProvider->createUploadForm();
    ?>

   <br>
<h6> <a href="uploadBeambag.php">I only want to upload a Beambag </a><h6>


</div>

<script>
$("form").submit(function() {
    $("#loadingModal").modal("show");
});
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
                