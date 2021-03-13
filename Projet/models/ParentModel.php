<?php

class ParentModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getParents() {
        $sql = "SELECT * FROM parent NATURAL JOIN utilisateur ORDER BY nom";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
        
    }

    public function getParent($id) {
        $sql = "SELECT * FROM parent NATURAL JOIN utilisateur WHERE id_parent = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;

    }

    public function getParentLogin($login) {
        $sql = "SELECT * FROM parent NATURAL JOIN utilisateur WHERE `login` = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($login));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;
    }

    private function generateID($uid) {
        return "p".date("y")."_".$uid;
    }
    
    public function ajoutParent() {
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $date_n = isset($_POST["date_n"]) ? $_POST["date_n"] : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        if ($nom && $prenom && $date_n && $adresse) {
            $login = strtolower("p".$prenom[0]."_".$nom);
            $password = strtolower($prenom);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO utilisateur (`login`, `password`, nom, prenom, adresse, tel1, tel2, tel3, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($login, $hash, $nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email));
            if ($exec) {
                $user_id = $this->db->lastInsertId();
                $id = $this->generateID($user_id);
                $sql = "INSERT INTO parent (id_parent, date_naissance, id_utilisateur) VALUES (?, ?, ?)";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($id, $date_n, $user_id));
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

    }

    public function modifParent() {
        $id_utilisateur = isset($_POST["id_utilisateur"]) ? $_POST["id_utilisateur"] : null;
        $id_parent = isset($_POST["id_parent"]) ? $_POST["id_parent"] : null;
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $date_n = isset($_POST["date_n"]) ? $_POST["date_n"] : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        if ($id_utilisateur && $id_parent && $nom && $prenom && $date_n && $adresse) {
            $exec = false;
            if (isset($_POST["reinit"]) && $_POST["reinit"] == "true") {
                $login = strtolower("p".$prenom[0]."_".$nom);
                $password = strtolower($prenom);
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE utilisateur SET `login` = ?, `password` = ?, nom = ?, prenom = ?, adresse = ?, tel1 = ?, tel2 = ?, tel3 = ?, email = ? WHERE id_utilisateur = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($login, $hash, $nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email, $id_utilisateur));
            } else {
                $sql = "UPDATE utilisateur SET nom = ?, prenom = ?, adresse = ?, tel1 = ?, tel2 = ?, tel3 = ?, email = ? WHERE id_utilisateur = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email, $id_utilisateur));
            }
            if ($exec) {
                $sql = "UPDATE parent SET date_naissance = ? WHERE id_parent = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($date_n, $id_parent));
                if ($exec) {
                    return $id_parent;
                } else {
                    return SERVER_ERROR;
                }
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }



    public function suppParent(){
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "SELECT id_utilisateur FROM parent WHERE id_parent = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $uid = $exec ? $query->fetch() : null;
            if ($uid) {
                $sql = "DELETE FROM parent WHERE id_parent = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($id));
                if ($exec) {
                    $sql = "DELETE FROM utilisateur WHERE id_utilisateur = ?";
                    $query = $this->db->prepare($sql);
                    $exec = $query->execute(array($uid["id_utilisateur"]));
                    if ($exec) {
                        return 1;
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
    }
    
}