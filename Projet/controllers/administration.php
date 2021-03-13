<?php

class Administration extends Controller {

    function __construct() {
        parent::__construct();
        $admin = Session::get("admin");
        if (!$admin) {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function index() {
        $this->view->render("administration", "Administration");
    } 

    public function logout() {
        Session::unset("admin");
        header("location: ".BASE_URL."adminlogin");
    }
}