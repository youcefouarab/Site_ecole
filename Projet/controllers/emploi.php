<?php

class Emploi extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
    }

    public function id($params) {
        if (isset($params[0])) {
            $this->view->render("emploi", "Emploi du temps", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function ens($params) {
        if (isset($params[0])) {
            $this->view->render("emploiens", "Emploi du temps", true, $params[0]);
        } else {
            header("location: ".BASE_URL."erreur/index/".PAGE_INACC);
        }
    }

    public function getClasses() {
        $this->loadModel("classe");
        $data = $this->model->getClasses();
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getClassesEns($id) {
        $this->loadModel("enseigne");
        $data = $this->model->getClassesEns($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getMatieres() {
        $this->loadModel("matiere");
        $data = $this->model->getMatieres();
        if ($data != SERVER_ERROR) {
            if (isset($_POST["from"])) echo json_encode($data);
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getMatieresEns($id) {
        $this->loadModel("enseigne");
        if (isset($_POST["from"])) {
            $classe = isset($_POST["classe"]) ? $_POST["classe"] : null; 
            $data = $this->model->getMatieresEns($_POST["id"], $classe);
        } else {
            $data = $this->model->getMatieresEns($id);
        }
        if ($data != SERVER_ERROR) {
            if (isset($_POST["from"])) echo json_encode($data);
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }

    }

    public function getEnsMatiere($id) {
        $this->loadModel("enseigne");
        if (isset($_POST["from"])) {
            $data = $this->model->getEnsMatiere($_POST["id"], $_POST["classe"]);
        } else {
            $data = $this->model->getEnsMatiere($id);
        }
        if ($data != SERVER_ERROR) {
            if (isset($_POST["from"])) echo json_encode($data);
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEnseignants() {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignants();
        if ($data != SERVER_ERROR) {
            if (isset($_POST["from"])) echo json_encode($data);
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEnseignant($id) {
        $this->loadModel("enseignant");
        $data = $this->model->getEnseignant($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEmploi($classe) {
        $this->loadModel("emploi");
        $data = $this->model->getEmploi($classe);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function getEmploiEns($id) {
        $this->loadModel("emploi");
        $data = $this->model->getEmploiEns($id);
        if ($data != SERVER_ERROR) {
            return $data;
        } else {
            header("location: ".BASE_URL."erreur/index/".$data);
        }
    }

    public function addEmploi() {
        $this->loadModel("emploi");
        $req = $this->model->addEmploi();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            if (isset($_POST["from"])) {
                if ($_POST["from"] == "id") {
                    header("location: ".BASE_URL."emploi/id/".$req[0]);
                } else if ($_POST["from"] == "ens") {
                    header("location: ".BASE_URL."emploi/ens/".$req[1]);
                }
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
            }
        }

    }

    public function modifEmploi() {
        $this->loadModel("emploi");
        $req = $this->model->modifEmploi();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            if (isset($_POST["from"])) {
                if ($_POST["from"] == "id") {
                    header("location: ".BASE_URL."emploi/id/".$req[0]);
                } else if ($_POST["from"] == "ens") {
                    header("location: ".BASE_URL."emploi/ens/".$req[1]);
                }
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
            }
        }
    }

    public function suppEmploi() {
        $this->loadModel("emploi");
        $req = $this->model->suppEmploi();
        if ($req == SERVER_ERROR || $req == MISSING_DATA) {
            header("location: ".BASE_URL."erreur/index/".$req);
        } else {
            if (isset($_POST["from"])) {
                if ($_POST["from"] == "id") {
                    header("location: ".BASE_URL."emploi/id/".$req[0]);
                } else if ($_POST["from"] == "ens") {
                    header("location: ".BASE_URL."emploi/ens/".$req[1]);
                }
            } else {
                header("location: ".BASE_URL."erreur/index/".MISSING_DATA);
            }
        }
    }
}