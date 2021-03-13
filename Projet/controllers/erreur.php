<?php

class Erreur extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($params) {
        $msg = "";
        switch($params[0]) {
            case MISSING_DATA: {
                $msg = "Les données ne sont pas proprement envoyées!";
                break;
            }
            case SERVER_ERROR: {
                $msg = "Une erreur du serveur s'est produite!";
                break;
            }
            case UNSUPPORTED_TYPE: {
                $msg = "Le type de l'image n'est pas supporté!";
                break;
            }
            case PAGE_INACC: {
                $msg = "Cette page est inaccessible!";
                break;
            }
            case DB_CONN_ERROR: {
                $msg = "La connexion à la base de données a échoué!";
                break;
            }
            case MISSING_FILES: {
                $msg = "Des fichiers requis sont manquants!";
                break;
            }
            case PAGE_INEX: {
                $msg = "Cette page n'existe pas!";
                break;
            }
            case WRONG_PASS: {
                $msg = "Mot de passe incorrect!";
                break;
            }
            default: {
                $msg = "Erreur inconnue!";
                break;
            }
        }
        $this->view->render("erreur", "Erreur", true, $msg);
    } 
    
}