<?php

class Router {

    function __construct() {
        $url = isset($_GET[URL_PARAM]) ? $_GET[URL_PARAM] : "accueil";
        $url = rtrim($url, "/");
        $url = explode("/", $url);
        
        $file = CONTROLLERS.$url[0].".php";
        if (file_exists($file)) {
            require_once $file;
        } else {
            $this->error();
        }

        $controller = new $url[0]();

        if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $params = null;
                $n = 2;
                while (isset($url[$n])) {
                    $params[$n-2] = $url[$n];
                    $n++;
                }
                $controller->{$url[1]}($params);
            } else {
                $this->error();
            }
        } else $controller->index();
    }

    function error() {
        header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
    }

}