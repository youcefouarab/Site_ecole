<?php

class AdminView extends View {
    
    function __construct($id) {
        parent::__construct();

        $id_admin = Session::get("admin");

        if ($id_admin != '1') {
            if (($id == "new") || ($id != "new" && $id_admin != $id)) {
                header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
            }
        }   
    
        $admin = null;

        $this->controller = new Admin();

        $nom = ""; $prenom = ""; $email = ""; $adresse = "";
        $tel1 = ""; $tel2 = ""; $tel3 = ""; $login = "";
        if ($id != "new") {
            $admin = $this->controller->getAdmin($id);
            if ($admin) {
                $nom = str_replace("\"", "'", str_replace("_", " ", $admin["nom"]));
                $prenom = str_replace("\"", "'", str_replace("_", " ", $admin["prenom"]));
                $email = $admin["email"];
                $adresse = str_replace("\"", "'", $admin["adresse"]);
                $tel1 = str_replace("\"", "'", $admin["tel1"]);
                $tel2 = str_replace("\"", "'", $admin["tel2"]);
                $tel3 = str_replace("\"", "'", $admin["tel3"]);
            } else {
                header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
            }
        }
        ?>

            <center>
                <?php
                    if ($id == "new") echo "<br><h1>Nouvel administrateur</h1><br><br>";
                    else echo "<br><h1>Administrateur ".$prenom."</h1><br><br>";
                ?>
                <div class="goodform">
                <?php
                    if ($id == "new") echo '<form action="'.BASE_URL.'admin/ajoutAdmin" method="POST">';
                    else echo '<form id="form">';
                ?>
                        <h2>Informations de l'admin</h2>
                        <br>
                        <input type="hidden" name="id_admin" value="<?php echo $id ?>">
                        <div class="half"><label>Nom</label><br><input type="text" name="nom" value="<?php echo $nom ?>" required></div>
                        <div class="half"><label>Prénom</label><br><input type="text" name="prenom" value="<?php echo $prenom ?>" required></div>
                        <div class="full"><label>Adresse</label><br><input type="text" name="adresse" value="<?php echo $adresse ?>" required></div>
                        <div class="full"><label>Email</label><br><input type="email" name="email" value="<?php echo $email ?>"></div>
                        <div class="third"><label>Tel. 1</label><br><input type="text" name="tel1" value="<?php echo $tel1 ?>"></div>
                        <div class="third"><label>Tel. 2</label><br><input type="text" name="tel2" value="<?php echo $tel2 ?>"></div>
                        <div class="third"><label>Tel. 3</label><br><input type="text" name="tel3" value="<?php echo $tel3 ?>"></div>
                        <br>
                        <?php
                        if ($id != "new" && strval($id_admin) != strval($id)) {
                            ?>
                            <div class="full">
                                <label>Réinitialiser login et mot de passe?</label>
                                <input type="hidden" id="reinit" name="reinit" value="false">
                            </div>
                            <div class="half"><button type="button" id="non" class="chip selected">Non</button></div>
                            <div class="half"><button type="button" id="oui" class="chip unselected">Oui</button></div>
                            <?php
                        }
                        if (strval($id_admin) == strval($id)) {
                        ?>
                            <div id="modif_mdp"></div> 
                            <div class="full"><button type="button" id="mdp" class="blue">Modifier mot de passe</button></div>  
                        <?php
                        }
                        ?>
                        <div class="full"><button type="submit" id="submit" class="blue">Confirmer</button></div>
                    </form>
                </div>
            </center>

            <script type="text/javascript">
                $(document).ready(function(){

                    <?php
                        if ($id != "new" && strval($id_admin) != strval($id)) {
                            ?>

                    $(document).on("click", "#oui", function(){
                        $("#oui").removeClass("unselected");
                        $("#oui").addClass("selected");
                        $("#non").removeClass("selected");
                        $("#non").addClass("unselected");
                        $("#reinit").val("true");
                    });

                    $(document).on("click", "#non", function(){
                        $("#non").removeClass("unselected");
                        $("#non").addClass("selected");
                        $("#oui").removeClass("selected");
                        $("#oui").addClass("unselected");
                        $("#reinit").val("false");
                    });

                    <?php
                        }
                        if (strval($id_admin) == strval($id)) {
                        ?>

                    $(document).on("click", "#mdp", function(){
                        if ($("#modif_mdp").html()) {
                            $("#mdp").html("Modifier mot de passe");
                            $("#modif_mdp").html("");
                        }
                        else {
                            var html = '<div class="full"><label>Ancien mot de passe</label><br><input type="password" id="old_pass" name="old_pass" required></div>'+
                            '<div class="full"><label>Nouveau mot de passe</label><br><input type="password" id="new_pass" name="new_pass" required></div>'+
                            '<div class="full"><label>Confirmer mot de passe</label><br><input type="password" id="conf_new_pass" name="conf_new_pass" required></div>';
                            $("#modif_mdp").html(html);
                            $("#mdp").html("Annuler");
                        }
                    });

                    <?php
                        }

             
                        ?>

                    $(document).on("submit", "#form", function(event){
                        event.preventDefault();
                        var data = {
                            id_admin : $('input[name="id_admin"]').val(),
                            nom : $('input[name="nom"]').val(),
                            prenom : $('input[name="prenom"]').val(),
                            adresse : $('input[name="adresse"]').val(),
                            email : $('input[name="email"]').val(),
                            tel1 : $('input[name="tel1"]').val(),
                            tel2 : $('input[name="tel2"]').val(),
                            tel3 : $('input[name="tel3"]').val()
                        };
                        if ($("#new_pass").length) {
                            data = {
                                id_admin : $('input[name="id_admin"]').val(),
                                nom : $('input[name="nom"]').val(),
                                prenom : $('input[name="prenom"]').val(),
                                adresse : $('input[name="adresse"]').val(),
                                email : $('input[name="email"]').val(),
                                tel1 : $('input[name="tel1"]').val(),
                                tel2 : $('input[name="tel2"]').val(),
                                tel3 : $('input[name="tel3"]').val(),
                                old_pass : $('input[name="old_pass"]').val(),
                                new_pass : $('input[name="new_pass"]').val()
                            };
                            var new_pass = $("#new_pass").val();
                            var conf_new_pass = $("#conf_new_pass").val();
                            if (new_pass != conf_new_pass) {
                                alert("Les deux mots de passe doivent être égaux!");
                                return;
                            }
                        }
                        $.post("<?php echo BASE_URL ?>admin/modifAdmin", data, function(resp){
                            if (resp == <?php echo SERVER_ERROR ?> || resp == <?php echo MISSING_DATA ?>) {
                                location = "<?php echo BASE_URL ?>erreur/index/"+resp;
                            } else if (resp == <?php echo WRONG_PASS ?>) {
                                alert("Mot de passe incorrect!");
                            } else {
                                location = "<?php echo BASE_URL ?>utilisateurs";
                            }
                        });
                    });

                    
                    
                });
            </script>

        <?php

    }

}