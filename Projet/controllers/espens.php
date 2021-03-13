<?php

class EspEns extends Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render("espens", "Espace enseignant");
    }

    public function getArticles() {
        $interests = array(
            "enseignants" => "true"
        );
        $this->loadModel("article");
        $data = $this->model->getArticles($interests);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
        
    }

    public function getEnseignant($id) {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignant($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getClasses($id) {
        $this->loadModel("enseigne");
        $data = $this->model->getClassesEns($id);
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
            $this->loadModel("enseignant");
            $data = $this->model->getEnseignantLogin($login);
            if ($data) {
                if ($data != SERVER_ERROR) {
                    if (password_verify($password, $data["password"])) {
                        Session::set("ens", $data["id_enseignant"]);
                        header("location: ".BASE_URL."espens");
                    } else {
                        $this->view->render("espens", "Espace enseignant", true, "err");
                    }
                } else {
                    header("location: ".BASE_URL."erreur/index/".$data);
                }
            } else {
                $this->view->render("espens", "Espace enseignant", true, "err");
            }
        } else {
            header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
        }
    }

    public function logout() {
        Session::unset("ens");
        header("location: ".BASE_URL."espens");
    }

    public function modifMdp() {
        $this->loadModel("utilisateur");
        $req = $this->model->modifMdp();
        echo $req;
    }


}