<?php

class FileUploader {
  private $target_dir;
  private $target_file;
  private $download;
  private $imageFileType;
  
  public function __construct($dir) {
    $this->target_dir = $dir;
  }
  
  public function upload($file) {
    $this->target_file = $this->target_dir . basename($file["name"]);
    $this->download = true;
    $this->imageFileType = strtolower(pathinfo($this->target_file, PATHINFO_EXTENSION));
    
    // Controleert of de bestandtype een afbeelding is.
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
      $this->download = false;
      return "Helaas, dit bestand is geen afbeelding.";
    }
    
    // kijkt in de database of file bestand of de bestand al bestaat of niet.
    if (file_exists($this->target_file)) {
      $this->download = false;
      return "Dit bestand bestaat al.";
    }
    
    // Stuk code die de bestand groote checkt.
    if ($file["size"] > 500000) {
      $this->download = false;
      return "Helaas, uw bestand is te groot.";
    }
    
    // Stuk code waar de bestand type gecontroleerd wordt.
    if($this->imageFileType != "jpg" && $this->imageFileType != "png" && $this->imageFileType != "jpeg"
    && $this->imageFileType != "gif" ) {
      $this->download = false;
      return "Helaas, alleen JPG, JPEG, PNG & GIF bestanden kunnen worden geüpload.";
    }
    
    // Stuk code waar de bestand wordt geupload.
    if ($this->download && move_uploaded_file($file["tmp_name"], $this->target_file)) {
      return "Het bestand " . htmlspecialchars(basename($file["name"])) . " is succesvol geüpload.";
    } else {
      return "Er is helaas een fout opgetreden bij het uploaden van uw bestand.";
    }
  }
}

$fileUploader = new FileUploader("uploads/");
$result = $fileUploader->upload($_FILES["fileToUpload"]);
echo $result;
