<?php
 
class RopaModel {
    
    private $db;
    
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }
    
    function getProductos(){
        $sentencia= $this->db->prepare("SELECT * FROM ropa");
        $sentencia->execute();
        $products = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getProduct($id){
        $sentencia= $this->db->prepare("SELECT * FROM ropa WHERE id = ?");
        $sentencia->execute([$id]);
        $product = $sentencia->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    function getProductWhitCollection($productId){
        $sentencia= $this->db->prepare("SELECT * FROM ropa INNER JOIN coleccion ON ropa.id_coleccion_fk = coleccion.id_coleccion WHERE id = ?");
        $sentencia->execute(array($productId));
        $producto = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $producto;
    }

    function getProductsByCategory($category){
        $sentencia= $this->db->prepare("SELECT * FROM ropa WHERE id_tipo_fk = ?");
        $sentencia ->execute([$category]);
        $productsByCategory = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $productsByCategory;
    }

    public function insertProduct($precio,$nombre,$descripcion,$img,$coleccion = null,$categoria = null,$slug){
        $sentencia = $this->db->prepare("INSERT INTO ropa(precio, nombre, descripcion, img, id_coleccion_fk, id_tipo_fk, slug) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $sentencia->execute(array($precio,$nombre,$descripcion,$img,$coleccion,$categoria,$slug));
    }

    public function searchProduct($search){
        $sentencia = $this->db->prepare("SELECT * FROM ropa WHERE nombre LIKE '%$search%'");
        $sentencia->execute([]);
        $productsSearch = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $productsSearch;
    }

    public function deleteProduct($id){
        $sentencia = $this->db->prepare("DELETE  FROM ropa WHERE id = ?");
        $sentencia->execute([$id]);
    }

    public function updateProduct($id,$precio,$nombre,$descripcion,$coleccion,$categoria,$img){
        $sentencia = $this->db->prepare("UPDATE ropa SET precio = ?, nombre = ?, descripcion = ?, id_coleccion_fk = ?, id_tipo_fk = ?, img = ? WHERE id = ?");
        $sentencia->execute(array($precio,$nombre,$descripcion,$coleccion,$categoria,$img,$id));
    }
}
