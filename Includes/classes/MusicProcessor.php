<?php
class MusicProcessor {

    private $con;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp3");


    



    public function __construct($con) {
        $this->con = $con;
    }

    public function upload($musicUploadData) {

        $targetDir = "uploads/music/";
        $musicData = $musicUploadData->musicDataArray;
        
        $tempFilePath = $targetDir . uniqid() . "_" . basename($musicData["name"]);
        
        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($musicData, $tempFilePath);

        if(!$isValidData) {
            return false;
        }

        if(move_uploaded_file($musicData["tmp_name"], $tempFilePath)) {
            
            $finalFilePath = $tempFilePath . ".mp3";

            if(!$this->insertMusicData($musicUploadData, $finalFilePath)) {
                echo "Insert query failed";
                return false;
            }

        }
    }

    private function processData($musicData, $filePath) {
        $musicType = pathInfo($filePath, PATHINFO_EXTENSION);
        
        if(!$this->isValidSize($musicData)) {
            echo "File too large. Can't be more than " . $this->sizeLimit . " bytes";
            return false;
        }
        else if(!$this->isValidType($musicType)) {
            echo "Invalid file type";
            return false;
        }
        else if($this->hasError($musicData)) {
            echo "Error code: " . $musicData["error"];
            return false;
        }

        return true;
    }

    private function isValidSize($data) {
        return $data["size"] <= $this->sizeLimit;
    }

    private function isValidType($type) {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }
    
    private function hasError($data) {
        return $data["error"] != 0;
    }

    private function insertMusicData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO music(title, uploadedBy, description, privacy, category, filePath)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }







}
?>