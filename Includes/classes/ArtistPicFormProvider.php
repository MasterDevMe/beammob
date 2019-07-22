

<?php
class MusicDetailsSongFormProvider {

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createUploadForm() {
        $fileProfilePicInput = $this->createFileProfilePicInput();
        $uploadButton = $this->createUploadButton();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileProfilePicInput
                    $uploadButton
                </form>";
    }




    private function createFileProfilePicInput() {

        return "<div class='form-group'>
                    <label for='exampleFormControlFile1'>Your Profile Picture</label>
                    <input type='file' class='form-control-file' id='exampleFormControlFile1' name='fileInput' required>
                </div>";
    }


    private function createUploadButton() {
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    }
}
?>