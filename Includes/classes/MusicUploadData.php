<?php
class MusicUploadData {

    public $musicDataArray, $title, $description, $privacy, $category, $uploadedBy;

    public function __construct($musicDataArray, $title, $description, $privacy, $category, $uploadedBy) {
        $this->musicDataArray = $musicDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->privacy = $privacy;
        $this->category = $category;
        $this->uploadedBy = $uploadedBy;
    }

}
?>