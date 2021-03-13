<?php

class ErreurView extends View {
    
    function __construct($err = "") {
        parent::__construct();
        ?>
        <div class="paras-wrapper">
            <h1>Oops!</h1>
        </div>
        <center>
            <h2><?php echo $err ?></h2>
        </center>
        <?php
        exit();
    }


}

