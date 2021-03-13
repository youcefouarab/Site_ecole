<?php

class EmploiModel extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getEmploi($classe) {
        $sql = "SELECT * FROM emploi WHERE id_classe = ? ORDER BY periode ASC, jour ASC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($classe));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getEmploiEns($id) {
        $sql = "SELECT * FROM emploi WHERE id_enseignant = ? ORDER BY periode ASC, jour ASC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function addEmploi() {
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        $jour = isset($_POST["jour"]) ? $_POST["jour"] : null;
        $periode = isset($_POST["periode"]) ? $_POST["periode"] : null;
        $matiere = isset($_POST["matiere"]) ? $_POST["matiere"] : null;
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        $debut = isset($_POST["debut"]) ? $_POST["debut"] : null;
        $fin = isset($_POST["fin"]) ? $_POST["fin"] : null;
        $salle = isset($_POST["salle"]) ? $_POST["salle"] : null;
        if ($classe && $jour && $periode && $matiere && $ens && $debut && $fin && $salle) {
            $sql = "INSERT INTO emploi(id_classe, jour, periode, id_matiere, id_enseignant, debut, fin, salle) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($classe, $jour, $periode, $matiere, $ens, $debut, $fin, $salle));
            if ($exec) {
                return array($classe, $ens);
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
        
    }

    public function modifEmploi() {
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        $jour = isset($_POST["jour"]) ? $_POST["jour"] : null;
        $periode = isset($_POST["periode"]) ? $_POST["periode"] : null;
        $matiere = isset($_POST["matiere"]) ? $_POST["matiere"] : null;
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        $debut = isset($_POST["debut"]) ? $_POST["debut"] : null;
        $fin = isset($_POST["fin"]) ? $_POST["fin"] : null;
        $salle = isset($_POST["salle"]) ? $_POST["salle"] : null;
        if ($classe && $jour && $periode && $matiere && $ens && $debut && $fin && $salle) {
            $sql = "UPDATE emploi SET id_matiere = ?, id_enseignant = ?, debut = ?, fin = ?, salle = ? WHERE id_classe = ? AND jour = ? AND periode = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($matiere, $ens, $debut, $fin, $salle, $classe, $jour, $periode));
            if ($exec) {
                return array($classe, $ens);
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppEmploi() {
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        $jour = isset($_POST["jour"]) ? $_POST["jour"] : null;
        $periode = isset($_POST["periode"]) ? $_POST["periode"] : null;
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        if ($classe && $jour && $periode) {
            $sql = "DELETE FROM emploi WHERE id_classe = ? AND jour = ? AND periode = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($classe, $jour, $periode));
            if ($exec) {
                return array($classe, $ens);
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }

    }

}