<?php

class EspEleve extends Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("espeleve", "Espace élève");
    }

    public function getArticles() {
        $interests = array(
            "eleves" => "true"
        );
        $this->loadModel("article");
        $data = $this->model->getArticles($interests);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEleve($id) {
        $this->loadModel("eleve");
        $data = $this->model->getEleve($id);
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
            $this->loadModel("eleve");
            $data = $this->model->getEleveLogin($login);
            if ($data) {
                if ($data != SERVER_ERROR) {
                    if (password_verify($password, $data["password"])) {
                        Session::set("eleve", $data["id_eleve"]);
                        header("location: ".BASE_URL."espeleve");
                    } else {
                        $this->view->render("espeleve", "Espace élève", true, "err");
                    }
                } else {
                    header("location: ".BASE_URL."erreur/index/".$data);
                }
            } else {
                $this->view->render("espeleve", "Espace élève", true, "err");
            }
        } else {
            header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
        }
    }

    public function logout() {
        Session::unset("eleve");
        header("location: ".BASE_URL."espeleve");
    }

    public function modifMdp() {
        $this->loadModel("utilisateur");
        $req = $this->model->modifMdp();
        echo $req;
    }


}