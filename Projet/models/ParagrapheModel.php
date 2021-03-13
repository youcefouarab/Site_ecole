<?php

class ParagrapheModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getParagraphes() {
        $sql = "SELECT * FROM paragraphe ORDER BY created ASC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function ajoutParagraphe() {
        $texte = isset($_POST["texte"]) ? nl2br($_POST["texte"]) : null;
        if ($texte) {
            $sql = "INSERT INTO paragraphe (texte, `image`) VALUES (?, '')";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($texte));
            if ($exec) {
                $id = $this->db->lastInsertId();
                $name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
                if ($name) {
                    $_POST["id"] = $id;
                    $_POST["submit"] = "submit";
                    $req = $this->modifImage();
                    return $req;
                } else {
                    return $id;
                }
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function modifTexte() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $texte = isset($_POST["texte"]) ? nl2br($_POST["texte"]) : null;
        if ($id && $texte) {
            $sql = "UPDATE paragraphe SET texte = ? WHERE id_paragraphe = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($texte, $id));
            if ($exec) {
                return $id;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function modifImage() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if (isset($_POST["submit"]) && $id) {
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/".PROJECT_NAME.PUBLIC_CNT."img/";
            $name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
            if ($name) {     
                $temp_name  = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : null; 
                if ($temp_name) {
                    $imageFileType = strtolower(pathinfo(basename($name),PATHINFO_EXTENSION));
                    $new_name = time().".".$imageFileType;
                    $target_file = $target_dir.$new_name;
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return UNSUPPORTED_TYPE;
                    }
                    if (move_uploaded_file($temp_name, $target_file)) {
                        $sql = "SELECT `image` FROM paragraphe WHERE id_paragraphe = ?";
                        $query = $this->db->prepare($sql);
                        $exec = $query->execute(array($id));
                        $data = $exec ? $query->fetch() : null;
                        if ($data) {
                            if ($data["image"] != "default.png") unlink($target_dir.$data["image"]);
                        }
                        $sql = "UPDATE paragraphe SET `image` = ? WHERE id_paragraphe = ?";
                        $query = $this->db->prepare($sql);
                        $exec = $query->execute(array($new_name, $id));
                        if ($exec) {
                            return $id;
                        } else {
                            return SERVER_ERROR;
                        }
                    } else {
                        return SERVER_ERROR;
                    }    
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

    public function suppImage() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "SELECT `image` FROM paragraphe WHERE id_paragraphe = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $data = $exec ? $query->fetch() : null;
            if ($data) {
                $target_dir = $_SERVER['DOCUMENT_ROOT']."/".PROJECT_NAME.PUBLIC_CNT."img/";
                if ($data["image"] != "default.png") unlink($target_dir.$data["image"]);
            }
            $sql = "UPDATE paragraphe SET `image` = '' WHERE id_paragraphe = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            if ($exec) {
                return $id;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppParagraphe() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "SELECT `image` FROM paragraphe WHERE id_paragraphe = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $data = $exec ? $query->fetch() : null;
            if ($data) {
                $target_dir = $_SERVER['DOCUMENT_ROOT']."/".PROJECT_NAME.PUBLIC_CNT."img/";
                if ($data["image"] != "default.png") unlink($target_dir.$data["image"]);
            }
            $sql = "DELETE FROM paragraphe WHERE id_paragraphe = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            if ($exec) {
                return $id;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

}