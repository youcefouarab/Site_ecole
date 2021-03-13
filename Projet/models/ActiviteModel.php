<?php

class ActiviteModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getActivites() {
        $sql = "SELECT * FROM activite ORDER BY id_activite ASC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function ajoutActivite() {
        $nom = isset($_POST["nom"]) ? $_POST["nom"] : null;
        if ($nom) {
            $sql = "INSERT INTO activite (activite) VALUES (?)";
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

    public function suppActivite() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "DELETE FROM activite WHERE id_activite = ?";
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