<?php

class DiaporamaModel extends Model {
    
    function __construct() {
        parent::__construct();
    }

    public function modifSlide() {
        $id = isset($_POST["num"]) ? $_POST["num"] : null;
        if (isset($_POST["submit"]) && $id) {
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/".PROJECT_NAME.PUBLIC_CNT."img/";
            $name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
            $temp_name  = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : null; 
            if ($name && $temp_name) {
                $imageFileType = strtolower(pathinfo(basename($name),PATHINFO_EXTENSION));
                $target_file = $target_dir."slide".$id.".png";
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return UNSUPPORTED_TYPE;
                }
                if (move_uploaded_file($temp_name, $target_file)) {
                    return 1;
                } else {
                    return SERVER_ERROR;
                }
            } else {
                return MISSING_DATA;
            }
        } else {
            return MISSING_DATA;
        }
    }
}