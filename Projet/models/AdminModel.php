<?php

class AdminModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getAdmins() {
        $sql = "SELECT * FROM `admin` ORDER BY nom";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
        
    }

    public function getAdmin($id) {
        $sql = "SELECT * FROM `admin` WHERE id_admin = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;

    }

    public function getAdminLogin($login) {
        $sql = "SELECT * FROM `admin` WHERE `login` = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($login));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;
    }
    
    public function ajoutAdmin() {
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        if ($nom && $prenom && $adresse) {
            $login = strtolower("a".$prenom[0]."_".$nom);
            $password = strtolower($prenom);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `admin` (`login`, `password`, nom, prenom, adresse, tel1, tel2, tel3, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($login, $hash, $nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email));
            if ($exec) {
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }

    public function modifAdmin() {
        $id_admin = isset($_POST["id_admin"]) ? $_POST["id_admin"] : null;
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        if ($id_admin && $nom && $prenom && $adresse) {
            $exec = false;
            if (isset($_POST["reinit"]) && $_POST["reinit"] == "true") {
                $login = strtolower("a".$prenom[0]."_".$nom);
                $password = strtolower($prenom);
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE `admin` SET `login` = ?, `password` = ?, nom = ?, prenom = ?, adresse = ?, tel1 = ?, tel2 = ?, tel3 = ?, email = ? WHERE id_admin = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($login, $hash, $nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email, $id_admin));
            } else {
                $sql = "UPDATE `admin` SET nom = ?, prenom = ?, adresse = ?, tel1 = ?, tel2 = ?, tel3 = ?, email = ? WHERE id_admin = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email, $id_admin));
            }
            if ($exec) {
                if (isset($_POST["old_pass"])) {
                    $old_pass = isset($_POST["old_pass"]) ? $_POST["old_pass"] : null;
                    $new_pass = isset($_POST["new_pass"]) ? $_POST["new_pass"] : null;
                    if ($old_pass && $new_pass) {
                        $sql = "SELECT `password` FROM `admin` WHERE id_admin = ?";
                        $query = $this->db->prepare($sql);
                        $exec = $query->execute(array($id_admin));
                        $data = $exec ? $query->fetch() : null;
                        if ($data) {
                            if (password_verify($old_pass, $data["password"])) {
                                $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                                $sql = "UPDATE `admin` SET `password` = ? WHERE id_admin = ?";
                                $query = $this->db->prepare($sql);
                                $exec = $query->execute(array($hash, $id_admin)); 
                                if ($exec) {
                                    return 1;
                                } else {
                                    return SERVER_ERROR;
                                }
                            } else {
                                return WRONG_PASS;
                            }
                        } else {
                            return SERVER_ERROR;
                        }     
                    } else {
                        return MISSING_DATA;
                    }
                } else {
                    return 1;
                }
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }

    public function suppAdmin(){
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "DELETE FROM `admin` WHERE id_admin = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            if ($exec) {
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    
}