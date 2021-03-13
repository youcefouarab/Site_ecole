<?php

class UtilisateursView extends View {

    function __construct() {
        parent::__construct();
        $this->controller = new Utilisateurs();

        $admin = Session::get("admin");

        ?>

        <div class="paras-wrapper">
            <h1>Gestion des utilisateurs</h1><br><br>
        </div>
            <center>
                <ul class="tabs">
                    <li>
                        <button class="tab" id="eleves">Eleves</button>
                    </li>
                    <li>
                        <button class="tab" id="parents">Parents</button>
                    </li>
                    <li>
                        <button class="tab" id="ens">Enseignants</button>
                    </li>
                    <li>
                        <button class="tab" id="admins">Admins</button>
                    </li>
                </ul>
                <div id="page"></div>
            </center>

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

                    function eleves() {
                        sessionStorage.setItem("der_admin", "eleves");
                        select("#eleves");
                        var html = '<br><div class="linktoall"><a href="<?php echo BASE_URL ?>eleve/id/new">Nouvel élève</a></div><br><br>';
                        var users = <?php echo json_encode($this->controller->getEleves()); ?>;
                        if (users.length) {
                            html += '<div class="users">'+
                            '<table>'+
                                '<tr>'+
                                    '<th>ID</th>'+
                                    '<th>Nom</th>'+
                                    '<th>Prénom</th>'+
                                    '<th>Date N.</th>'+
                                    '<th>Classe</th>'+
                                    '<th>Parent</th>'+
                                    '<th>Adresse</th>'+
                                    '<th>Tel. 1</th>'+
                                    '<th>Tel. 2</th>'+
                                    '<th>Tel. 3</th>'+
                                    '<th>Email</th>'+
                                    '<th>Action</th>'+
                                '</tr>';
                            
                            users.forEach(function(e){
                                html += "<tr>"+
                                    "<td>"+e.id_eleve+"</td>"+
                                    "<td>"+e.nom.replace("_", " ")+"</td>"+
                                    "<td>"+e.prenom.replace("_", " ")+"</td>"+
                                    "<td>"+e.date_naissance+"</td>"+
                                    "<td>"+e.id_classe+"</td>"+
                                    '<td><button class="blue"><a href="<?php echo BASE_URL ?>parents/id/'+e.id_parent+'">Voir</a></button>'+
                                    "<td>"+e.adresse+"</td>"+
                                    "<td>"+e.tel1+"</td>"+
                                    "<td>"+e.tel2+"</td>"+
                                    "<td>"+e.tel3+"</td>"+
                                    "<td>"+e.email+"</td>"+
                                    '<td><button class="blue"><a href="<?php echo BASE_URL ?>eleve/id/'+e.id_eleve+'">Modifier</a></button>'+
                                    '<button eid="'+e.id_eleve+'" class="e_supp red">Supprimer</button></td>'+
                                "</tr>";
                            });
                            html += "</table>";
                        }
                        $("#page").html(html);

                    }

                    $(document).on("click", "#eleves", function(){
                        eleves();
                    });

                    $(document).on("click", ".e_supp", function(){
                        var id = $(this).attr("eid");
                        $.post("<?php echo BASE_URL ?>utilisateurs/suppEleve", {id:id}, function(){
                            sessionStorage.setItem("utilisateurs_y", window.scrollY);
                            document.location.reload();
                        });
                    });

                    function parents() {
                        sessionStorage.setItem("der_admin", "parents");
                        select("#parents");
                        var html = '<br><div class="linktoall"><a href="<?php echo BASE_URL ?>parents/id/new">Nouveau parent</a></div><br><br>';
                        var users = <?php echo json_encode($this->controller->getParents()); ?>;
                        if (users.length) {
                            html += '<div class="users">'+
                            '<table>'+
                                '<tr>'+
                                    '<th>ID</th>'+
                                    '<th>Nom</th>'+
                                    '<th>Prénom</th>'+
                                    '<th>Date N.</th>'+
                                    '<th>Adresse</th>'+
                                    '<th>Tel. 1</th>'+
                                    '<th>Tel. 2</th>'+
                                    '<th>Tel. 3</th>'+
                                    '<th>Email</th>'+
                                    '<th>Action</th>'+
                                '</tr>';
                            users.forEach(function(e){
                                html += "<tr>"+
                                    "<td>"+e.id_parent+"</td>"+
                                    "<td>"+e.nom.replace("_", " ")+"</td>"+
                                    "<td>"+e.prenom.replace("_", " ")+"</td>"+
                                    "<td>"+e.date_naissance+"</td>"+
                                    "<td>"+e.adresse+"</td>"+
                                    "<td>"+e.tel1+"</td>"+
                                    "<td>"+e.tel2+"</td>"+
                                    "<td>"+e.tel3+"</td>"+
                                    "<td>"+e.email+"</td>"+
                                    '<td><button class="blue"><a href="<?php echo BASE_URL ?>parents/id/'+e.id_parent+'">Modifier</a></button>'+
                                    '<button pid="'+e.id_parent+'" class="p_supp red">Supprimer</button></td>'+
                                "</tr>";
                            });
                            html += "</table>";	

                        }
                        $("#page").html(html);
                    }

                    $(document).on("click", "#parents", function(){
                        parents();
                    });

                    $(document).on("click", ".p_supp", function(){
                        var id = $(this).attr("pid");
                        $.post("<?php echo BASE_URL ?>utilisateurs/suppParent", {id:id}, function(){
                            sessionStorage.setItem("utilisateurs_y", window.scrollY);
                            document.location.reload();
                        });
                    });

                    function enseignants() {
                        sessionStorage.setItem("der_admin", "enseignants");
                        select("#ens");
                        var html = '<br><div class="linktoall"><a href="<?php echo BASE_URL ?>enseignant/id/new">Nouvel enseignant</a></div><br><br>';
                        var users = <?php echo json_encode($this->controller->getEnseignants()); ?>;
                        if (users.length) {
                            html += '<div class="users">'+
                            '<table>'+
                                '<tr>'+
                                    '<th>ID</th>'+
                                    '<th>Nom</th>'+
                                    '<th>Prénom</th>'+
                                    '<th>Adresse</th>'+
                                    '<th>Tel. 1</th>'+
                                    '<th>Tel. 2</th>'+
                                    '<th>Tel. 3</th>'+
                                    '<th>Email</th>'+
                                    '<th>Action</th>'+
                                '</tr>';
                            users.forEach(function(e){
                                html += "<tr>"+
                                    "<td>"+e.id_enseignant+"</td>"+
                                    "<td>"+e.nom.replace("_", " ")+"</td>"+
                                    "<td>"+e.prenom.replace("_", " ")+"</td>"+
                                    "<td>"+e.adresse+"</td>"+
                                    "<td>"+e.tel1+"</td>"+
                                    "<td>"+e.tel2+"</td>"+
                                    "<td>"+e.tel3+"</td>"+
                                    "<td>"+e.email+"</td>"+
                                    '<td><button class="blue"><a href="<?php echo BASE_URL ?>enseignant/id/'+e.id_enseignant+'">Modifier</a></button>'+
                                    '<button sid="'+e.id_enseignant+'" class="s_supp red">Supprimer</button></td>'+
                                "</tr>";
                            });
                            html += "</table>";

                        }
                        $("#page").html(html);
                    }

                    $(document).on("click", "#ens", function(){
                        enseignants();
                    });

                    $(document).on("click", ".s_supp", function(){
                        var id = $(this).attr("sid");
                        $.post("<?php echo BASE_URL ?>utilisateurs/suppEnseignant", {id:id}, function(){
                            sessionStorage.setItem("utilisateurs_y", window.scrollY);
                            document.location.reload();
                        });
                    });

                    function admins() {
                        sessionStorage.setItem("der_admin", "admins");
                        select("#admins");
                        var html = '<br>';
                        if (<?php echo $admin ?> === 1) {
                            html += '<div class="linktoall"><a href="<?php echo BASE_URL ?>admin/id/new">Nouvel admin</a></div>';
                        }
                        html += '<br><br>';
                        var users = <?php echo json_encode($this->controller->getAdmins()); ?>;
                        if (users.length) {
                            html += '<div class="users">'+
                            '<table>'+
                                '<tr>'+
                                    '<th>ID</th>'+
                                    '<th>Nom</th>'+
                                    '<th>Prénom</th>'+
                                    '<th>Adresse</th>'+
                                    '<th>Tel. 1</th>'+
                                    '<th>Tel. 2</th>'+
                                    '<th>Tel. 3</th>'+
                                    '<th>Email</th>'+
                                    '<th>Action</th>'+
                                '</tr>';
                            users.forEach(function(e){
                                if (e.login == "admin") html += '<tr class="admin">';
                                else html += "<tr>";
                                html +="<td>"+e.id_admin+"</td>"+
                                    "<td>"+e.nom.replace("_", " ")+"</td>"+
                                    "<td>"+e.prenom.replace("_", " ")+"</td>"+
                                    "<td>"+e.adresse+"</td>"+
                                    "<td>"+e.tel1+"</td>"+
                                    "<td>"+e.tel2+"</td>"+
                                    "<td>"+e.tel3+"</td>"+
                                    "<td>"+e.email+"</td><td>";
                                    if (e.id_admin == <?php echo Session::get("admin") ?> || <?php echo Session::get("admin") ?> === 1) {
                                        html += '<button class="blue"><a href="<?php echo BASE_URL ?>admin/id/'+e.id_admin+'">Modifier</a></button>';
                                    }
                                    if (e.id_admin != 1 && <?php echo Session::get("admin") ?> === 1) {
                                        html += '<button aid="'+e.id_admin+'" class="a_supp red">Supprimer</button>';
                                    }
                                html += "</td></tr>";
                            });
                            html += "</table>";

                        }
                        $("#page").html(html);
                    }

                    $(document).on("click", "#admins", function(){
                        admins();
                    });

                    <?php 
                    if ($admin === '1') {
                        ?>

                        $(document).on("click", ".a_supp", function(){
                            var id = $(this).attr("aid");
                            $.post("<?php echo BASE_URL ?>utilisateurs/suppAdmin", {id:id}, function(){
                                sessionStorage.setItem("utilisateurs_y", window.scrollY);
                                document.location.reload();
                            });
                        });

                        <?php
                    }
                    ?>

                    var der_page = sessionStorage.getItem("der_admin");
                    switch (der_page) {
                        case "eleves" : eleves(); break;
                        case "parents" : parents(); break;
                        case "enseignants" : enseignants(); break;
                        case "admins" : admins(); break;
                        default : eleves(); break;
                    }

                    var y = sessionStorage.getItem("utilisateurs_y");
                    if (y == undefined) y = 0;
                    $(this).scrollTop(y);

                });
            </script>

        <?php
        
    }

}