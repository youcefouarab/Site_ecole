<?php

class EmploisView extends View {
    function __construct($cycle = null){
        parent::__construct();

        $admin = Session::get("admin");

        $this->controller = new Emplois();

        if ($cycle && $cycle != "primaire" && $cycle != "moyen" && $cycle != "secondaire") {
            header("location: ".BASE_URL."erreur/index/".PAGE_INEX);
        }
        $classes = $this->controller->getClasses($cycle);

        if ($admin) {
        ?>
        <div class="newemp">
            <select id="classe" required>
                <option value="">--Classe--</option>
                <?php
                foreach ($classes as $classe) {
                ?>    
                    <option value="<?php echo $classe["id_classe"]; ?>"><?php echo $classe["id_classe"]; ?></option>   
                <?php
                }
                ?>
            </select>
            <div class="linktoall"><button type="submit" id="aj_emploi">Nouvel emploi du temps</button></div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $(document).on("click", "#aj_emploi", function(){
                        var classe = $("#classe option:selected").val();
                        if (classe) location = "<?php echo BASE_URL ?>emploi/id/"+classe;
                        else alert("Veuillez choisir la classe");
                    });
                });
            </script>
        </div>
        <?php
        }

        $q = "";
        if ($cycle) $q = " des ".$cycle."s";
        ?>
        <div class="paras-wrapper">
            <h1>Emplois du temps<?php echo $q ?></h1><br><br>
        </div>
        <div class="emps-wrapper">
        <?php
        foreach ($classes as $classe) {
            $emploi = $this->controller->getEmploi($classe["id_classe"]);
            if (!empty($emploi)) {
            ?>
                <div class="emp">
                    <div class="titre">
                        <h3>EDT de <?php echo $classe["id_classe"]; ?></h3>
                    </div>
                    <div class="linktoall">
                        <a href="<?php echo BASE_URL ?>emploi/id/<?php echo $classe["id_classe"] ?>">Accéder</a>
                    </div>
                </div>
            <?php
            }
        }
        ?>
        </div>
        <?php
    }
}