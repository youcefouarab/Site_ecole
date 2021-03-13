<?php

class Notes extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
    }

    public function eleve($params) {
        if (isset($params[0])) {
            $this->view->render("notes", "Notes", true, array($params[0], "eleve"));
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function classe($params) {
        if (isset($params[0])) {
            $this->view->render("notes", "Notes", true, array($params[0], "classe"));
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getNotesEleve($id, $classe) {
        $this->loadModel("notes");
        $data = $this->model->getNotesEleve($id, $classe);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEleve($id) {
        $this->loadModel("eleve");
        $data = $this->model->getEleve($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }    
    }

    public function getNotesClasse($id, $id_enseignant = null) {
        $this->loadModel("notes");
        $data = $this->model->getNotesClasse($id, $id_enseignant);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEleves($classe) {
        $this->loadModel("eleve");
        $data = $this->model->getElevesClasse($classe);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }
    
    public function getMatieresEns($id, $classe) {
        $this->loadModel("enseigne");
        $data = $this->model->getMatieresEns($id, $classe);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }    
    }

    public function getMatieresClasse($classe) {
        $this->loadModel("enseigne");
        $data = $this->model->getMatieresClasse($classe);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getActivites() {
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if (isset($_POST["from"]) && $id) {
            $this->loadModel("participe");
            $data = $this->model->getActivitesEleve($id);
            if ($data != SERVER_ERROR) echo json_encode($data);
            else echo $data;
        } else {
            echo MISSING_DATA;
        }
    }

    public function checkParent($id_parent, $id_eleve) {
        $this->loadModel("eleve");
        $data = $this->model->checkParent($id_parent, $id_eleve);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function modifNotes() {
        $this->loadModel("notes");
        $req = $this->model->modifNotes();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            if (isset($_POST["from"])) {
                if ($_POST["from"] == "classe") {
                    header("location: ".BASE_URL."notes/classe/".$req[0]);
                } else if ($_POST["from"] == "eleve") {
                    header("location: ".BASE_URL."notes/eleve/".$req[1]);
                }
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
            }
        }
    }

}