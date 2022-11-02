<?php


class CategoriaModel {
    
    private $db;

    function __construct(){
         $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }

    public function getCategorias(){
        $sentencia= $this->db->prepare("SELECT * FROM tipo");
        $sentencia->execute();
        $categorias = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    public function insertCategory($category){
        $sentecia = $this->db->prepare("INSERT INTO `tipo` (`id`, `nombre`) VALUES (NULL, ?) ");
        $sentecia->execute([$category]);
    }

    public function deleteCategory($id){
        $sentencia = $this->db->prepare("DELETE FROM tipo WHERE id = ?");
        $sentencia->execute([$id]);
    }

    public function updateCategoy($id, $newCategory){
        $sentencia = $this->db->prepare("UPDATE tipo SET nombre = ? WHERE id = ?");
        $sentencia->execute([$newCategory,$id]);
    }
}
