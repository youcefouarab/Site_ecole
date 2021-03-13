<?php

class EspEnsView extends View {

    function __construct($err = "") {
        parent::__construct();
        $this->controller = new EspEns();

        $id_enseignant = Session::get("ens");
            
        if ($id_enseignant) {

            $ens = $this->controller->getEnseignant($id_enseignant);
            $classes = $this->controller->getClasses($id_enseignant);
            if ($ens) {
                $nom = str_replace("\"", "'", str_replace("_", " ", $ens["nom"]));
                $prenom = str_replace("\"", "'", str_replace("_", " ", $ens["prenom"]));

            ?>

            <div class="paras-wrapper">
                <h1>Bienvenus, <?php echo $ens["prenom"] ?></h1><br><br>
            </div>
<center>
                    <div class="goodform">
                        <h2>Mon profil</h2>
                        <div class="third"><label>ID</label><input value="<?php echo $ens["id_enseignant"] ?>" disabled></div>
						<div class="third"><label>Nom</label><input value="<?php echo $nom ?>" disabled></div>
                        <div class="third"><label>Prénom</label><input value="<?php echo $prenom ?>" disabled></div>
                        <div class="full"><label>EDT</label><a href="<?php echo BASE_URL ?>emploi/ens/<?php echo $ens["id_enseignant"] ?>">Consulter EDT</a></div>
                        <?php
                            if ($classes) {
                                ?>
                                <?php
                                foreach ($classes as $classe) {
                                    ?>
                                        <div class="third"><label>Classe <?php echo $classe["id_classe"] ?></label><a href="<?php echo BASE_URL ?>notes/classe/<?php echo $classe["id_classe"] ?>">Notes</a></div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <br><br>
                    <div class="goodform">
                        <div id="modif_mdp"></div> 
                        <div class="full"><button type="button" id="mdp" class="blue">Modifier mot de passe</button></div>
                    </div>
                    <br><br><br>
                    <button class="red"><a href="<?php echo BASE_URL ?>espens/logout">Se déconnecter</a></button>
</center>

            <script type="text/javascript">
                $(document).ready(function(){

                    $(document).on("click", "#mdp", function(){
                        if ($("#modif_mdp").html()) {
                            $("#mdp").html("Modifier mot de passe");
                            $("#modif_mdp").html("");
                        }
                        else {
                            var html = '<form id="form">'+
                            '<div class="full"><label>Ancien mot de passe</label><br><input type="password" id="old_pass" name="old_pass" required></div>'+
                            '<div class="full"><label>Nouveau mot de passe</label><br><input type="password" id="new_pass" name="new_pass" required></div>'+
                            '<div class="full"><label>Confirmer mot de passe</label><br><input type="password" id="conf_new_pass" name="conf_new_pass" required></div>'+
                            '<div class="full"><button type="submit" id="submit" class="blue">Confirmer</button></div>'+
                            '</form>';
                            $("#modif_mdp").html(html);
                            $("#mdp").html("Annuler");
                        }
                    });

                    $(document).on("submit", "#form", function(event){
                        event.preventDefault();
                        data = {
                            id : "<?php echo $ens["id_utilisateur"] ?>",
                            old_pass : $('input[name="old_pass"]').val(),
                            new_pass : $('input[name="new_pass"]').val()
                        };
                        var new_pass = $("#new_pass").val();
                        var conf_new_pass = $("#conf_new_pass").val();
                        if (new_pass != conf_new_pass) {
                            alert("Les deux mots de passe doivent être égaux!");
                            return;
                        }
                        $.post("<?php echo BASE_URL ?>espeleve/modifMdp", data, function(resp){
                            if (resp == <?php echo SERVER_ERROR ?> || resp == <?php echo MISSING_DATA ?>) {
                                location = "<?php echo BASE_URL ?>erreur/index/"+resp;
                            } else if (resp == <?php echo WRONG_PASS ?>) {
                                alert("Mot de passe incorrect!");
                            } else {
                                location.reload(true);
                            }
                        });
                    });
                    
                });
            </script>


            <?php
            } else {
                goto no;
            }
        } else {
            no:

        $articles = $this->controller->getArticles();
        ?>
        <div class="paras-wrapper">
            <h1>Espace enseignant</h1><br><br>
        </div>
        <div class="login_user">
            <form method="POST" action="<?php echo BASE_URL ?>espens/login">
            <div><label>Login</label><input type="text" name="login"></div>
            <div><label>Password</label><input type="password" name="password"></div>
            <button type="submit" class="blue">Se Connecter</button>
            <div><a href="">Mot de passe oublié</a></div>
            <?php if ($err == "err") echo '<br><br><label class="err">Login ou mot de passe incorrect</label><br><br>'; ?>
            </form>
        </div>
        <br><br><br><br>
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

}