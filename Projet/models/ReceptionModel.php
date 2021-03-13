<?php

class ReceptionModel extends Model {

    function __construct() {
        parent::__construct();
    }

    
    public function getReception($id) {
        $sql = "SELECT * FROM reception WHERE id_enseignant = ? ORDER BY jour, debut";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;

    }

    public function ajoutReception() {
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        $jour = isset($_POST["jour"]) ? $_POST["jour"] : null;
        $debut = isset($_POST["debut"]) ? $_POST["debut"] : null;
        $fin = isset($_POST["fin"]) ? $_POST["fin"] : null;
        if ($ens && $jour && $debut && $fin) {
            $sql = "INSERT INTO reception (id_enseignant, jour, debut, fin) VALUES (?, ?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($ens, $jour, $debut, $fin));
            if ($exec) {
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppReception() {
        $ens = isset($_POST["ens"]) ? $_POST["ens"] : null;
        $jour = isset($_POST["jour"]) ? $_POST["jour"] : null;
        $debut = isset($_POST["debut"]) ? $_POST["debut"] : null;
        if ($ens && $jour && $debut) {
            $sql = "DELETE FROM reception WHERE id_enseignant = ? AND jour = ? AND debut = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($ens, $jour, $debut));
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