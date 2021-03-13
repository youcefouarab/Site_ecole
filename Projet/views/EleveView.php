<?php

class EleveView extends View {
    
    function __construct($id) {
        parent::__construct();
        $this->controller = new Eleve();
        $classes = $this->controller->getClasses();
        $parents = $this->controller->getParents();
        $activites = $this->controller->getActivites();
        $acts = $this->controller->getActivitesEleve($id);
        $nom = ""; $prenom = ""; $date_n = ""; $email = ""; $adresse = "";
        $tel1 = ""; $tel2 = ""; $tel3 = ""; $id_classe = ""; $id_parent = "";
        $id_eleve = ""; $id_utilisateur = "";
        if ($id != "new") {
            $eleve = $this->controller->getEleve($id);
            if ($eleve) {
                $nom = str_replace("\"", "'", str_replace("_", " ", $eleve["nom"]));
                $prenom = str_replace("\"", "'", str_replace("_", " ", $eleve["prenom"]));
                $date_n = $eleve["date_naissance"];
                $email = $eleve["email"];
                $adresse = str_replace("\"", "'", $eleve["adresse"]);
                $tel1 = str_replace("\"", "'", $eleve["tel1"]);
                $tel2 = str_replace("\"", "'", $eleve["tel2"]); 
                $tel3 = str_replace("\"", "'", $eleve["tel3"]);
                $id_classe = $eleve["id_classe"]; $id_parent = $eleve["id_parent"];
                $id_eleve = $eleve["id_eleve"]; $id_utilisateur = $eleve["id_utilisateur"];
            }  else {
                header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
            }
        }
        ?>

            <center>
                <?php
                    if ($id == "new") echo "<br><h1>Nouvel élève</h1><br><br>";
                    else echo "<br><h1>Elève ".$id."</h1><br><br>";
                ?>
                <div class="goodform">
                <?php
                    if ($id == "new") echo '<form action="'.BASE_URL.'eleve/ajoutEleve" method="POST">';
                    else echo '<form action="'.BASE_URL.'eleve/modifEleve" method="POST">';
                ?>
                        <h2>Informations de l'élève</h2>
                        <br>
                        <input type="hidden" name="id_eleve" value="<?php echo $id_eleve ?>">
                        <input type="hidden" name="id_utilisateur" value="<?php echo $id_utilisateur ?>">
                        <div class="half"><label>Nom</label><br><input type="text" name="nom" value="<?php echo $nom ?>" required></div>
                        <div class="half"><label>Prénom</label><br><input type="text" name="prenom" value="<?php echo $prenom ?>" required></div>
                        <div class="half"><label>Date de naissance</label><br><input type="date" name="date_n" value="<?php echo $date_n ?>" required></div>
                        <div class="half"><label>Email</label><br><input type="email" name="email" value="<?php echo $email ?>"></div>
                        <div class="full"><label>Adresse</label><br><input type="text" name="adresse" value="<?php echo $adresse ?>" required></div>
                        <div class="third"><label>Tel. 1</label><br><input type="text" name="tel1" value="<?php echo $tel1 ?>"></div>
                        <div class="third"><label>Tel. 2</label><br><input type="text" name="tel2" value="<?php echo $tel2 ?>"></div>
                        <div class="third"><label>Tel. 3</label><br><input type="text" name="tel3" value="<?php echo $tel3 ?>"></div>
                        <div class="full">
                            <label>Classe</label><br>
                            <select name="classe" required>
                                <option value="">--Classe--</option>
                                <?php
                                foreach($classes as $classe) {
                                    ?>
                                    <option value="<?php echo $classe['id_classe']; ?>"><?php echo $classe['id_classe']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <?php 
                        if ($id != "new") {
                        ?>
                        <div class="full">
                            <label>Activités extrascolaires</label><button type="button" class="blue round add_a">+</button><br>
                            <?php
                                foreach($acts as $activite) {
                                    ?>
                                    <label class="chip"><?php echo $activite["activite"] ?><button type="button" id_eleve="<?php echo $id_eleve ?>" id_act="<?php echo $activite["id_activite"] ?>" class="red round supp_a">x</button></label>
                                    <?php
                                }
                            ?>                       
                        </div>
                            <div class="full">
                                <label>Réinitialiser login et mot de passe?</label>
                                <input type="hidden" id="reinit" name="reinit" value="false">
                            </div>
                            <div class="half"><button type="button" id="non" class="chip selected">Non</button></div>
                            <div class="half"><button type="button" id="oui" class="chip unselected">Oui</button></div>
                            <?php
                        }
                        ?>
                        <br><br>
                        <h2>Parent tuteur principal</h2>
                        <?php
                        if ($id == "new") {
                            echo '
                            <br>
                            <div class="half"><button type="button" id="newp" class="blue">Ajouter nouveau</button></div>
                            <div class="half"><button type="button" id="exist" class="blue">Choisir existant</button></div>';
                        }
                        ?>
                        <br>
                        <div id="parent">
                            <?php
                            if ($id != "new") {
                            ?>
                                <div class="full">
                                    <label>Parent</label><br>
                                    <select name="id_parent" required>
                                        <option value="">--Parent--</option>
                                        <?php
                                        foreach($parents as $parent) {
                                            ?>
                                            <option value="<?php echo $parent["id_parent"] ?>"><?php echo $parent["id_parent"]." - ".$parent["nom"]." ".$parent["prenom"] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="full"><button type="submit" class="blue">Confirmer</button></div>
                            <?php
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </center>
            <div id="popup"></div>

            <script type="text/javascript">
                $(document).ready(function(){

                    $('select[name="classe"] option[value="<?php echo $id_classe ?>"]').attr("selected", "selected");
                    $('select[name="id_parent"] option[value="<?php echo $id_parent ?>"]').attr("selected", "selected");

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
                    
                    $(document).on("click", "#newp", function(){
                        var html = '<div class="half"><label>Nom</label><br><input type="text" name="nom_p" required></div>'+
                        '<div class="half"><label>Prénom</label><br><input type="text" name="prenom_p" required></div>'+
                        '<div class="half"><label>Date de naissance</label><br><input type="date" name="date_n_p" required></div>'+
                        '<div class="half"><label>Email</label><br><input type="email" name="email_p"></div>'+
                        '<div class="full"><label>Adresse</label><br><input type="text" name="adresse_p" required></div>'+
                        '<div class="third"><label>Tel. 1</label><br><input type="text" name="tel1_p"></div>'+
                        '<div class="third"><label>Tel. 2</label><br><input type="text" name="tel2_p"></div>'+
                        '<div class="third"><label>Tel. 3</label><br><input type="text" name="tel3_p"></div>'+
                        '<div class="full"><button type="submit" class="blue">Ajouter élève</button></div>';
                        $("#parent").html(html);
                    });

                    $(document).on("click", "#exist", function(){
                        var parents = <?php echo json_encode($parents); ?>;
                        var html = '<div class="full"><label>Parent</label><br><select name="id_parent" required>'+
                                '<option value="">--Parent--</option>';
                                parents.forEach(function(p){
                                    html += '<option value="'+p.id_parent+'">'+p.id_parent+' - '+p.nom+' '+p.prenom+'</option>';
                                });
                            html += '</select></div>'+
                        '<div class="full"><button type="submit" class="blue">Ajouter élève</button></div>';
                        $("#parent").html(html);
                    });

                    function addActivite() {
                        var activites = <?php echo json_encode($activites); ?>;
									var html = '<div class="back"></div>'+
									'<div class="goodform top">'+
										'<form action="<?php echo BASE_URL ?>eleve/ajoutActivite" method="POST">'+
                                            '<input type="hidden" name="eleve" value="<?php echo $id_eleve ?>">'+
                                            '<div class="full"><label>Activité extrascolaire</label><br>'+
                                            '<select name="activite" required>'+
                                                '<option value="">--Activité--</option>';
                                                activites.forEach(function(a){
                                                    html += '<option value="'+a.id_activite+'">'+a.activite+'</option>';
                                                });
                                            html += '</select></div>'+
											'<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
										'</form>'+
									'</div>'; 
									$("#popup").html(html);
							}

							$(document).on("click", ".add_a", function(){
								sessionStorage.setItem("eleve_y", window.scrollY);
								addActivite();
							});

                            $(document).on("click", ".back", function(){
                                $("#popup").html("");
                            });

							$(document).on("click", ".supp_a", function(){
									$.post("<?php echo BASE_URL ?>eleve/suppActivite", {
										eleve : $(this).attr("id_eleve"),
                                        activite : $(this).attr("id_act")
									}, function() {
										sessionStorage.setItem("eleve_y", window.scrollY);
										location.reload();
									});
								});

                                var y = sessionStorage.getItem("eleve_y");
								if (y == undefined) y = 0;
								$(this).scrollTop(y);
                });
            </script>

        <?php

    }

}