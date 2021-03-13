<?php

class View {

    function __construct() {
    }

    public function render($name, $titre = "", $header_footer = true, $params = null) {
        if ($header_footer == true) {
            if (file_exists(VIEWS."EnteteView.php")) {
                require_once VIEWS."EnteteView.php";
                $entete = new EnteteView($titre);
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_FILES);
            }
        }
        if ($name == "accueil") {
            if (file_exists(VIEWS."DiaporamaView.php")) {
                require_once VIEWS."DiaporamaView.php";
                $diapo = new DiaporamaView();
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_FILES);
            }
        }
        if ($header_footer == true) {
            if (file_exists(VIEWS."MenuView.php")) {
                require_once VIEWS."MenuView.php";
                $menu = new MenuView();
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_FILES);
            }
        }
        if (file_exists(VIEWS.$name."View.php")) {
            require_once VIEWS.$name."View.php";
            $v = $name."View";
            if ($params != null) $view = new $v($params);
            else $view = new $v();
        } else {
            header("location: ".BASE_URL."erreur/index/".MISSING_FILES);
        }        
        if ($header_footer == true) {
            if (file_exists(VIEWS."PiedView.php")) {
                require_once VIEWS."PiedView.php";
                $pied = new PiedView();
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_FILES);
            }
            
        }
    }

}