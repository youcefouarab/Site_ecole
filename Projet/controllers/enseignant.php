<?php

class Enseignant extends Controller {
    function __construct() {
        parent::__construct();
        $admin = Session::get("admin");
        if (!$admin) {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function index() {
        header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
    }

    public function id($params) {
        if (isset($params[0])) {
            $this->view->render("enseignant", "Enseignant", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getEnseignant($id) {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignant($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutEnseignant() {
        $this->loadModel("enseignant");
        $req = $this->model->ajoutEnseignant();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function modifEnseignant() {
        $this->loadModel("enseignant");
        $req = $this->model->modifEnseignant();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

}