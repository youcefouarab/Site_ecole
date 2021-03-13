<?php

class EnseignantView extends View {
    
    function __construct($id) {
        parent::__construct();
        $this->controller = new Enseignant();
        $nom = ""; $prenom = ""; $email = ""; $adresse = "";
        $tel1 = ""; $tel2 = ""; $tel3 = ""; $id_utilisateur = "";
        if ($id != "new") {
            $enseignant = $this->controller->getEnseignant($id);
            if ($enseignant) {
                $nom = str_replace("\"", "'", str_replace("_", " ", $enseignant["nom"])); 
                $prenom = str_replace("\"", "'", str_replace("_", " ", $enseignant["prenom"]));
                $email = $enseignant["email"]; 
                $adresse = str_replace("\"", "'", $enseignant["adresse"]);
                $tel1 = str_replace("\"", "'", $enseignant["tel1"]);
                $tel2 = str_replace("\"", "'", $enseignant["tel2"]);
                $tel3 = str_replace("\"", "'", $enseignant["tel3"]);
                $id_utilisateur = $enseignant["id_utilisateur"];
            } else {
                header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
            }
        }
        ?>

            <center>
                <?php
                    if ($id == "new") echo "<br><h1>Nouvel enseignant</h1><br><br>";
                    else echo "<br><h1>Enseignant ".$id."</h1><br><br>";
                ?>
                <div class="goodform">
                <?php
                    if ($id == "new") echo '<form action="'.BASE_URL.'enseignant/ajoutEnseignant" method="POST">';
                    else echo '<form action="'.BASE_URL.'enseignant/modifEnseignant" method="POST">';
                ?>
                        <h2>Informations de l'enseignant</h2>
                        <br>
                        <input type="hidden" name="id_utilisateur" value="<?php echo $id_utilisateur ?>">
                        <div class="half"><label>Nom</label><br><input type="text" name="nom" value="<?php echo $nom ?>" required></div>
                        <div class="half"><label>Prénom</label><br><input type="text" name="prenom" value="<?php echo $prenom ?>" required></div>
                        <div class="full"><label>Adresse</label><br><input type="text" name="adresse" value="<?php echo $adresse ?>" required></div>
                        <div class="full"><label>Email</label><br><input type="email" name="email" value="<?php echo $email ?>"></div>
                        <div class="third"><label>Tel. 1</label><br><input type="text" name="tel1" value="<?php echo $tel1 ?>"></div>
                        <div class="third"><label>Tel. 2</label><br><input type="text" name="tel2" value="<?php echo $tel2 ?>"></div>
                        <div class="third"><label>Tel. 3</label><br><input type="text" name="tel3" value="<?php echo $tel3 ?>"></div>
                        <?php
                        if ($id != "new") {
                            ?>
                            <div class="full">
                                <label>Réinitialiser login et mot de passe?</label>
                                <input type="hidden" id="reinit" name="reinit" value="false">
                            </div>
                            <div class="half"><button type="button" id="non" class="chip selected">Non</button></div>
                            <div class="half"><button type="button" id="oui" class="chip unselected">Oui</button></div>
                            <?php
                        }
                        ?>
                        <br>
                        <div class="full"><button type="submit" class="blue">Confirmer</button></div>
                    </form>
                </div>
            </center>

            <script type="text/javascript">
                $(document).ready(function(){

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
                    
                });
            </script>

        <?php

    }

}