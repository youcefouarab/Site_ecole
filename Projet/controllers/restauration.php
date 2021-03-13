<?php

class Restauration extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("restauration", "Restauration");
    } 

    public function getRestauration() {
        $this->loadModel("restauration");
        $data = $this->model->getRestauration();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }

    }

    public function modifRestauration() {
        $this->loadModel("restauration");
        $req = $this->model->modifRestauration();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."restauration");
        }
    }
}