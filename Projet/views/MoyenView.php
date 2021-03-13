<?php

class MoyenView extends View {

    function __construct() {
        parent::__construct();
        $this->controller = new Moyen();
        $articles = $this->controller->getArticles();
        ?>
        <div class="paras-wrapper">
                <h1>Cycle moyen</h1><br><br>
        </div>
        <div class="cadres-wrapper">
        <?php
        require_once VIEWS."CadreView.php";
        new CadreView("Emplois du temps", "emploi.png", "", BASE_URL."emplois/cycle/moyen"); 
        new CadreView("Enseignants", "ens.png", "", BASE_URL."enseignants/cycle/moyen"); 
        new CadreView("Informations pratiques", "infos.png", "", ""); 
        new CadreView("Restauration", "resto.png", "", BASE_URL."restauration"); 
        for ($i = 0; $i < 4; $i++) {
            if (isset($articles[$i])) {
                $article = $articles[$i];
                $titre = $article["titre"];
                $image = $article["image"];
                $desciption = $article["description"];
                $link = BASE_URL."article/id/".$article["id_article"];
                $date = date("j M, Y, H:i", strtotime($article["created"]));
                new CadreView($titre, $image, $desciption, $link, $date); 
            }
        }
        ?>
        </div>
        <div class="linktoall">
            <a href="<?php echo BASE_URL ?>articles">Tous les articles</a>
        </div>
        <?php
    }

}