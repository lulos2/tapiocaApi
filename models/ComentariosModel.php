<?php

class ComentariosModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }

}