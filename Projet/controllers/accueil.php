<?php

class Accueil extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("accueil", "Accueil");
    } 

    public function getArticles() {
        $this->loadModel("article");
        $data = $this->model->getArticles();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }
    
}