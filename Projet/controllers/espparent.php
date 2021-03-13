<?php

class EspParent extends Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("espparent", "Espace parent");
    }

    public function getArticles() {
        $interests = array(
            "parents" => "true"
        );
        $this->loadModel("article");
        $data = $this->model->getArticles($interests);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        } 
    }

    public function getParent($id) {
        $this->loadModel("parent");
        $data = $this->model->getParent($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEleves($id) {
        $this->loadModel("eleve");
        $data = $this->model->getElevesParent($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getActivites($id) {
        $this->loadModel("participe");
        $data = $this->model->getActivitesEleve($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function login() {
        $login = isset($_POST["login"]) ? $_POST["login"] : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;
        if ($login && $password) {
            $this->loadModel("parent");
            $data = $this->model->getParentLogin($login);
            if ($data) {
                if ($data != SERVER_ERROR) {
                    if (password_verify($password, $data["password"])) {
                        Session::set("parent", $data["id_parent"]);
                        header("location: ".BASE_URL."espparent");
                    } else {
                        $this->view->render("espparent", "Espace parent", true, "err");
                    }
                } else {
                    header("location: ".BASE_URL."erreur/index/".$data);
                }
            } else {
                $this->view->render("espparent", "Espace parent", true, "err");
            }
        } else {
            header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
        }
    }

    public function logout() {
        Session::unset("parent");
        header("location: ".BASE_URL."espparent");
    }

    public function modifMdp() {
        $this->loadModel("utilisateur");
        $req = $this->model->modifMdp();
        echo $req;
    }


}