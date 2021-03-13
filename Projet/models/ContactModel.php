<?php

class ContactModel extends Model {

    function __construct() {
        parent::__construct();
    }

    
    public function getContacts() {
        $sql = "SELECT * FROM contact";
        $query = $this->db->prepare($sql);
        $exec = $query->execute();
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;

    }

    public function ajoutContact() {
        $cle = isset($_POST["cle"]) ? $_POST["cle"] : null;
        $val = isset($_POST["val"]) ? $_POST["val"] : null;
        if ($cle && $val) {
            $sql = "INSERT INTO contact (cle, valeur) VALUES (?, ?)";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($cle, $val));
            if ($exec) {
                return 1;
            } else {
                return SERVER_ERROR;
            }
        } else {
            return MISSING_DATA;
        }
    }

    public function suppContact() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if ($id) {
            $sql = "DELETE FROM contact WHERE id_contact = ?";
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