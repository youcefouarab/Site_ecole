<?php

class ArticlesView extends View {
    
    function __construct($all = true) {
        parent::__construct();

        $admin = Session::get("admin");

        if ($all) {
            $this->controller = new Articles();
            $articles = $this->controller->getArticles();
            ?>
            <div class="paras-wrapper">
                <h1>Articles</h1>
            </div>
            <?php
                if ($admin) {
                ?>
                    <div class="linktoall"><a href="<?php echo BASE_URL."article/id/new" ?>">Nouvel article</a></div>
                <?php
                }
            ?>
            <div class="cadres-wrapper">
            <?php
            require_once VIEWS."CadreView.php";
            if ($articles) {
                foreach ($articles as $article) {
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
            <?php
        }
    }

}