<?php

class NotesView extends View {
    function __construct($params){
        parent::__construct();
        $this->controller = new Notes();

        $eleve = Session::get("eleve");
        $parent = Session::get("parent");
        $ens = Session::get("ens");
        $admin = Session::get("admin");

        $id_classe = null;
        $id_eleve = null;
        $matieres = null;

        if ($params[1] == "eleve" && ($admin || $ens || ($eleve && $eleve == $params[0]) || $parent)) {
            $id_eleve = $params[0];
            if ($parent && !$admin && !$ens && !$eleve) {
                $parent = $this->controller->checkParent($parent, $params[0]);
                if (!$parent) {
                    header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
                }
            }
            $eleve = $this->controller->getEleve($id_eleve);
            if (!$eleve) {
                header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
            }

            $notes = $this->controller->getNotesEleve($id_eleve, $eleve["id_classe"]);
            if ($notes) {
                
                foreach ($notes as $note) {
                    $matieres[$note["id_matiere"]] = $note["nom"] ;
                }
        
            }
            
            ?>
                <div class="paras-wrapper">
                    <h1>Notes de <?php echo $eleve["nom"]." ".$eleve["prenom"] ?></h1><br><br>
                </div>
                <center>
                <ul class="tabs">
                    <li>
                        <button class="tab" id="trim1">Trimestre 1</button>
                    </li>
                    <li>
                        <button class="tab" id="trim2">Trimestre 2</button>
                    </li>
                    <li>
                        <button class="tab" id="trim3">Trimestre 3</button>
                    </li>
                </ul>
            </center>
                <br>
            <div id="notes"></div>

            <script type="text/javascript">
                        $(document).ready(function(){

                        function select(id) {
                            $(".tab").css("background-color", "#fff");
                            $(".tab").css("color", "#000");
                            $(".tab").css("font-weight", "normal");
                            $(id).css("background-color", "#2771e8");
                            $(id).css("color", "#fff");
                            $(id).css("font-weight", "bold");
                        }


                            function trim(i) { 
                                sessionStorage.setItem("der_trim", "trim"+i);
                                select("#trim"+i);
                               
                                var notes = <?php echo json_encode($notes); ?>;
                                if (notes == undefined) notes = new Array();
                                var matieres = <?php echo json_encode($matieres); ?>;
                                if (matieres == undefined) matieres = new Array();
                                var html = '<div class="notes"><table><tr><th>Matière</th><th>Continu</th><th>Devoir</th><th>Examen</th><th>Moyenne</th><th>Remarque</th></tr>';
                                var k = 0;
                                notes.forEach(function(n){
                                    if (n.trimestre == i) {
                                        html += "<tr>"+
                                        '<td>'+matieres[n.id_matiere]+'</td><td>'+n.continu+'</td><td>'+n.devoir+'</td><td>'+n.examen+'</td><td>'+n.moyenne+'</td><td>'+n.remarque+'</td>'+
                                        '</tr>';
                                    }
                                });
                                html += "</table></div><br><br>";
                                $("#notes").html(html); 
                            }

                            $(document).on("click", "#trim1", function(){
                                trim("1");
                            });
                            $(document).on("click", "#trim2", function(){
                                trim("2");
                            });
                            $(document).on("click", "#trim3", function(){
                                trim("3");
                            });

                            var der_page = sessionStorage.getItem("der_trim");
                            switch (der_page) {
                                case "trim1" : trim("1"); break;
                                case "trim2" : trim("2"); break;
                                case "trim3" : trim("3"); break;
                                default : trim("1"); break;
                            }


                        });
                    </script>


            <?php

        } else if ($params[1] == "classe" && ($admin || $ens)) {
            $id_classe = $params[0];
            
            if ($admin) {
                $matieres = $this->controller->getMatieresClasse($id_classe);
            } else if ($ens) {
                $matieres = $this->controller->getMatieresEns($ens, $id_classe);
                if (!$matieres) {
                    header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
                }
            }
            $notes = null;
            $eleves = $this->controller->getEleves($id_classe);
            if (!$admin) {
                $notes = $this->controller->getNotesClasse($id_classe, $ens);
            } else {
                $notes = $this->controller->getNotesClasse($id_classe);
            }
            if ($eleves) {
                ?>   

                <div class="paras-wrapper">
                    <h1>Notes de <?php echo $id_classe ?></h1><br><br>
                </div>

                <center>
                <ul class="tabs">
                    <li>
                        <button class="tab" id="trim1">Trimestre 1</button>
                    </li>
                    <li>
                        <button class="tab" id="trim2">Trimestre 2</button>
                    </li>
                    <li>
                        <button class="tab" id="trim3">Trimestre 3</button>
                    </li>
                </ul>
            </center>
                <br>
            <div id="notes"></div>

                    <script type="text/javascript">
                        $(document).ready(function(){

                                var notes = <?php echo json_encode($notes); ?>;
                                if (notes == undefined) notes = new Array();
                                var eleves = <?php echo json_encode($eleves); ?>;
                                if (eleves == undefined) eleves = new Array();
                                var matieres = <?php echo json_encode($matieres); ?>;
                                if (matieres == undefined) matieres = new Array();

                        function select(id) {
                            $(".tab").css("background-color", "#fff");
                            $(".tab").css("color", "#000");
                            $(".tab").css("font-weight", "normal");
                            $(id).css("background-color", "#2771e8");
                            $(id).css("color", "#fff");
                            $(id).css("font-weight", "bold");
                        }


                            function trim(i) { 
                                localStorage.setItem("der_trim", "trim"+i);
                                select("#trim"+i);
                               
                                
                                var html = "";
                                matieres.forEach(function(m){
                                    html += '<div class="notes">'+
                                    '<h2 style="text-align:center;">En '+m.nom+'</h2><br><br>'+
                                    '<table><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Continu</th><th>Devoir</th><th>Examen</th><th>Moyenne</th><th>Remarque</th><th>Action</th><th>Profil</th></tr>';
                                    var k = 0;
                                    eleves.forEach(function(e){
                                        while (notes[k] != undefined && (notes[k].id_matiere != m.id_matiere || notes[k].trimestre != i)) {
                                            k++;
                                        }
                                        html += '<tr><td>'+e.id_eleve+'</td><td>'+e.nom.replace(/"/g, "'").replace(/_/g, " ")+'</td><td>'+e.prenom.replace(/"/g, "'").replace(/_/g, " ")+'</td>';
                                        if (notes[k] != undefined && notes[k].id_eleve == e.id_eleve && notes[k].id_matiere == m.id_matiere && notes[k].trimestre == i) { 
                                            html += '<td>'+notes[k].continu+'</td><td>'+notes[k].devoir+'</td><td>'+notes[k].examen+'</td><td>'+notes[k].moyenne+'</td><td>'+notes[k].remarque+'</td>'+
                                            '<td><button class="blue modif" trim="'+i+'" note="'+k+'" eleve="'+eleves.indexOf(e)+'" matiere="'+matieres.indexOf(m)+'">Modifier</button></td>';
                                            k++;
                                        } else {
                                            html += '<td></td><td></td><td></td><td></td><td></td>'+
                                            '<td><button class="blue modif" trim="'+i+'" eleve="'+eleves.indexOf(e)+'" matiere="'+matieres.indexOf(m)+'">Modifier</button></td>';
                                        }
                                        html += '<td><button class="blue voir" eleve="'+eleves.indexOf(e)+'">Voir</button></td></tr>';
                                    });
                                    html += "</table></div><br><br><br><br>";
                                    k = 0;
                                });
                                $("#notes").html(html);
 
                            }

                            $(document).on("click", "#trim1", function(){
                                trim("1");
                            });
                            $(document).on("click", "#trim2", function(){
                                trim("2");
                            });
                            $(document).on("click", "#trim3", function(){
                                trim("3");
                            });

                            var der_page = localStorage.getItem("der_trim");
                            switch (der_page) {
                                case "trim1" : trim("1"); break;
                                case "trim2" : trim("2"); break;
                                case "trim3" : trim("3"); break;
                                default : trim("1"); break;
                            }

                            $(document).on("click", ".back", function(){
                                $("#case").html("");
                            });

                            function profil(id, nom, prenom, date_n, acts) {
                                var html = '<div class="back"></div>'+
                                '<div class="goodform top">'+
                                    '<h2>Profil de '+prenom+'</h2>'+
                                    '<div class="third"><label>Nom</label><input value="'+nom+'" disabled></div>'+
                                    '<div class="third"><label>Prénom</label><input value="'+prenom+'" disabled></div>'+
                                    '<div class="third"><label>Date N.</label><input value="'+date_n+'" disabled></div>'+
                                    '<div class="third"><label>ID</label><input value="'+id+'" disabled></div>'+
                                    '<div class="third"><label>EDT</label><a href="<?php echo BASE_URL ?>emploi/id/<?php echo $id_classe ?>">Consulter EDT</a></div>'+
                                    '<div class="third"><label>Notes</label><a href="<?php echo BASE_URL ?>notes/eleve/'+id+'">Consulter notes</a></div>';
                                    if (acts.length) {
                                    html += '<div class="full">'+
                                        '<label>Activités extrascolaires</label><br>';
                                        acts.forEach(function(a){
                                            html += '<label class="chip">'+a.activite+'</label>';
                                        });
                                    }                
                                    html += '</div>'+
                                '</div>';
                                $("#case").html(html);

                            }

                            $(document).on("click", ".voir", function(){
                                var index = $(this).attr("eleve");
                                var id = eleves[index].id_eleve;
                                var nom = eleves[index].nom.replace(/"/g, "'").replace(/_/g, " ");
                                var prenom = eleves[index].prenom.replace(/"/g, "'").replace(/_/g, " ");
                                var date_n = eleves[index].date_naissance;
                                var acts = new Array();
                                $.post("<?php echo BASE_URL ?>notes/getActivites", {from:"notes", id:id}, function(data){
                                    if (data == <?php echo MISSING_DATA ?> || data == <?php echo SERVER_ERROR ?>) {
                                        location = "<?php echo BASE_URL ?>erreur/index/"+data;
                                    } else {
                                        acts = JSON.parse(data);
                                        if (acts == undefined) acts = new Array();
                                        profil(id, nom, prenom, date_n, acts);
                                    }
                                });
                            });

                            function modifier(trim, eleve, matiere, note) {
                                var cont = 0;
                                var dev = 0;
                                var exam = 0;
                                var moy = 0;
                                var rque = "";
                                if (note && notes[note]) {
                                    cont = notes[note].continu;
                                    dev = notes[note].devoir;
                                    exam = notes[note].examen;
                                    moy = notes[note].moyenne;
                                    rque = notes[note].remarque.replace(/"/g, "'");
                                }
                                var html = '<div class="back"></div>'+
                                    '<div class="goodform top">'+
                                        '<form action="<?php echo BASE_URL ?>notes/modifNotes" method="POST">'+
                                            '<h2>Notes de '+eleves[eleve].prenom.replace(/_/g, " ")+' en '+matieres[matiere].nom+' (trim. '+trim+')</h2>'+
                                            '<input type ="hidden" name="classe" value="<?php echo $id_classe ?>">'+
                                            '<input type ="hidden" name="trim" value="'+trim+'">'+
                                            '<input type ="hidden" name="eleve" value="'+eleves[eleve].id_eleve+'">'+
                                            '<input type ="hidden" name="matiere" value="'+matieres[matiere].id_matiere+'">'+
                                            '<input type ="hidden" name="from" value="classe">'+
                                            '<div class="half"><label>Continu</label><input type="number" name="cont" value="'+cont+'"></div>'+
                                            '<div class="half"><label>Devoir</label><input type="number" name="dev" value="'+dev+'"></div>'+
                                            '<div class="half"><label>Examen</label><input type="number" name="exam" value="'+exam+'"></div>'+
                                            '<div class="half"><label>Moyenne</label><input type="number" name="moy" value="'+moy+'"></div>'+
                                            '<div class="full"><label>Remarque</label><input type="text" name="rque" value="'+rque+'"></div>'+
                                            '<div class="full"><button type="submit" class="submit blue">Confirmer</button></div>'+
                                        '</form>'+
                                    '</div>'; 
                                $("#case").html(html);
                            }

                            $(document).on("click", ".modif", function(){
                                sessionStorage.setItem("notes_y", window.scrollY);
                                var trim = $(this).attr("trim");
                                var eleve = $(this).attr("eleve");
                                var matiere = $(this).attr("matiere");
                                var note = $(this).attr("note");
                                modifier(trim, eleve, matiere, note);
                            });

                            var y = sessionStorage.getItem("notes_y");
							if (y == undefined) y = 0;
							$(this).scrollTop(y);


                        });
                    </script>
                <div id="case"></div>
                <?php 
            }


        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }
}
