<?php

class RestaurationModel extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getRestauration() {
        $sql = "SELECT * FROM restauration";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function modifRestauration() {
        $jour = isset($_POST["jour"]) ? $_POST["jour"] : null;
        if ($jour) {
            $repas = isset($_POST["repas"]) ? nl2br($_POST["repas"]) : "";
            $sql = "UPDATE restauration SET repas = ? WHERE jour = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($repas, $jour));
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