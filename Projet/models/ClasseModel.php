<?php

class ClasseModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getClasses($cycle = null) {
        $sql = "SELECT * FROM classe ";
        if ($cycle != null) {
            $sql = $sql . "WHERE cycle = ? ";
        }
        $sql = $sql . "ORDER BY annee ASC, id_classe ASC";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($cycle));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function ajoutClasse() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $cycle = isset($_POST["cycle"]) ? $_POST["cycle"] : null;
        $annee = isset($_POST["annee"]) ? $_POST["annee"] : null;
        if ($id && $cycle && $annee) {
            $sql = "INSERT INTO classe (id_classe, annee, cycle) VALUES (?, ?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id, $annee, $cycle));
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
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "DELETE FROM classe WHERE id_classe = ?";
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