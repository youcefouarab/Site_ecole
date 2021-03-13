<?php

class EleveModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getEleves() {
        $sql = "SELECT * FROM eleve NATURAL JOIN utilisateur ORDER BY nom";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;

    }

    public function getElevesParent($id) {
        $sql = "SELECT * FROM eleve NATURAL JOIN utilisateur NATURAL JOIN classe WHERE id_parent = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function checkParent($id_parent, $id_eleve) {
        $sql = "SELECT * FROM eleve WHERE id_parent = ? AND id_eleve = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id_parent, $id_eleve));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;
    }

    public function getElevesClasse($classe) {
        $sql = "SELECT * FROM eleve NATURAL JOIN utilisateur WHERE id_classe = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($classe));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getEleve($id) {
        $sql = "SELECT * FROM eleve NATURAL JOIN utilisateur NATURAL JOIN classe WHERE id_eleve = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;

    }

    public function getEleveLogin($login) {
        $sql = "SELECT * FROM eleve NATURAL JOIN utilisateur WHERE `login` = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($login));
        $data = $exec ? $query->fetch() : SERVER_ERROR;
        return $data;
    }

    private function generateID($u, $uid) {
        return $u.date("y")."_".$uid;
    }
    
    public function ajoutEleve() {
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $date_n = isset($_POST["date_n"]) ? $_POST["date_n"] : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        if ($nom && $prenom && $date_n && $adresse && $classe) {
            $login = strtolower("e".$prenom[0]."_".$nom);
            $password = strtolower($prenom);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO utilisateur (`login`, `password`, nom, prenom, adresse, tel1, tel2, tel3, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($login, $hash, $nom, $prenom, $adresse, $tel1, $tel2, $tel3, $email));
            if ($exec) {
                $euser_id = $this->db->lastInsertId();
                $id = $this->generateID("e", $euser_id);
                $id_parent = null;
                if (!isset($_POST["id_parent"])) {
                    $nom_p = isset($_POST["nom_p"]) ? str_replace(" ", "_", $_POST["nom_p"]) : null;
                    $prenom_p = isset($_POST["prenom_p"]) ? str_replace(" ", "_", $_POST["prenom_p"]) : null;
                    $date_n_p = isset($_POST["date_n_p"]) ? $_POST["date_n_p"] : null;
                    $adresse_p = isset($_POST["adresse_p"]) ? $_POST["adresse_p"] : null;
                    $tel1_p = isset($_POST["tel1_p"]) ? $_POST["tel1_p"] : null;
                    $tel2_p = isset($_POST["tel2_p"]) ? $_POST["tel2_p"] : null;
                    $tel3_p = isset($_POST["tel3_p"]) ? $_POST["tel3_p"] : null;
                    $email_p = isset($_POST["email_p"]) ? $_POST["email_p"] : null;
                    if ($nom_p && $prenom_p && $date_n_p && $adresse_p) {
                        $login_p = strtolower("p".$prenom_p[0]."_".$nom_p);
                        $password_p = strtolower($prenom_p);
                        $hash_p = password_hash($password_p, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO utilisateur (`login`, `password`, nom, prenom, adresse, tel1, tel2, tel3, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $query = $this->db->prepare($sql);
                        $exec = $query->execute(array($login_p, $hash_p, $nom_p, $prenom_p, $adresse_p, $tel1_p, $tel2_p, $tel3_p, $email_p));
                        if ($exec) {
                            $puser_id = $this->db->lastInsertId();
                            $id_p = $this->generateID("p", $puser_id);
                            $sql = "INSERT INTO parent (id_parent, date_naissance, id_utilisateur) VALUES (?, ?, ?)";
                            $query = $this->db->prepare($sql);
                            $exec = $query->execute(array($id_p, $date_n_p, $puser_id));
                            if ($exec) {
                                $id_parent = $id_p;
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
                    $id_parent = $_POST["id_parent"];
                }
                $sql = "INSERT INTO eleve (id_eleve, date_naissance, id_classe, id_parent, id_utilisateur) VALUES (?, ?, ?, ?, ?)";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($id, $date_n, $classe, $id_parent, $euser_id));
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

    public function modifEleve() {
        $id_utilisateur = isset($_POST["id_utilisateur"]) ? $_POST["id_utilisateur"] : null;
        $id_eleve = isset($_POST["id_eleve"]) ? $_POST["id_eleve"] : null;
        $nom = isset($_POST["nom"]) ? str_replace(" ", "_", $_POST["nom"]) : null;
        $prenom = isset($_POST["prenom"]) ? str_replace(" ", "_", $_POST["prenom"]) : null;
        $date_n = isset($_POST["date_n"]) ? $_POST["date_n"] : null;
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : null;
        $tel1 = isset($_POST["tel1"]) ? $_POST["tel1"] : null;
        $tel2 = isset($_POST["tel2"]) ? $_POST["tel2"] : null;
        $tel3 = isset($_POST["tel3"]) ? $_POST["tel3"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        $id_parent = isset($_POST["id_parent"]) ? $_POST["id_parent"] : null;
        if ($id_utilisateur && $id_eleve && $nom && $prenom && $date_n && $adresse && $classe && $id_parent) {
            $exec = null;
            if (isset($_POST["reinit"]) && $_POST["reinit"] == "true") {
                $login = strtolower("e".$prenom[0]."_".$nom);
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
                $sql = "UPDATE eleve SET date_naissance = ?, id_classe = ?, id_parent = ? WHERE id_eleve = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($date_n, $classe, $id_parent, $id_eleve));
                if ($exec) {
                    return $id_eleve;
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

    public function suppEleve(){
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "SELECT id_utilisateur FROM eleve WHERE id_eleve = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $uid = $exec ? $query->fetch() : null;
            if ($uid) {
                $sql = "DELETE FROM eleve WHERE id_eleve = ?";
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