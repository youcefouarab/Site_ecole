<?php

class CadreView {
	function __construct($titre, $image, $desciption, $link, $date = false) {
        ?>
        <div class="cadre">
            <div class="image">
                <img src="<?php 
                if ($image) echo BASE_URL.PUBLIC_CNT."img/".$image."?".time();
                else echo BASE_URL.PUBLIC_CNT."img/default.png?".time();
                ?>">
            </div>
            <div class="fade-img"></div>
            <div class="titre">
                <h3>
                    <?php echo $titre; ?>
                </h3>
            </div>
            <?php
            if ($date) {
                ?>
                <br>
                <div class="date">
                    <hr>
                    <label><?php echo $date; ?></label>
                </div>
                <?php
            }
            if ($desciption) {
            ?>
                <div class="description">
                    <p>
                        <?php echo $desciption; ?>
                    </p>
                </div>
            <?php
            }
            if ($desciption != "") echo '<div class="fade-desc"></div>' ; ?>
            <div class="suite">
                <a href="<?php echo $link; ?>">Accéder</a>
            </div>
        </div>
        <?php
    }
}