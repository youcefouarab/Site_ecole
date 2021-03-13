<?php

class AdministrationView extends View {

    function __construct() {
        parent::__construct();
        ?>
        <div class="paras-wrapper">
            <h1>Administration</h1><br><br>
        </div>
        <div class="cadres-wrapper">
        <?php
        require_once VIEWS."CadreView.php";
        new CadreView("Gestion des articles", "articles.png", "", BASE_URL."articles"); 
        new CadreView("Gestion de la présentation de l'école", "ecole.png", "", BASE_URL."presentation"); 
        new CadreView("Gestion des emplois du temps", "emploi.png", "", BASE_URL."emplois"); 
        new CadreView("Gestion des enseignants", "ens.png", "", BASE_URL."enseignants"); 
        new CadreView("Gestion des utilisateurs", "users.png", "", BASE_URL."utilisateurs"); 
        new CadreView("Gestion de la restauration", "resto.png", "", BASE_URL."restauration"); 
        new CadreView("Gestion des contacts", "contact.png", "", BASE_URL."contact"); 
        new CadreView("Paramètres", "site.png", "", BASE_URL."parametres"); 
        ?>
        </div><br><br>
        <center><button class="red"><a href="<?php echo BASE_URL ?>administration/logout">Se déconnecter</a></button></center>
        <?php
    }

}