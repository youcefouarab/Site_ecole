<?php

class ContactView extends View {
    
    function __construct() {
        parent::__construct();

        $admin = Session::get("admin");

            $this->controller = new Contact();
            $contacts = $this->controller->getContacts();

            $cles = array(
                "tel" => "Téléphone : ",
                "fax" => "Fax : ",
                "email" => "Email : ",
                "adr" => "Adresse : ",
                "fb" => "Facebook : ",
                "twt" => "Twitter : ",
                "ig" => "Instagram : ",
                "sc" => "Snapchat : ",
                "yt" => "YouTube : ",
            );

            $imgs = array(
                "tel" => BASE_URL.PUBLIC_CNT."img/tel.png",
                "fax" => BASE_URL.PUBLIC_CNT."img/fax.png",
                "email" => BASE_URL.PUBLIC_CNT."img/email.png",
                "adr" => BASE_URL.PUBLIC_CNT."img/adr.png",
                "fb" => BASE_URL.PUBLIC_CNT."img/fb.png",
                "twt" => BASE_URL.PUBLIC_CNT."img/twt.png",
                "ig" => BASE_URL.PUBLIC_CNT."img/ig.png",
                "sc" => BASE_URL.PUBLIC_CNT."img/sc.png",
                "yt" => BASE_URL.PUBLIC_CNT."img/yt.png",
            );

            ?>
            <div class="paras-wrapper">
                <h1>Contact</h1><br><br>
            </div>
<center>
            <div class="contacts-wrapper">
            <?php
            
            if ($contacts) {
                foreach ($contacts as $contact) {
                    ?>
                    <div class="contact">
                        <img src="<?php echo $imgs[$contact["cle"]] ?>">
                        <label class="contact-cle"><?php echo $cles[$contact["cle"]] ?></label>
                        <label class="contact-val"><?php echo $contact["valeur"] ?></label>
                        <?php 
                            if ($admin) {
                                ?>
                                <button class="red supp" id="<?php echo $contact["id_contact"] ?>">x</button>
                                <?php
                            }
                        ?>
                    </div>
                    <?php 
                }
            }
            ?>
            </div>
</center><br>
            <?php

            if ($admin) {
            ?>
                <div class="linktoall"><button class="blue add">Nouveau contact</button></div>

<div id="popup"></div>	
<script type="text/javascript">
$(document).ready(function(){
    function add() {
            var html = '<div class="back"></div>'+
            '<div class="goodform top">'+
                '<form action="<?php echo BASE_URL ?>contact/ajoutContact" method="POST">'+
                    '<div class="half"><label>Moyen</label>'+
                        '<select name="cle" required>'+
                            '<option value="">--Moyen--</option>'+
                            '<option value="tel">Téléphone</option>'+
                            '<option value="fax">Fax</option>'+
                            '<option value="email">Email</option>'+
                            '<option value="adr">Adresse</option>'+
                            '<option value="fb">Facebook</option>'+
                            '<option value="twt">Twitter</option>'+
                            '<option value="ig">Instagram</option>'+
                            '<option value="sc">Snapchat</option>'+
                            '<option value="yt">YouTube</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="half"><label>Contact</label><input type="text" name="val" required></div>'+
                    '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                '</form>'+
            '</div>'; 
            $("#popup").html(html);
        }

        $(document).on("click", ".add", function(){
            sessionStorage.setItem("contact_y", window.scrollY);
            add();
        });

        $(document).on("click", ".back", function(){
                $("#popup").html("");
            });

            $(document).on("click", ".supp", function(){
                $.post("<?php echo BASE_URL ?>contact/suppContact", {
                    id : $(this).attr("id")
                }, function() {
                    sessionStorage.setItem("contact_y", window.scrollY);
                    location.reload();
                });
            });

            var y = sessionStorage.getItem("contact_y");
            if (y == undefined) y = 0;
            $(this).scrollTop(y);

});

    </script>

    <?php
        } 
    }

}