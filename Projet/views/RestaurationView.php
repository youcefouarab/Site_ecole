<?php

class RestaurationView extends View {
    function __construct() {
        parent::__construct();

        $admin = Session::get("admin");

        $this->controller = new Restauration();
        $rs = $this->controller->getRestauration();
        $repas = null;
        foreach ($rs as $r) {
            $repas[$r["jour"]] = $r["repas"];
        }
        ?>
        <div class="paras-wrapper">
                <h1>Repas de cette semaine</h1><br><br>
        </div>
        <div class="repas"></div>
        <div id="case"></div>
        <script type="text/javascript">
                $(document).ready(function(){
                    var repas = <?php echo json_encode($repas); ?>;
                    if (repas == undefined) repas = new Array();
                    let jours = [];
                    jours["dim"] = "dimanche"; jours["lun"] = "lundi"; jours["mar"] = "mardi"; jours["mer"] = "mercredi";
                    jours["jeu"] = "jeudi"; jours["ven"] = "vendredi"; jours["sam"] = "samedi";
                    var html = '<div class="emploi"><table><tr><th>Dim</th><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th></tr><tr>';
                        html += '<td>'+repas["dim"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="dim">Modifier</button>';
                            <?php
                        }
                        ?>
                        html += '<td>'+repas["lun"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="lun">Modifier</button>';
                            <?php
                        }
                        ?>
                        html += '<td>'+repas["mar"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="mar">Modifier</button>';
                            <?php
                        }
                        ?>
                        html += '<td>'+repas["mer"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="mer">Modifier</button>';
                            <?php
                        }
                        ?>
                        html += '<td>'+repas["jeu"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="jeu">Modifier</button>';
                            <?php
                        }
                        ?>
                        html += '<td>'+repas["ven"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="ven">Modifier</button>';
                            <?php
                        }
                        ?>
                        html += '<td>'+repas["sam"]+'<br>';
                        <?php 
                        if ($admin) {
                            ?>
                            html += '<button class="ed_repas blue" jour="sam">Modifier</button>';
                            <?php
                        }
                        ?>                        
                        html += '</td>';
                        html += '</tr></table></div><br><br>';
                    $(".repas").first().html(html);

                    <?php
                    if ($admin) {
                        ?>
                        function setCase(jour) {
                            var html = '<div class="back"></div>'+
                                        '<div class="top goodform">'+
                                            '<h2>Modifier repas du '+jours[jour]+'</h2>'+
                                            '<form action="<?php echo BASE_URL ?>restauration/modifRestauration" method="POST">'+
                                                '<input type ="hidden" name="jour" value="'+jour+'">'+
                                                '<div class="full"><textarea rows="10" name="repas">'+repas[jour].replace(/<br\s*[\/]?>/gi, "")+'</textarea></div>'+
                                                '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                            '</form>'+
                                        '</div>'; 
                            $("#case").html(html);
                        }

                        $(document).on("click", ".back", function(){
                            $("#case").html("");
                        });

                        $(document).on("click", ".ed_repas", function(){
                            setCase($(this).attr("jour"));
                        });

                    <?php
                    }
                    ?>

                });
            </script>
        <?php
    }
}