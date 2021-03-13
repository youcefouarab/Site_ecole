<?php

class Secondaire extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("secondaire", "Cycle secondaire");
    } 

    public function getArticles() {
        $interests = array(
            "secondaires" => "true"
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