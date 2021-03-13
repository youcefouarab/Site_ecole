<?php

class EnteteView extends View {
    
    function __construct($titre = "") {
        parent::__construct();

        require_once CONTROLLERS."contact.php";
        $this->controller = new Contact();
        $contacts = $this->controller->getContacts();

        $socials = array("fb", "twt", "ig", "sc", "yt");

        $links = array(
            "fb" => "https://facebook.com/",
            "twt" => "https://twitter.com/",
            "ig" => "https://instagram.com/",
            "sc" => "https://snapchat.com/",
            "yt" => "https://youtube.com/",
        );

        $imgs = array(
            "fb" => BASE_URL.PUBLIC_CNT."img/fb.png",
            "twt" => BASE_URL.PUBLIC_CNT."img/twt.png",
            "ig" => BASE_URL.PUBLIC_CNT."img/ig.png",
            "sc" => BASE_URL.PUBLIC_CNT."img/sc.png",
            "yt" => BASE_URL.PUBLIC_CNT."img/yt.png",
        );

        header('Content-type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php echo $titre ?> - <?php echo rtrim(PROJECT_NAME, "/") ?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
            <meta http-equiv="Pragma" content="no-cache" />
            <meta http-equiv="Expires" content="0" />
            <meta name="author" content=""/>
            <meta name="description" content="" />
            <meta name="keywords" content=""/>
            <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.PUBLIC_CNT; ?>css/style.css?<?php echo time()?>">
            <script type="text/javascript" src="<?php echo BASE_URL.PUBLIC_CNT; ?>js/jquery-3.3.1.js"></script>
	        <script type="text/javascript" src="<?php echo BASE_URL.PUBLIC_CNT; ?>js/jquery-3.3.1.min.js"></script>
        </head>
        <body>
            <header>
                <div class="logo">
                    <img src="<?php echo BASE_URL.PUBLIC_CNT; ?>img/logo.png?<?php echo time()?>" alt="Logo">
                </div>
                <div class="socials">
                    <?php
                    if ($contacts) {
                        foreach ($contacts as $contact) {
                            if (in_array($contact["cle"], $socials)) {
                            ?>
                                <a href="<?php echo $links[$contact["cle"]].$contact["valeur"] ?>"><img src="<?php echo $imgs[$contact["cle"]] ?>?<?php echo time() ?>"></a>
                            <?php
                            }
                        }
                    }
                    ?>
                </div>
            </header>
        <?php
    }


}

