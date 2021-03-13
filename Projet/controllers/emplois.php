<?php

class Emplois extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("emplois", "Emplois du temps");
    } 

    public function cycle($params) {
        if (isset($params[0])) {
            $this->view->render("emplois", "Emplois du temps", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getClasses($cycle) {
        $this->loadModel("classe");
        $data = $this->model->getClasses($cycle);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEmploi($classe) {
        $this->loadModel("emploi");
        $data = $this->model->getEmploi($classe);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }    
    }
}