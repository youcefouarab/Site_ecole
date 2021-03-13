<?php

class Eleve extends Controller {

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
            $this->view->render("eleve", "Elève", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getClasses() {
        $this->loadModel("classe");
        $data = $this->model->getClasses();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getParents() {
        $this->loadModel("parent");
        $data = $this->model->getParents();
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

    public function getActivites() {
        $this->loadModel("activite");
        $data = $this->model->getActivites();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getActivitesEleve($id) {
        $this->loadModel("participe");
        $data = $this->model->getActivitesEleve($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutEleve() {
        $this->loadModel("eleve");
        $req = $this->model->ajoutEleve();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function modifEleve() {
        $this->loadModel("eleve");
        $req = $this->model->modifEleve();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function ajoutActivite() {
        $this->loadModel("participe");
        $req = $this->model->ajoutActivite();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."eleve/id/".$req);
        }
    }

    public function suppActivite() {
        $this->loadModel("participe");
        $req = $this->model->suppActivite();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."eleve/id/".$req);
        }
    }



}