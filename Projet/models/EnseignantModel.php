<?php

class EnseignantModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getEnseignants() {
        $sql = "SELECT * FROM enseignant NATURAL JOIN utilisateur ORDER BY nom";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
        
    }

    public function getEnseignantsCycle($cycle) {
        $sql = "SELECT DISTINCT id_enseignant, nom, prenom FROM enseignant NATURAL JOIN utilisateur NATURAL JOIN enseigne NATURAL JOIN classe WHERE classe.cycle = ? ORDER BY nom";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($cycle));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
        
    }

    public function getEnseignant($id) {
        $sql = "SELECT * FROM enseignant NATURAL JOIN utilisateur WHERE id_enseignant = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;

    }

    public function getEnseignantLogin($login) {
        $sql = "SELECT * FROM enseignant NATURAL JOIN utilisateur WHERE `login` = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($login));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;
    }

    private function generateID($uid) {
        return "s".date("y")."_".$uid;
    }
    
    public function ajoutEnseignant() {
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        if ($nom && $prenom && $adresse) {
            $login = strtolower("s".$prenom[0]."_".$nom);
            $password = strtolower($prenom);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO utilisateur (`login`, `password`, nom, prenom, adresse, tel1, tel2, tel3, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($login, $hash, $nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email));
            if ($exec) {
                $user_id = $this->db->lastInsertId();
                $id = $this->generateID($user_id);
                $sql = "INSERT INTO enseignant (id_enseignant, id_utilisateur) VALUES (?, ?)";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($id, $user_id));
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

    public function modifEnseignant() {
        $id_utilisateur = isset($_POST["id_utilisateur"]) ? $_POST["id_utilisateur"] : null;
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        if ($id_utilisateur && $nom && $prenom && $adresse) {
            $exec = false;
            if (isset($_POST["reinit"]) && $_POST["reinit"] == "true") {
                $login = strtolower("s".$prenom[0]."_".$nom);
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
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }



    public function suppEnseignant(){
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "SELECT id_utilisateur FROM enseignant WHERE id_enseignant = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $uid = $exec ? $query->fetch() : null;
            if ($uid) {
                $sql = "DELETE FROM enseignant WHERE id_enseignant = ?";
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