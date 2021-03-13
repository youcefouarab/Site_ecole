<?php 

class utilisateurModel extends Model {
    function __construct() {
        parent::__construct();
    }

    public function modifMdp() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $old_pass = isset($_POST["old_pass"]) ? $_POST["old_pass"] : null;
        $new_pass = isset($_POST["new_pass"]) ? $_POST["new_pass"] : null;
        if ($old_pass && $new_pass) {
            $sql = "SELECT `password` FROM `utilisateur` WHERE id_utilisateur = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($id));
            $data = $exec ? $query->fetch() : null;
            if ($data) {
                if (password_verify($old_pass, $data["password"])) {
                    $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                    $sql = "UPDATE `utilisateur` SET `password` = ? WHERE id_utilisateur = ?";
                    $query = $this->db->prepare($sql);
                    $exec = $query->execute(array($hash, $id)); 
                    if ($exec) {
                        return 1;
                    } else {
                        return SERVER_ERROR;
                    }
                } else {
                    return WRONG_PASS;
                }
            } else {
                return SERVER_ERROR;
            }     
        } else {
            return MISSING_DATA;
        }
    }


}