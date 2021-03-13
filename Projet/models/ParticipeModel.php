<?php

class ParticipeModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getActivitesEleve($id) {
        $sql = "SELECT * FROM participe NATURAL JOIN activite WHERE id_eleve = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function ajoutActivite() {
        $eleve = isset($_POST["eleve"]) ? $_POST["eleve"] : null;
        $activite = isset($_POST["activite"]) ? $_POST["activite"] : null;
        if ($eleve && $activite) {
            $sql = "INSERT INTO participe (id_eleve, id_activite) VALUES (?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($eleve, $activite));
            if ($exec) {
                return $eleve;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppActivite() {
        $eleve = isset($_POST["eleve"]) ? $_POST["eleve"] : null;
        $activite = isset($_POST["activite"]) ? $_POST["activite"] : null;
        if ($eleve && $activite) {
            $sql = "DELETE FROM participe WHERE id_eleve = ? AND id_activite = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($eleve, $activite));
            if ($exec) {
                return $eleve;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }


    
}