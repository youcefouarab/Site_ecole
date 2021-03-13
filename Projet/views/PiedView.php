<?php 

class PiedView extends View {
    function __construct() {
        parent::__construct();
        ?>
        <footer>
            <ul>
                <li><b>L'école</b></li>
                <li><a href="<?php echo BASE_URL ?>accueil">Accueil</a></li>
                <li><a href="<?php echo BASE_URL ?>presentation">Présentation</a></li>
            </ul>
            <ul>
                <li><b>Cycles</b></li>
                <li><a href="<?php echo BASE_URL ?>primaire">Primaire</a></li>
                <li><a href="<?php echo BASE_URL ?>moyen">Moyen</a></li>
                <li><a href="<?php echo BASE_URL ?>secondaire">Secondaire</a></li>
            </ul>
            <ul>
                <li><b>Espaces</b></li>
                <li><a href="<?php echo BASE_URL ?>espeleve">Elèves</a></li>
                <li><a href="<?php echo BASE_URL ?>espparent">Parents</a></li>
                <li><a href="<?php echo BASE_URL ?>espens">Enseignants</a></li>
            </ul>
            <ul>
                <li><b>Contact</b></li>
                <li><a href="<?php echo BASE_URL ?>contact">Contact</a></li>
            </ul>
            <div class="copyright">
                Copyright (C) OUARAB YOUCEF - 2021
            </div>
        </footer>
        </body>
        </html>
        <?php
    }
}
