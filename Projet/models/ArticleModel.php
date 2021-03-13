<?php

class ArticleModel extends Model {
    
    function __construct() {
        parent::__construct();
    }

    public function getArticles($interests = null) {
        $sql = "SELECT * FROM article ";
        if ($interests != null) {
            $sql = $sql . "WHERE 1 ";
            if (isset($interests["parents"])) $sql = $sql . "AND parents = 1 ";
            if (isset($interests["primaires"])) $sql = $sql . "AND primaires = 1 ";
            if (isset($interests["moyens"])) $sql = $sql . "AND moyens = 1 ";
            if (isset($interests["secondaires"])) $sql = $sql . "AND secondaires = 1 ";
            if (isset($interests["eleves"])) $sql = $sql . "AND (primaires = 1 OR moyens = 1 OR secondaires = 1) ";
            if (isset($interests["enseignants"])) $sql = $sql . "AND enseignants = 1 ";
        }
        $sql = $sql . "ORDER BY created DESC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getArticle($id) {
        $sql = "SELECT * FROM article WHERE id_article = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
	    $data = $query ? $query->fetch() : SERVER_ERROR;
        return $data;
    }

    public function ajoutArticle() {
        $titre = isset($_POST["titre"]) ? $_POST["titre"] : null;
        $desc = isset($_POST["desc"]) ? nl2br($_POST["desc"]) : null;
        $parents = isset($_POST["parents"]) ? $_POST["parents"] == "true" : null;
        $primaires = isset($_POST["primaires"]) ? $_POST["primaires"] == "true" : null;
        $moyens = isset($_POST["moyens"]) ? $_POST["moyens"] == "true" : null;
        $secondaires = isset($_POST["secondaires"]) ? $_POST["secondaires"] == "true" : null;
        $enseignants = isset($_POST["enseignants"]) ? $_POST["enseignants"] == "true" : null;
        if ($titre && $desc) {
            $sql = "INSERT INTO article (titre, `image`, `description`, parents, primaires, moyens, secondaires, enseignants) VALUES (?, 'default.png', ?, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($titre, $desc, $parents, $primaires, $moyens, $secondaires, $enseignants));
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

    public function suppArticle() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "SELECT `image` FROM article WHERE id_article = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $data = $exec ? $query->fetch() : null;
            if ($data) {
                $target_dir = $_SERVER['DOCUMENT_ROOT']."/".PROJECT_NAME.PUBLIC_CNT."img/";
                if ($data["image"] != "default.png") unlink($target_dir.$data["image"]);
            }
            $sql = "DELETE FROM article WHERE id_article = ?";
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

    public function modifTitre() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $titre = isset($_POST["titre"]) ? $_POST["titre"] : null;
        if ($id && $titre) {
            $sql = "UPDATE article SET titre = ? WHERE id_article = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($titre, $id));
            if ($exec) {
                return $id;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }
    
    public function modifDesc() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $desc = isset($_POST["desc"]) ? nl2br($_POST["desc"]) : null; 
        if ($id && $desc) {
            $sql = "UPDATE article SET `description` = ? WHERE id_article = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($desc, $id));
            if ($exec) {
                return $id;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }

    public function modifInterests() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $parents = isset($_POST["parents"]) ? $_POST["parents"] == "true" : null;
        $primaires = isset($_POST["primaires"]) ? $_POST["primaires"] == "true" : null;
        $moyens = isset($_POST["moyens"]) ? $_POST["moyens"] == "true" : null;
        $secondaires = isset($_POST["secondaires"]) ? $_POST["secondaires"] == "true" : null;
        $enseignants = isset($_POST["enseignants"]) ? $_POST["enseignants"] == "true" : null;
        if ($id) {
            $sql = "UPDATE article SET parents = ?, primaires = ?, moyens = ?, secondaires = ?, enseignants = ? WHERE id_article = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($parents, $primaires, $moyens, $secondaires, $enseignants, $id));
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
            if (!$name) {
                $sql = "SELECT `image` FROM article WHERE id_article = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($id));
                $data = $exec ? $query->fetch() : null;
                if ($data) {
                    if ($data["image"] != "default.png") unlink($target_dir.$data["image"]);
                }
                $sql = "UPDATE article SET `image` = 'default.png' WHERE id_article = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($id));
                if ($exec) {
                    return $id;
                } else {
                    return SERVER_ERROR;
                }
            }
            $temp_name  = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : null; 
            if ($temp_name) {
                $imageFileType = strtolower(pathinfo(basename($name),PATHINFO_EXTENSION));
                $new_name = time().".".$imageFileType;
                $target_file = $target_dir.$new_name;
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return UNSUPPORTED_TYPE;
                }
                if (move_uploaded_file($temp_name, $target_file)) {
                    $id = $_POST["id"];
                    $sql = "SELECT `image` FROM article WHERE id_article = ?";
                    $query = $this->db->prepare($sql);
                    $exec = $query->execute(array($id));
                    $data = $exec ? $query->fetch() : null;
                    if ($data) {
                        if ($data["image"] != "default.png") unlink($target_dir.$data["image"]);
                    }
                    $sql = "UPDATE article SET `image` = ? WHERE id_article = ?";
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
                return MISSING_DATA;
            }
        } else {
            return MISSING_DATA;
        }
    }
}