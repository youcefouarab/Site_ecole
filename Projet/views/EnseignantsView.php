<?php

class EnseignantsView extends View {
    
    function __construct($cycle = null) {
        parent::__construct();

		if ($cycle && $cycle != "primaire" && $cycle != "moyen" && $cycle != "secondaire") {
            header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
        }

		$admin = Session::get("admin");

            $this->controller = new Enseignants();
			$all_matieres = null;
			$all_classes = null;
			if ($admin) {
				$all_matieres = $this->controller->getMatieres();
				$all_classes = $this->controller->getClasses();
			}
			$ens = null;
			$of = "";

			if ($cycle) {
				$ens = $this->controller->getEnseignantsCycle($cycle);
				$of = " du cycle ".$cycle;
			} else {
				$ens = $this->controller->getEnseignants();
			}

            ?>
            <div class="paras-wrapper">
                <h1>Enseignants<?php echo $of ?></h1><br><br>
            </div>
            <center>
            <?php
                foreach ($ens as $en) {
                    ?>
					<div class="user">
						<div class="profil">
							<h3><?php echo $en["nom"]." ".$en["prenom"] ?></h3>
						</div>
						<div class="section">
							<h4>Récéption</h4>
							<?php
							if ($admin) {
								?>
								<button class="blue add_r" ens="<?php echo $en["id_enseignant"] ?>">+</button>
								<?php
							}
							?>
							<br>
							<?php
							$reception = $this->controller->getReception($en["id_enseignant"]);
							foreach ($reception as $r) {
								?>
								<label><?php echo $r["jour"]." ".substr($r["debut"], 0, 5)." - ".substr($r["fin"], 0, 5);
								
								if ($admin) {
									?>
									<button class="red supp_r" ens="<?php echo $en["id_enseignant"] ?>" jour="<?php echo $r["jour"] ?>" debut="<?php echo $r["debut"] ?>">x</button>
								<?php
								}
								?>
								</label>
								<?php
							}
							
							?>
						</div>

						<?php 
						if ($admin) {
							?>
						<div class="section">
							<h4>Classes</h4><button class="blue add_c" ens="<?php echo $en["id_enseignant"] ?>">+</button><br>
							<?php
							$classes = $this->controller->getClassesEns($en["id_enseignant"]);
							foreach ($classes as $c) {
								?>
								<label><?php echo $c["id_classe"]." (".$c["nom"].")" ?>
								<button class="red supp_c" matiere="<?php echo $c["id_matiere"] ?>" ens="<?php echo $en["id_enseignant"] ?>" classe="<?php echo $c["id_classe"] ?>">x</button></label>
								<?php
							}
							?>
						</div>
						<a href="<?php echo BASE_URL ?>emploi/ens/<?php echo $en["id_enseignant"] ?>">Heures de travail</a>
						<?php
						}
						?>
					</div>


					<?php
					}

					if ($admin) {
						?>

					<div id="popup"></div>	
					<script type="text/javascript">
					$(document).ready(function(){
						function addReception(ens) {
								var html = '<div class="back"></div>'+
								'<div class="goodform top">'+
									'<form action="<?php echo BASE_URL ?>enseignants/ajoutReception" method="POST">'+
										'<input type ="hidden" name="ens" value="'+ens+'">'+
										'<div class="third"><label>Jour</label>'+
											'<select name="jour" required>'+
												'<option value="">--Jour--</option>'+
												'<option value="dim">Dimanche</option>'+
												'<option value="lun">Lundi</option>'+
												'<option value="mar">Mardi</option>'+
												'<option value="mer">Mercredi</option>'+
												'<option value="jeu">Jeudi</option>'+
												'<option value="ven">Vendredi</option>'+
												'<option value="sam">Samedi</option>'+
											'</select>'+
										'</div>'+
										'<div class="third"><label>Commence à</label><input type="time" id="debut" name="debut" required></div>'+
										'<div class="third"><label>Se termine à</label><input type="time" id="fin" name="fin" required></div>'+
										'<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
									'</form>'+
								'</div>'; 
								$("#popup").html(html);
							}

							$(document).on("click", ".add_r", function(){
								sessionStorage.setItem("enseignants_y", window.scrollY);
								addReception($(this).attr("ens"));
							});

							$(document).on("click", ".back", function(){
									$("#popup").html("");
								});

								$(document).on("click", ".supp_r", function(){
									$.post("<?php echo BASE_URL ?>enseignants/suppReception", {
										ens : $(this).attr("ens"),
										jour : $(this).attr("jour"),
										debut : $(this).attr("debut")
									}, function() {
										sessionStorage.setItem("enseignants_y", window.scrollY);
										location.reload();
									});
								});


								function addClasse(ens) {
									var classes = <?php echo json_encode($all_classes); ?>;
									if (classes == undefined) classes = new Array();
									var matieres = <?php echo json_encode($all_matieres); ?>;
									if (matieres == undefined) matieres = new Array();
									var html = '<div class="back"></div>'+
									'<div class="goodform top">'+
										'<form action="<?php echo BASE_URL ?>enseignants/ajoutClasse" method="POST">'+
											'<input type ="hidden" name="ens" value="'+ens+'">'+
											'<div class="half"><label>Classe</label>'+
												'<select name="classe" required>'+
													'<option value="">--Classe--</option>';
													classes.forEach(function(c){
														html += '<option value="'+c.id_classe+'">'+c.id_classe+'</option>'; 
													});

											html += '</select>'+
											'</div>'+
											'<div class="half"><label>Matière</label>'+
												'<select name="matiere" required>'+
													'<option value="">--Matière--</option>';
													matieres.forEach(function(m){
														html += '<option value="'+m.id_matiere+'">'+m.nom+'</option>'; 
													});

											html += '</select>'+
											'</div>'+
											'<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
										'</form>'+
									'</div>'; 
									$("#popup").html(html);
							}

							$(document).on("click", ".add_c", function(){
								sessionStorage.setItem("enseignants_y", window.scrollY);
								addClasse($(this).attr("ens"));
							});

							$(document).on("click", ".supp_c", function(){
									$.post("<?php echo BASE_URL ?>enseignants/suppClasse", {
										ens : $(this).attr("ens"),
										classe : $(this).attr("classe"),
										matiere : $(this).attr("matiere")
									}, function() {
										sessionStorage.setItem("enseignants_y", window.scrollY);
										location.reload();
									});
								});

								var y = sessionStorage.getItem("enseignants_y");
								if (y == undefined) y = 0;
								$(this).scrollTop(y);

					});

						</script>


						<?php
					}
                
            ?>
        </center>

		<?php
        
    }

}


