<?php

class DiaporamaView extends View {
	function __construct() {
		parent::__construct();
		?>
		<div class="diapo">
			<img class="slide" src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide1.png?<?php echo time()?>">
			<img class="slide" src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide2.png?<?php echo time()?>">
			<img class="slide" src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide3.png?<?php echo time()?>">
			<img class="slide" src="<?php echo BASE_URL.PUBLIC_CNT ?>img/slide4.png?<?php echo time()?>">
		</div>
		<?php
	}
}

