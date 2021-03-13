<?php

class Primaire extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("primaire", "Cycle primaire");
    } 

    public function getArticles() {
        $interests = array(
            "primaires" => "true"
        );
        $this->loadModel("article");
        $data = $this->model->getArticles($interests);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }   

    }

}