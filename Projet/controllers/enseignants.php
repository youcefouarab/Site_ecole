<?php

class Enseignants extends Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("enseignants", "Enseignants");
    } 

    public function cycle($params) {
        if (isset($params[0])) {
            $this->view->render("enseignants", "Enseignants", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getEnseignants() {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignants();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    
    }

    public function getEnseignantsCycle($cycle) {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignantsCycle($cycle);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getReception($id) {
        $this->loadModel("reception");
        $data = $this->model->getReception($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getClasses(){
        $this->loadModel("classe");
        $data = $this->model->getClasses();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getClassesEns($id) {
        $this->loadModel("enseigne");
        $data = $this->model->getClassesEns($id, true);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getMatieres() {
        $this->loadModel("matiere");
        $data = $this->model->getMatieres();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutReception() {
        $this->loadModel("reception");
        $req = $this->model->ajoutReception();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."enseignants");
        }
    }

    public function suppReception() {
        $this->loadModel("reception");
        $req = $this->model->suppReception();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."enseignants");
        }
    }

    public function ajoutClasse() {
        $this->loadModel("enseigne");
        $req = $this->model->ajoutClasse();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."enseignants");
        }
    }

    public function suppClasse() {
        $this->loadModel("enseigne");
        $req = $this->model->suppClasse();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."enseignants");
        }
    }
}