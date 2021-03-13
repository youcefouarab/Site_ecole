<?php

class PresentationView extends View {

    function __construct() {
        parent::__construct();

        $admin = Session::get("admin");

        $this->controller = new Presentation();
        $parags = $this->controller->getParagraphes();
        ?>
            <div class="paras-wrapper">
                <h1>Présentation de l'école</h1>
            <?php
        if ($parags) {
            
            for ($i = 0; $i < count($parags); $i++) {
                $p = $parags[$i];
                ?>
                <div class="para-wrapper">
                    <p><?php echo $p["texte"] ?>
                        <?php
                            if ($admin) {
                            ?>
                                <button class="modif_texte blue" id="<?php echo $i ?>">Modifier</button>
                            <?php
                            }
                        ?>           
                    </p>
                        <?php 
                            if ($p["image"]) {
                                ?>
                                <img src="<?php echo BASE_URL.PUBLIC_CNT."img/".$p["image"] ?>"><br>

                                <?php
                                    if ($admin) {
                                    ?>
                                        <button class="modif_image blue" id="<?php echo $i ?>">Modifier image</button>
                                        <form action="<?php echo BASE_URL ?>presentation/suppImage" method="POST" style="display:inline-block;">
                                            <input type="hidden" name ="id" value="<?php echo $p["id_paragraphe"] ?>">
                                            <button type="submit" class="supp_image red" id="<?php echo $p["id_paragraphe"] ?>">Supprimer image</button>
                                        </form>
                                    <?php
                                    }
                            } else {
                                if ($admin) {
                                ?>
                                    <button class="modif_image blue" id="<?php echo $i ?>">Ajouter image</button>
                                <?php
                                }
                            }
                        ?>
                        <br><br>

                        <?php
                            if ($admin) {
                            ?>
                                <form action="<?php echo BASE_URL ?>presentation/suppParagraphe" method="POST">
                                    <input type="hidden" name ="id" value="<?php echo $p["id_paragraphe"] ?>">
                                    <button class="supp_para red" type="submit">Supprimer paragraphe</button>
                                </form>
                            <?php
                            }
                        ?>
                        
                    </div>
                <?php
            }
            
        }

        ?>
            </div>

        <?php
            if ($admin) {
            ?>
            <br><br><div class="linktoall"><button class="ajout_para"> + Paragraphe</button></div>

            <div id="modif"></div>

            <script type="text/javascript">
                $(document).ready(function(){
                    var parags = <?php echo json_encode($parags); ?>;
                    if (parags == undefined) parags = new Array();

                    function ajout_para() {
                        sessionStorage.setItem("presentation_y", window.scrollY);
                        var html = '<div class="back"></div>'+
                                        '<div class="goodform top">'+
                                            '<form action="<?php echo BASE_URL ?>presentation/ajoutParagraphe" method="POST" enctype="multipart/form-data">'+
                                                '<h2>Ajouter paragraphe</h2>'+
                                                    '<div class="full"><label>Paragraphe</label>'+
                                                    '<textarea rows="7" name="texte" required></textarea>'+
                                                    '</div>'+
                                                    '<div class="full"><label>Image</label>'+
                                                    '<input type="file" name="image"><br><br><br>(taille doit être < 2M)<br><br>'+
                                                    '</div>'+
                                                    '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                            '</form>'+
                                        '</div>'; 
                            $("#modif").html(html);
                    }

                    function modif_texte(id) {
                        sessionStorage.setItem("presentation_y", window.scrollY);
                        var html = '<div class="back"></div>'+
                                        '<div class="top goodform">'+
                                            '<form action="<?php echo BASE_URL ?>presentation/modifTexte" method="POST">'+
                                                '<h2>Modifier paragraphe</h2>'+
                                                '<input type ="hidden" name="id" value="'+parags[id].id_paragraphe+'">'+
                                                '<div class="full"><label>Paragraphe</label>'+
                                                '<textarea rows="15" name="texte" required>'+parags[id].texte.replace(/<br\s*[\/]?>/gi, "")+'</textarea>'+
                                                '</div>'+
                                                '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                            '</form>'+
                                        '</div>'; 
                            $("#modif").html(html);
                    }

                    function modif_image(id) {
                        sessionStorage.setItem("presentation_y", window.scrollY);
                        var html = '<div class="back"></div>'+
                                        '<div class="top goodform">'+
                                            '<form action="<?php echo BASE_URL ?>presentation/modifImage" method="POST" enctype="multipart/form-data">'+
                                                '<h2>Modifier image</h2>'+
                                                '<input type ="hidden" name="id" value="'+parags[id].id_paragraphe+'">'+
                                                '<div class="full"><label>Image</label>'+
                                                '<input type="file" name="image"><br><br><br>(taille doit être < 2M)<br><br>'+
                                                '</div>'+
                                                '<div class="full"><input type="submit" name="submit" class="submit"></div>'+
                                            '</form>'+
                                        '</div>';  
                            $("#modif").html(html);
                    }

                    $(document).on("click", ".ajout_para", function(){
                        ajout_para();
                    });
                    $(document).on("click", ".modif_texte", function(){
                        modif_texte($(this).attr("id"));
                    });
                    $(document).on("click", ".modif_image", function(){
                        modif_image($(this).attr("id"));
                    });
                    $(document).on("click", ".back", function(){
                        $("#modif").html("");
                        $("#ajout").html("");
                    });
                });

                var y = sessionStorage.getItem("presentation_y");
                if (y == undefined) y = 0;
                $(this).scrollTop(y);
            </script>

            <?php
        }
    }

}