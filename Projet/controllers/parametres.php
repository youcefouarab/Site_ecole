<?php

class Parametres extends Controller {
    function __construct() {
        parent::__construct();
        $admin = Session::get("admin");
        if (!$admin) {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function index() {
        $this->view->render("parametres", "Paramètres");
    }

    public function getClassesCycle($cycle){
        $this->loadModel("classe");
        $data = $this->model->getClasses($cycle);
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

    public function getActivites() {
        $this->loadModel("activite");
        $data = $this->model->getActivites();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutClasse() {
        $this->loadModel("classe");
        $req = $this->model->ajoutClasse();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

    public function suppClasse() {
        $this->loadModel("classe");
        $req = $this->model->suppClasse();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

    public function ajoutMatiere() {
        $this->loadModel("matiere");
        $req = $this->model->ajoutMatiere();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

    public function suppMatiere() {
        $this->loadModel("matiere");
        $req = $this->model->suppMatiere();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

    public function ajoutActivite() {
        $this->loadModel("activite");
        $req = $this->model->ajoutActivite();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

    public function suppActivite() {
        $this->loadModel("activite");
        $req = $this->model->suppActivite();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

    public function modifSlide() {
        $this->loadModel("diaporama");
        $req = $this->model->modifSlide();
        if ($req == SERVER_ERROR || $req == MISSING_DATA || $req == UNSUPPORTED_TYPE) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."parametres");
        }
    }

}