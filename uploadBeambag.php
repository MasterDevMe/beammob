<?php 
require_once("includes/uploadHeader.php");
require_once("includes/classes/BeambagFormProvider.php");
?>


<div class="column">
  <div class="uploTitle"><h3> UPLOAD YOUR BEAMBAG<h3> </div>
    <div class="uploTitle"><h6> <a href="uploadSong.php">Take me back to upload my music</a><h6> </div>

    <?php
    $formProvider = new MusicDetailsSongFormProvider($con);
    echo $formProvider->createUploadForm();
    ?>


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
                