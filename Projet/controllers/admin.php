<?php

class Admin extends Controller {

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
            $this->view->render("admin", "Admin", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getAdmin($id) {
        $this->loadModel("admin");
        $data = $this->model->getAdmin($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutAdmin() {
        $this->loadModel("admin");
        $req = $this->model->ajoutAdmin();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."utilisateurs");
        }
    }

    public function modifAdmin() {
        $this->loadModel("admin");
        $req = $this->model->modifAdmin();
        echo $req;
    }

}