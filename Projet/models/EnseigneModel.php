<?php

class EnseigneModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getMatieresEns($id, $classe = NULL) {
        $array = array($id);
        if ($classe) {
            $sql = "SELECT DISTINCT id_matiere, nom FROM enseigne NATURAL JOIN matiere WHERE id_enseignant = ? AND id_classe = ?";
            $array = array($id, $classe);
        } else {
            $sql = "SELECT DISTINCT id_matiere, nom FROM enseigne NATURAL JOIN matiere WHERE id_enseignant = ?";
            $array = array($id);
        }
        $query = $this->db->prepare($sql);
        $exec = $query->execute($array);
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getEnsMatiere($id, $classe = NULL) {
        $array = array($id);
        if ($classe) {
            $sql = "SELECT DISTINCT id_enseignant, nom, prenom FROM enseigne NATURAL JOIN enseignant NATURAL JOIN utilisateur WHERE id_matiere = ? AND id_classe = ?";
            $array = array($id, $classe);
        } else {
            $sql = "SELECT DISTINCT id_enseignant, nom, prenom FROM enseigne NATURAL JOIN enseignant NATURAL JOIN utilisateur WHERE id_matiere = ?";
            $array = array($id);
        }
        $query = $this->db->prepare($sql);
        $exec = $query->execute($array);
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getClassesEns($id, $all = null) {
        $sql = "SELECT DISTINCT id_classe FROM enseigne NATURAL JOIN classe NATURAL JOIN matiere WHERE id_enseignant = ?";
        if ($all) {
            $sql = "SELECT DISTINCT id_classe, annee, cycle, id_matiere, nom FROM enseigne NATURAL JOIN classe NATURAL JOIN matiere WHERE id_enseignant = ?";             
        }
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getMatieresClasse($classe) {
        $sql = "SELECT DISTINCT id_matiere, id_classe, nom FROM enseigne NATURAL JOIN matiere WHERE enseigne.id_classe = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($classe));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function ajoutClasse() {
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        $matiere = isset($_POST["matiere"]) ? $_POST["matiere"] : null;
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        if ($ens && $classe && $matiere) {
            $sql = "INSERT INTO enseigne (id_enseignant, id_classe, id_matiere) VALUES (?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($ens, $classe, $matiere));
            if ($exec) {
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppClasse() {
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        $matiere = isset($_POST["matiere"]) ? $_POST["matiere"] : null;
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        if ($ens && $classe && $matiere) {
            $sql = "DELETE FROM enseigne WHERE id_enseignant = ? AND id_classe = ? AND id_matiere = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($ens, $classe, $matiere));
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