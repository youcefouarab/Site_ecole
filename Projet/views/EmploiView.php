<?php

class EmploiView extends View {
    function __construct($classe){
        parent::__construct();

        $admin = Session::get("admin");

        $this->controller = new Emploi();
        $classes = $this->controller->getClasses();
        $exist = false;
        foreach ($classes as $c) {
            if ($c["id_classe"] == $classe) $exist = true;
        }
        if (!$exist) {
            header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
        }
        $matieres = $this->controller->getMatieres();
        $ms = null;
        foreach ($matieres as $matiere) {
            $ms[$matiere["id_matiere"]] = $matiere["nom"];
        } 
        $enseignants = $this->controller->getEnseignants();
        $ens = null;
        foreach ($enseignants as $enseignant) {
            $ens[$enseignant["id_enseignant"]] = $enseignant["nom"]." ".$enseignant["prenom"][0].".";
        }
        $emploi = $this->controller->getEmploi($classe);
        ?>   

        <div class="paras-wrapper">
            <h1>Emploi du temps de <?php echo $classe ?></h1><br><br>
        </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    var emploi = <?php echo json_encode($emploi); ?>;
                    if (emploi == undefined) emploi = new Array();
                    var matieres = <?php echo json_encode($ms); ?>;
                    if (matieres == undefined) matieres = new Array();
                    var ens = <?php echo json_encode($ens); ?>;
                    if (ens == undefined) ens = new Array();
                    var html = '<div class="emploi"><table><tr><th>Dim</th><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th></tr>';
                    var k = 0;
                    for (var i = 1; i <= 10; i++) {
                        html += "<tr>";
                        for (var j = 1; j <= 7; j++) {
                            if (emploi[k] != undefined && emploi[k].jour == j && emploi[k] != undefined && emploi[k].periode == i) {
                                html += '<td>'+
                                    matieres[emploi[k].id_matiere]+'<br>'+
                                    ens[emploi[k].id_enseignant]+'<br>'+
                                    emploi[k].debut.substring(0,5)+
                                    ' - '+emploi[k].fin.substring(0,5)+'<br>'+
                                    emploi[k].salle+'<br>';
                                    <?php 
                                    if ($admin) {
                                        ?>
                                        html += '<button class="ed_emploi blue" periode="'+i+'" jour="'+j+'" emp="'+k+'">Modifier</button>'+
                                        '<button class="supp_emploi red" emp="'+k+'">Supprimer</button>';

                                        <?php
                                    }
                                    ?>
                                html += '</td>';
                                k++;
                            }
                            else {
                                html += '<td>';
                                <?php
                                if ($admin) {
                                    ?>
                                    html += '<button periode="'+i+'" jour="'+j+'" class="aj_emploi">+</button>';
                                    <?php
                                }
                                ?>
                                html += '</td>';
                            }
                        }
                        html += "</tr>";

                    }
                    html += "</table></div><br><br>";
                    $("#emploi").html($("#emploi").html()+html);

                    <?php 
                    if ($admin) {
                        ?>
                    function setCase(jour, periode, action, k=null) {
                        let jours = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
                        var html = '<div class="back"></div>'+
                                    '<div class="goodform top">';
                            if (action == "ajout") html+='<form action="<?php echo BASE_URL ?>emploi/addEmploi" method="POST">';
                            else if (action == "modif") html+='<form action="<?php echo BASE_URL ?>emploi/modifEmploi" method="POST">';
                            else return;
                            html += '<h2><?php echo $classe ?> - '+jours[jour-1]+' - Periode '+periode+'</h2>'+
                                            '<input type ="hidden" name="classe" value="<?php echo $classe ?>">'+
                                            '<input type ="hidden" name="jour" value="'+jour+'">'+
                                            '<input type ="hidden" name="periode" value="'+periode+'">'+
                                            '<input type ="hidden" name="from" value="id">'+
                                            '<div class="half"><label>Matière</label>'+
                                            '<select name="matiere" id="matiere" required>'+
                                                '<option value="">--Matière--</option>';
                                                <?php
                                                    foreach($matieres as $matiere) {
                                                    ?>
                                                        var m_id = "<?php echo $matiere["id_matiere"]; ?>";
                                                        var m_nom = "<?php echo addslashes($matiere["nom"]); ?>";
                                                        html += '<option id="m'+m_id+'" value="'+m_id+'">'+m_nom+'</option>';
                                                    <?php
                                                    }
                                                ?>
                                            html += '</select></div>'+
                                            '<div class="half"><label>Enseignant</label>'+
                                            '<select name="ens" id="ens" required>'+
                                                '<option value="">--Enseignant--</option>';
                                                <?php
                                                    foreach($enseignants as $en) {
                                                    ?>
                                                        var s_id = "<?php echo $en["id_enseignant"]; ?>";
                                                        var s_nom = "<?php echo addslashes($en["id_enseignant"].' - '.$en["nom"].' '.$en["prenom"]); ?>";
                                                        html += '<option id="'+s_id+'" value="'+s_id+'">'+s_nom+'</option>';
                                                    <?php
                                                    }
                                                ?>
                                            html += '</select></div>'+
                                            '<div class="half"><label>Commence à</label><input type="time" id="debut" name="debut" required></div>'+
                                            '<div class="half"><label>Se termine à</label><input type="time" id="fin" name="fin" required></div>'+
                                            '<div class="full"><label>Salle</label><input type="text" id="salle" name="salle" required></div>'+
                                            '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                        '</form>'+
                                    '</div>'; 
                        $("#case").html(html);
                    }

                    $(document).on("click", ".back", function(){
                        $("#case").html("");
                    });

                    $(document).on("click", ".aj_emploi", function(){
                        setCase($(this).attr("jour"),$(this).attr("periode"), "ajout");
                    });

                    $(document).on("change", "#matiere", function(){
                        if (!$("#matiere").val()) {
                            $.post("<?php echo BASE_URL ?>emploi/getEnseignants", {from:"emploi"}, function(data){
                                var es = JSON.parse(data);
                                if (es == undefined) es = new Array();
                                var html = '<option value="">--Enseignant--</option>';
                                es.forEach(function(e){
                                    var e_id = e.id_enseignant;
                                    var e_nom = e_id+" - "+e.nom+" "+e.prenom;
                                    html += '<option id="'+e_id+'" value="'+e_id+'">'+e_nom+'</option>';
                                });                                            
                                $("#ens").html(html);
                            });
                        } else {
                            $.post("<?php echo BASE_URL ?>emploi/getEnsMatiere", {from:"emploi", id:$("#matiere").val(), classe:"<?php echo $classe ?>"}, function(data){
                                var es = JSON.parse(data);
                                if (es == undefined) es = new Array();
                                var html = '';
                                es.forEach(function(e){
                                    var e_id = e.id_enseignant;
                                    var e_nom = e_id+" - "+e.nom+" "+e.prenom;
                                    html += '<option id="'+e_id+'" value="'+e_id+'">'+e_nom+'</option>';
                                });                                            
                                $("#ens").html(html);
                            });
                        }
                    });

                    $(document).on("click", ".supp_emploi", function(){
                        $.post("<?php echo BASE_URL ?>emploi/suppEmploi", {
                            classe : emploi[$(this).attr("emp")].id_classe,
                            jour : emploi[$(this).attr("emp")].jour,
                            periode : emploi[$(this).attr("emp")].periode,
                            from : "id"
                        }, function() {
                            location.reload(true);
                        });
                    });
                    
                    $(document).on("click", ".ed_emploi", function(){
                        setCase($(this).attr("jour"),$(this).attr("periode"), "modif", $(this).attr("emp"));
                        $("#m"+emploi[$(this).attr("emp")].id_matiere).attr("selected", "selected");
                        $("#"+emploi[$(this).attr("emp")].id_enseignant).attr("selected", "selected");
                        $("#debut").val(emploi[$(this).attr("emp")].debut);
                        $("#fin").val(emploi[$(this).attr("emp")].fin);
                        $("#salle").val(emploi[$(this).attr("emp")].salle);

                    });

                    <?php 
                    }
                    ?>
                });
            </script>
            <div id="emploi"></div>
            <div id="case"></div>
        <?php
    }
}
