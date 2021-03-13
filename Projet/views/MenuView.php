<?php

class MenuView extends View {
	function __construct() {
		parent::__construct();
		$admin = Session::get("admin");
		?>
		<center><ul class="menu" <?php if ($admin) { echo 'style="text-align: left;"'; } ?>>
			<li class="drop" <?php if ($admin) { echo 'style="padding-left: 30px;"'; } ?>>
				<a href="<?php echo BASE_URL ?>accueil">Accueil</a>
			</li>
			<li class="drop">
				<a href="<?php echo BASE_URL ?>presentation">Présentation de l'école</a>
			</li>
			<li class="drop">
				<a>Cycles d'éducation</a>
				<div class="drop-cnt">
					<a href="<?php echo BASE_URL ?>primaire">Cycle Primaire</a>
					<a href="<?php echo BASE_URL ?>moyen">Cycle Moyen</a>
					<a href="<?php echo BASE_URL ?>secondaire">Cycle Secondaire</a>
				</div>
			</li>
			<li class="drop">
				<a>Espaces utilisateurs</a>
				<div class="drop-cnt">
					<a href="<?php echo BASE_URL ?>espeleve">Espace élève</a>
					<a href="<?php echo BASE_URL ?>espparent">Espace parent</a>
					<a href="<?php echo BASE_URL ?>espens">Espace enseignant</a>
				</div>
			</li>
			<li class="drop">
				<a href="<?php echo BASE_URL ?>contact">Contact</a>
			</li>
			<?php
				if ($admin) {
					?>
					<li class="drop" style="float: right; padding-right: 30px;">
						<a href="<?php echo BASE_URL ?>administration">Administration</a>
					</li>
					<?php
				}
			?>
		</ul></center>
		<?php
	}
}