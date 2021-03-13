<?php

class AdminLogin extends Controller {

    function __construct() {
        parent::__construct();
        $admin = Session::get("admin");
        if ($admin) {
            header("location: ".BASE_URL."administration");
        }
    }

    public function index() {
        $this->view->render("adminlogin", "Login", false);
    } 

    public function login() {
        $login = isset($_POST["login"]) ? $_POST["login"] : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;
        if ($login && $password) {
            $this->loadModel("admin");
            $data = $this->model->getAdminLogin($login);
            if ($data) {
                if ($data != SERVER_ERROR) {
                    if (password_verify($password, $data["password"])) {
                        Session::set("admin", $data["id_admin"]);
                        header("location: ".BASE_URL."administration");
                    } else {
                        $this->view->render("adminlogin", "Login", false, "err");
                    }
                } else {
                    header("location: ".BASE_URL."erreur/index/".$data);
                }
            } else {
                $this->view->render("adminlogin", "Login", false, "err");
            }
        } else {
            header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
        }
    }

}