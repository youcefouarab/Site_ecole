<?php

class Presentation extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("presentation", "Présentation de l'école");
    } 

    public function getParagraphes() {
        $this->loadModel("paragraphe");
        $data = $this->model->getParagraphes();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutParagraphe() {
        $this->loadModel("paragraphe");
        $req = $this->model->ajoutParagraphe();
        if ($req == SERVER_ERROR || $req == MISSING_DATA || $req == UNSUPPORTED_TYPE) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."presentation");
        }
    }

    public function modifTexte() {
        $this->loadModel("paragraphe");
        $req = $this->model->modifTexte();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."presentation");
        }
    }

    public function modifImage() {
        $this->loadModel("paragraphe");
        $req = $this->model->modifImage();
        if ($req == SERVER_ERROR || $req == MISSING_DATA || $req == UNSUPPORTED_TYPE) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."presentation");
        }
    }

    public function suppImage() {
        $this->loadModel("paragraphe");
        $req = $this->model->suppImage();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."presentation");
        }    
    }

    public function suppParagraphe() {
        $this->loadModel("paragraphe");
        $req = $this->model->suppParagraphe();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."presentation");
        }
    }
}