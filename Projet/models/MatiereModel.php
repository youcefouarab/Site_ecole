<?php

class MatiereModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getMatieres() {
        $sql = "SELECT * FROM matiere ORDER BY id_matiere ASC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function ajoutMatiere() {
        $nom = isset($_POST["nom"]) ? $_POST["nom"] : null;
        if ($nom) {
            $sql = "INSERT INTO matiere (nom) VALUES (?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($nom));
            if ($exec) {
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppMatiere() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "DELETE FROM matiere WHERE id_matiere = ?";
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