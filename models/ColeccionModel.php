<?php


class ColeccionModel {
    
    private $db;

    function __construct(){
         $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }

    public function getColecciones(){
        $sentencia = $this->db->prepare("SELECT * FROM coleccion");
        $sentencia->execute();
        $colecciones = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $colecciones;
    }

    public function insertCollection($nameCollection,$yearCollection,$authorCollection,$stationCollection){
        $sentencia = $this->db->prepare("INSERT INTO coleccion(anio,nombre_coleccion,autor,estacion) VALUES(?, ?, ?, ?)");
        $sentencia->execute([$yearCollection,$nameCollection,$authorCollection,$stationCollection]);
    }

    public function updateCollection($collectionId,$nameCollection,$yearCollection,$authorCollection,$stationCollection){
        $sentencia = $this->db->prepare("UPDATE coleccion SET anio = ?, nombre_coleccion = ?, autor = ?, estacion = ? WHERE id_coleccion = ?");
        $sentencia->execute([$yearCollection,$nameCollection,$authorCollection,$stationCollection,$collectionId]);
    }

    public function deleteCollection($collectionId){
        $sentencia = $this->db->prepare("DELETE  FROM coleccion WHERE id_coleccion = ?");
        $sentencia->execute([$collectionId]);
    }
}
