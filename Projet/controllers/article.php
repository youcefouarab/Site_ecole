<?php

class Article extends Controller {
    function __construct() {
        parent::__construct();
    }

    public function index() {
        header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
    }

    public function id($params) {
        if (isset($params[0])) {
            $this->view->render("article", "Article", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getArticle($id) {
        $this->loadModel("article");
        $data = $this->model->getArticle($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function ajoutArticle() {
        $this->loadModel("article");
        $req = $this->model->ajoutArticle();
        if ($req == SERVER_ERROR || $req == MISSING_DATA || $req == UNSUPPORTED_TYPE) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."article/id/".$req);
        }
    }

    public function suppArticle() {
        $this->loadModel("article");
        $req = $this->model->suppArticle();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."articles");
        }
    }

    public function modifTitre() {
        $this->loadModel("article");
        $req = $this->model->modifTitre();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."article/id/".$req);
        }
    } 
    
    public function modifDesc() {
        $this->loadModel("article");
        $req = $this->model->modifDesc();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."article/id/".$req);
        }

    }

    public function modifImage(){
        $this->loadModel("article");
        $req = $this->model->modifImage();
        if ($req == SERVER_ERROR || $req == MISSING_DATA || $req == UNSUPPORTED_TYPE) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."article/id/".$req);
        }
    }

    public function modifInterests() {
        $this->loadModel("article");
        $req = $this->model->modifInterests();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            header("location: ".BASE_URL."article/id/".$req);
        }
    } 

}