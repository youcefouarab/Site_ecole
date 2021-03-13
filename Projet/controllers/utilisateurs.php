<?php

class Utilisateurs extends Controller {

    function __construct() {
        parent::__construct();
        $admin = Session::get("admin");
        if (!$admin) {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function index() {
        $this->view->render("utilisateurs", "Utilisateurs");
    } 

    public function getEleves() {
        $this->loadModel("eleve");
        $data = $this->model->getEleves();
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

    public function getEnseignants() {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignants();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getAdmins() {
        $this->loadModel("admin");
        $data = $this->model->getAdmins();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
        
    }

    public function suppEleve(){
        $this->loadModel("eleve");
        $req = $this->model->suppEleve();
        if ($req == SERVER_ERROR && $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function suppEnseignant(){
        $this->loadModel("enseignant");
        $req = $this->model->suppEnseignant();
        if ($req == SERVER_ERROR && $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function suppParent(){
        $this->loadModel("parent");
        $req = $this->model->suppParent();
        if ($req == SERVER_ERROR && $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function suppAdmin(){
        $this->loadModel("admin");
        $req = $this->model->suppAdmin();
        if ($req == SERVER_ERROR && $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }
    
}