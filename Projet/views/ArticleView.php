<?php

class ArticleView extends View {
    
    function __construct($id) {
        parent::__construct();

        $admin = Session::get("admin");
    
        $this->controller = new Article();

        if ($id == "new" && $admin) {
        ?>
        <br><br>
        <center>
            <div class="goodform">
                <form action="<?php echo BASE_URL ?>article/ajoutArticle" method="POST" enctype="multipart/form-data">
                    <h2>Nouvel article</h2>
                    <div class="full">
                        <label>Titre</label>
                        <input type="text" name="titre" required>
                    </div>
                    <div class="full">
                        <label>Description</label>
                        <textarea rows="15" name="desc" required></textarea>
                    </div>
                    <div class="full">
                        <label>Image</label>
                        <input type="file" name="image">
                    </div>
                    <div class="full">
                        <label>Interêts</label>
                    </div>
                    <div class="third">
                        <button type="button" id="tous" class="chip unselected">Tous</button>
                    </div>
                    <div class="third">
                        <button type="button" class="chip unselected" check="parents">Parents</button>
                        <input type="hidden" name="parents" id="parents">
                    </div>
                    <div class="third">
                        <button type="button" class="chip unselected" check="primaires">Primaires</button>
                        <input type="hidden" name="primaires" id="primaires">
                    </div>
                    <div class="third">
                        <button type="button" class="chip unselected" check="moyens">Moyens</button>
                        <input type="hidden" name="moyens" id="moyens">
                    </div>
                    <div class="third">
                        <button type="button" class="chip unselected" check="secondaires">Secondaires</button>
                        <input type="hidden" name="secondaires" id="secondaires">
                    </div>
                    <div class="third">
                        <button type="button" class="chip unselected" check="enseignants">Enseignants</button>
                        <input type="hidden" name="enseignants" id="enseignants">
                    </div>
                    <div class="full"><button type="submit" class="blue">Ajouter</button></div>
                </form>
            </div>
        </center>
            <script type="text/javascript">
                $(document).ready(function(){
                    $(document).on("click", "#tous", function() {
                        if ($("#tous").hasClass("unselected")) {
                            $(".chip").removeClass("unselected");
                            $(".chip").addClass("selected");
                            $(":hidden").val("true");
                        } else {
                            $(".chip").removeClass("selected");
                            $(".chip").addClass("unselected");
                            $(":hidden").val("");
                        }
                    });
                    $(document).on("click", ".chip", function() {
                        if ($(this).hasClass("unselected")) {
                            $(this).removeClass("unselected");
                            $(this).addClass("selected");
                            var id = $(this).attr("check");
                            $("input#"+id).val("true");
                        } else {
                            $(this).removeClass("selected");
                            $(this).addClass("unselected");
                            var id = $(this).attr("check");
                            $("input#"+id).val("");
                        }
                    });
                });
            </script>

        <?php
        } else if ($id != "new") {
            $article = $this->controller->getArticle($id);
            if ($article) {
                ?>
                <br><br>
                <div class="article-wrapper">
            <?php
                if ($admin) {
                ?>
                    <button class="modif_image blue" style="position:relative; z-index: 55;">Modifier</button>
                <?php
                }
            ?>
                    
                    <img src="<?php echo BASE_URL.PUBLIC_CNT."img/".$article["image"]; ?>" title="<?php echo $article["titre"]; ?>">

                    <div class="fade"></div>

                    <h1><?php echo $article["titre"]; ?>
                    <?php
                        if ($admin) {
                        ?>
                            <button class="modif_titre blue">Modifier</button>
                        <?php
                        }
                    ?>       
                    </h1>

                    <p><?php echo $article["description"]; ?>
                    <?php
                        if ($admin) {
                        ?>
                            <button class="modif_desc blue">Modifier</button>
                        <?php
                        }
                    ?> 
                    </p>
<center style="font-size: 12px;">
<br><br><br><br><br><b>Interêts : </b>
                    <?php
                        if ($article["primaires"]) {
                            ?>
                            <label class="chip">Primaires, </label>
                            <?php
                        }
                        if ($article["moyens"]) {
                            ?>
                            <label class="chip">Moyens, </label>
                            <?php
                        }
                        if ($article["secondaires"]) {
                            ?>
                            <label class="chip">Secondaires, </label>
                            <?php
                        }
                        if ($article["parents"]) {
                            ?>
                            <label class="chip">Parents, </label>   
                            <?php
                        }
                        if ($article["enseignants"]) {
                            ?>
                            <label class="chip">Enseignants, </label>
                            <?php
                        }
                        ?>
                        <?php
                        if ($admin) {
                        ?>
                            <button class="modif_interests blue">Modifier</button>
                        <?php
                        }
                    ?> 
</center>
                    <?php
                        if ($admin) {
                        ?>
                            <form action="<?php echo BASE_URL ?>article/suppArticle" method="POST">
                                <input type="hidden" name="id" value="<?php echo $id ?>" >
                                <br><br><div class="linktoall"><button class="red" type="submit">Supprimer</button></div>
                            </form>
                        <?php
                        }
                    ?> 

                </div>

                <?php
                        if ($admin) {
                        ?>

                <div id="modif"></div>
                <script type="text/javascript">
                $(document).ready(function(){
                        var article = <?php echo json_encode($article) ?>;
                        function modif_titre() {
                            var html = '<div class="back"></div>'+
                                            '<div class="goodform top">'+
                                                '<form action="<?php echo BASE_URL ?>article/modifTitre" method="POST">'+
                                                    '<h2>Modifier titre</h2>'+
                                                    '<input type ="hidden" name="id" value="<?php echo $id ?>">'+
                                                    '<div class="full"><label>Titre</label>'+
                                                    '<input type="text" name="titre" value="'+article["titre"].replace(/"/g, "'")+'" required>'+
                                                    '</div>'+
                                                    '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                                '</form>'+
                                            '</div>'; 
                                $("#modif").html(html);
                        }
        
                        function modif_desc() {
                            var html = '<div class="back"></div>'+
                                            '<div class="goodform top">'+
                                                '<form action="<?php echo BASE_URL ?>article/modifDesc" method="POST">'+
                                                    '<h2>Modifier description</h2>'+
                                                    '<input type ="hidden" name="id" value="<?php echo $id ?>">'+
                                                    '<div class="full"><label>Description</label>'+
                                                    '<textarea rows="15" name="desc" required>'+article["description"].replace(/<br\s*[\/]?>/gi, "")+'</textarea>'+
                                                    '</div>'+
                                                    '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                                '</form>'+
                                            '</div>'; 
                                $("#modif").html(html);
                        }
        
                        function modif_image() {
                            var html = '<div class="back"></div>'+
                                            '<div class="goodform top">'+
                                                '<form action="<?php echo BASE_URL ?>article/modifImage" method="POST" enctype="multipart/form-data">'+
                                                    '<h2>Modifier image</h2>'+
                                                    '<input type ="hidden" name="id" value="<?php echo $id ?>">'+
                                                    '<div class="full"><label>Image</label>'+
                                                    '<input type="file" name="image"><br><br><br>(taille doit être < 2M)<br><br>'+
                                                    '</div>'+
                                                    '<div class="full"><input type="submit" name="submit" class="submit"></div>'+
                                                '</form>'+
                                            '</div>'; 
                                $("#modif").html(html);
                        }
        
                        $(document).on("click", ".modif_titre", function(){
                            modif_titre();
                        });
                        $(document).on("click", ".modif_desc", function(){
                            modif_desc();
                        });
                        $(document).on("click", ".modif_image", function(){
                            modif_image();
                        });
                        $(document).on("click", ".back", function(){
                            $("#modif").html("");
                        });

                        function modifInterests() {
                            var html = '<div class="back"></div>'+
                            '<div class="goodform top">'+
                                '<form action="<?php echo BASE_URL ?>article/modifInterests" method="POST">'+
                                    '<h2>Modifier interêts</h2>'+
                                    '<input type="hidden" id="id_i" name="id" value="<?php echo $id ?>">'+
                                    '<div class="full">'+
                                        '<label>Interêts</label>'+
                                    '</div>'+
                                    '<div class="third">'+
                                        '<button type="button" id="tous" class="chip unselected">Tous</button>'+
                                    '</div>'+
                                    '<div class="third">'+
                                        '<button type="button" class="chip unselected" check="parents">Parents</button>'+
                                        '<input type="hidden" name="parents" id="parents">'+
                                    '</div>'+
                                    '<div class="third">'+
                                        '<button type="button" class="chip unselected" check="primaires">Primaires</button>'+
                                        '<input type="hidden" name="primaires" id="primaires">'+
                                    '</div>'+
                                    '<div class="third">'+
                                        '<button type="button" class="chip unselected" check="moyens">Moyens</button>'+
                                        '<input type="hidden" name="moyens" id="moyens">'+
                                    '</div>'+
                                    '<div class="third">'+
                                        '<button type="button" class="chip unselected" check="secondaires">Secondaires</button>'+
                                        '<input type="hidden" name="secondaires" id="secondaires">'+
                                    '</div>'+
                                    '<div class="third">'+
                                        '<button type="button" class="chip unselected" check="enseignants">Enseignants</button>'+
                                        '<input type="hidden" name="enseignants" id="enseignants">'+
                                    '</div>'+
                                    '<div class="full"><button type="submit" class="blue">Confirmer</button></div>'+
                                '</form>'+
                            '</div>';
                            $("#modif").html(html);
                        }

                        $(document).on("click", ".modif_interests", function(){
                            modifInterests();
                        });

                        $(document).on("click", "#tous", function() {
                            if ($("#tous").hasClass("unselected")) {
                                $(".chip").removeClass("unselected");
                                $(".chip").addClass("selected");
                                $(":hidden").not("#id_i").val("true");
                            } else {
                                $(".chip").removeClass("selected");
                                $(".chip").addClass("unselected");
                                $(":hidden").not("#id_i").val("");
                            }
                        });
                        $(document).on("click", ".chip", function() {
                            if ($(this).hasClass("unselected")) {
                                $(this).removeClass("unselected");
                                $(this).addClass("selected");
                                var id = $(this).attr("check");
                                $("input#"+id).val("true");
                            } else {
                                $(this).removeClass("selected");
                                $(this).addClass("unselected");
                                var id = $(this).attr("check");
                                $("input#"+id).val("");
                            }
                        });
                    });
                </script>

                        <?php
                        }
    
            } else  {
                header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
            }
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

}