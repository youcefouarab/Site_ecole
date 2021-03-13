<?php

class NotesModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getNotesEleve($id, $classe) {
        $sql = "SELECT * FROM notes NATURAL JOIN matiere WHERE notes.id_eleve = ? AND notes.id_classe = ?";
        $query = $this->db->prepare($sql);
        $exec = $query->execute(array($id, $classe));
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function getNotesClasse($id, $id_enseignant = null) {
        $array = array($id_enseignant, $id);
        if ($id_enseignant) {
            $sql = "SELECT * FROM notes NATURAL JOIN eleve NATURAL JOIN utilisateur NATURAL JOIN (SELECT id_matiere, nom AS nom_matiere FROM matiere) matieres NATURAL JOIN enseigne WHERE enseigne.id_enseignant = ? AND notes.id_classe = ?";
        } else {
            $sql = "SELECT * FROM notes NATURAL JOIN eleve NATURAL JOIN utilisateur NATURAL JOIN (SELECT id_matiere, nom AS nom_matiere FROM matiere) matieres WHERE notes.id_classe = ?";
            $array = array($id);
        }
        $query = $this->db->prepare($sql);
        $exec = $query->execute($array);
        $data = $exec ? $query->fetchAll() : SERVER_ERROR;
        return $data;
    }

    public function modifNotes() {
        $eleve = isset($_POST["eleve"]) ? $_POST["eleve"] : null;
        $classe = isset($_POST["classe"]) ? $_POST["classe"] : null;
        $matiere = isset($_POST["matiere"]) ? $_POST["matiere"] : null;
        $trim = isset($_POST["trim"]) ? $_POST["trim"] : null;
        $cont = isset($_POST["cont"]) ? $_POST["cont"] : null;
        $dev = isset($_POST["dev"]) ? $_POST["dev"] : null;
        $exam = isset($_POST["exam"]) ? $_POST["exam"] : null;
        $moy = isset($_POST["moy"]) ? $_POST["moy"] : null;
        $rque = isset($_POST["rque"]) ? $_POST["rque"] : null;
        if ($eleve && $classe && $matiere && $trim) {
            $sql = "SELECT * FROM notes WHERE id_eleve = ? AND id_classe = ? AND id_matiere = ? AND trimestre = ?";
            $query = $this->db->prepare($sql);
            $exec = $query->execute(array($eleve, $classe, $matiere, $trim));
            $data = $exec ? $query->fetch() : null;
            if ($data) {
                $sql = "UPDATE notes SET continu = ?, devoir = ?, examen = ?, moyenne = ?, remarque = ? WHERE id_eleve = ? AND id_classe = ? AND id_matiere = ? AND trimestre = ?";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($cont, $dev, $exam, $moy, $rque, $eleve, $classe, $matiere, $trim));
                if ($exec) {
                    return array($classe, $eleve);
                } else {
                    return SERVER_ERROR;
                }
            } else {
                $sql = "INSERT INTO notes (continu, devoir, examen, moyenne, remarque, id_eleve, id_classe, id_matiere, trimestre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $query = $this->db->prepare($sql);
                $exec = $query->execute(array($cont, $dev, $exam, $moy, $rque, $eleve, $classe, $matiere, $trim));
                if ($exec) {
                    return array($classe, $eleve);
                } else {
                    return SERVER_ERROR;
                }
            }
        } else {
            return MISSING_DATA;
        }
    }

}