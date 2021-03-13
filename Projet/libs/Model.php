<?php

class Model {

    function __construct() {
        $dsn = DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET.";";
        $this->db = null;
        try {
            $this->db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            header("location: ".BASE_URL."erreur/index/".DB_CONN_ERROR);
        }
    }

}