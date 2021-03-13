<?php

class Controller {

    function __construct($params = null) {
        @Session::init();
        $this->view = new View();
    }

    function loadModel($name) {
        $path = MODELS.$name."Model.php";
        if (file_exists($path)) {
            require_once $path;
            $model = $name."Model";
            $this->model = new $model();
        } else {
            header("location: ".BASE_URL."erreur/index/".MISSING_FILES);
        }
    }

}
