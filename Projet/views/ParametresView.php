<?php

class ParametresView extends View {
    function __construct() {
        parent::__construct();

        $this->controller = new Parametres();
        $matieres = $this->controller->getMatieres();
	    $primaires = $this->controller->getClassesCycle("primaire");
        $moyens = $this->controller->getClassesCycle("moyen");
        $secondaires = $this->controller->getClassesCycle("secondaire");
        $activites = $this->controller->getActivites();

        ?>
        <div class="paras-wrapper">
            <h1>Paramètres</h1><br><br>
        </div>
<center>
        <div class="goodform">
            <h2>Paramètres de l'école</h2>
			<div class="full">
                <h3>Matières</h3><button class="blue round add_m">+</button><br><br>
                <?php
                foreach ($matieres as $matiere) {
                    ?>
                    <label class="chip"><?php echo $matiere["nom"] ?><button id="<?php echo $matiere["id_matiere"] ?>" class="red round supp_m">x</button></label>
                    <?php
                }
                ?>
                
            </div>
            <div class="full">
                <h3>Classes primaires</h3><button class="blue round add_c" cycle="primaire">+</button><br><br>
                <?php
                foreach ($primaires as $classe) {
                    ?>
                    <label class="chip"><?php echo $classe["id_classe"] ?><button id="<?php echo $classe["id_classe"] ?>" class="red round supp_c">x</button></label>
                    <?php
                }
                ?>
            </div>
            <div class="full">
                <h3>Classes moyens</h3><button class="blue round add_c" cycle="moyen">+</button><br><br>
                <?php
                foreach ($moyens as $classe) {
                    ?>
                    <label class="chip"><?php echo $classe["id_classe"] ?><button id="<?php echo $classe["id_classe"] ?>" class="red round supp_c">x</button></label>
                    <?php
                }
                ?>
            </div>
            <div class="full">
                <h3>Classes secondaires</h3><button class="blue round add_c" cycle="secondaire">+</button><br><br>
                <?php
                foreach ($secondaires as $classe) {
                    ?>
                    <label class="chip"><?php echo $classe["id_classe"] ?><button id="<?php echo $classe["id_classe"] ?>" class="red round supp_c">x</button></label>
                    <?php
                }
                ?>
            </div>
            <div class="full">
                <h3>Activités extrascolaires</h3><button class="blue round add_a">+</button><br><br>
                <?php
                foreach ($activites as $activite) {
                    ?>
                    <label class="chip"><?php echo $activite["activite"] ?><button id="<?php echo $activite["id_activite"] ?>" class="red round supp_a">x</button></label>
                    <?php
                }
                ?>                     
            </div>
        </div>
        <br><br><br>
        <div class="goodform">
            <h2>Paramètres du site</h2>
			<div class="full">
                <h3>Diaporama</h3>                           
            </div>
            <div class="full">
                <label>Slide 1</label>
                <img src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide1.png?<?php echo time()?>">   
                <button class="blue modif_slide" i="1">Modifier</button>                       
            </div>
            <div class="full">
                <label>Slide 2</label>
                <img src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide2.png?<?php echo time()?>"> 
                <button class="blue modif_slide" i="2">Modifier</button>                          
            </div>
            <div class="full">
                <label>Slide 3</label> 
                <img src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide3.png?<?php echo time()?>">
                <button class="blue modif_slide" i="3">Modifier</button>                          
            </div>
            <div class="full">
                <label>Slide 4</label> 
                <img src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide4.png?<?php echo time()?>">
                <button class="blue modif_slide" i="4">Modifier</button>                          
            </div>
        </div>
        <br>

</center>

<div id="popup"></div>	
					<script type="text/javascript">
					$(document).ready(function(){
						function addMatiere() {
								var html = '<div class="back"></div>'+
								'<div class="goodform top">'+
									'<form action="<?php echo BASE_URL ?>parametres/ajoutMatiere" method="POST">'+
										'<div class="full"><label>Nom</label><input type="text" name="nom" required></div>'+
										'<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
									'</form>'+
								'</div>'; 
								$("#popup").html(html);
							}

							$(document).on("click", ".add_m", function(){
								sessionStorage.setItem("parametres_y", window.scrollY);
								addMatiere();
							});

							$(document).on("click", ".back", function(){
									$("#popup").html("");
								});

								$(document).on("click", ".supp_m", function(){
									$.post("<?php echo BASE_URL ?>parametres/suppMatiere", {
										id : $(this).attr("id")
									}, function() {
										sessionStorage.setItem("parametres_y", window.scrollY);
										location.reload();
									});
								});


								function addClasse(cycle) {
									var html = '<div class="back"></div>'+
									'<div class="goodform top">'+
										'<form action="<?php echo BASE_URL ?>parametres/ajoutClasse" method="POST">'+
                                            '<input type="hidden" name="cycle" value ="'+cycle+'" required>'+
                                            '<div class="half"><label>ID classe</label><input type="text" name="id" required></div>'+
                                            '<div class="half"><label>Année dans le cycle</label><input type="number" name="annee" required></div>'+
											'<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
										'</form>'+
									'</div>'; 
									$("#popup").html(html);
							}

							$(document).on("click", ".add_c", function(){
								sessionStorage.setItem("parametres_y", window.scrollY);
								addClasse($(this).attr("cycle"));
							});

							$(document).on("click", ".supp_c", function(){
									$.post("<?php echo BASE_URL ?>parametres/suppClasse", {
										id : $(this).attr("id")
									}, function() {
										sessionStorage.setItem("parametres_y", window.scrollY);
										location.reload();
									});
								});

                                function addActivite() {
									var html = '<div class="back"></div>'+
									'<div class="goodform top">'+
										'<form action="<?php echo BASE_URL ?>parametres/ajoutActivite" method="POST">'+
                                            '<div class="full"><label>Activité extrascolaire</label><input type="text" name="nom" required></div>'+
											'<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
										'</form>'+
									'</div>'; 
									$("#popup").html(html);
							}

							$(document).on("click", ".add_a", function(){
								sessionStorage.setItem("parametres_y", window.scrollY);
								addActivite();
							});

							$(document).on("click", ".supp_a", function(){
									$.post("<?php echo BASE_URL ?>parametres/suppActivite", {
										id : $(this).attr("id")
									}, function() {
										sessionStorage.setItem("parametres_y", window.scrollY);
										location.reload();
									});
								});

                                function modifSlide(i) {
									var html = '<div class="back"></div>'+
									'<div class="goodform top">'+
										'<form action="<?php echo BASE_URL ?>parametres/modifSlide" method="POST" enctype="multipart/form-data">'+
                                            '<input type="hidden" name="num" value="'+i+'" required>'+
                                            '<div class="full"><label>Slide '+i+'</label><input type="file" name="image" required><br><br><br>(taille doit être < 2M)<br><br></div>'+
											'<div class="full"><input type="submit" name="submit" value="Confirmer" class="submit blue"></div>'+
										'</form>'+
									'</div>'; 
									$("#popup").html(html);
							}

							$(document).on("click", ".modif_slide", function(){
								sessionStorage.setItem("parametres_y", window.scrollY);
								modifSlide($(this).attr("i"));
							});

                            

								var y = sessionStorage.getItem("parametres_y");
								if (y == undefined) y = 0;
								$(this).scrollTop(y);

					});

						</script>
        <?php
    }


}