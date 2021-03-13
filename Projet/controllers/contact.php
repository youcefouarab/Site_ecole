<?php

class Contact extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("contact", "Contact");
    } 

    public function getContacts() {
        $this->loadModel("contact");
        $data = $this->model->getContacts();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }

    }

    public function ajoutContact() {
        $this->loadModel("contact");
        $req = $this->model->ajoutContact();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."contact");
        }
    }

    public function suppContact() {
        $this->loadModel("contact");
        $req = $this->model->suppContact();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."contact");
        }
    }
}