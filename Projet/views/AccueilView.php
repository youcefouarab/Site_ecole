<?php

class AccueilView extends View {

    function __construct() {
        parent::__construct();
        $this->controller = new Accueil();
        $articles = $this->controller->getArticles();
        ?>
        <br><br>
        <div class="cadres-wrapper">
        <?php
        require_once VIEWS."CadreView.php";
        for ($i = 0; $i < 8; $i++) {
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