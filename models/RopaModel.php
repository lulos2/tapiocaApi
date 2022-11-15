<?php
 
class RopaModel {
    
    private $db;
    
    function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }
    
    function getProducts() {
        $sentencia= $this->db->prepare("SELECT * FROM ropa");
        $sentencia->execute();
        $products = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getProduct($id) {
        $sentencia= $this->db->prepare("SELECT * FROM ropa WHERE id = ?");
        $sentencia->execute([$id]);
        $product = $sentencia->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    function getProductWhitCollection($productId) {
        $sentencia= $this->db->prepare("SELECT * FROM ropa INNER JOIN coleccion ON ropa.id_coleccion_fk = coleccion.id_coleccion WHERE id = ?");
        $sentencia->execute(array($productId));
        $producto = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $producto;
    }

    function getProductsByAttribute($attribute) {
        $sentencia = $this->db->prepare("SELECT * FROM ropa WHERE ". $attribute . " = ?");
        $sentencia ->execute([$attribute]);
        $productsByAttribute = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $productsByAttribute;
    }

    public function insertProduct($precio,$nombre,$descripcion,$coleccion = null,$categoria = null,$slug) {
        $sentencia = $this->db->prepare("INSERT INTO ropa(precio, nombre, descripcion, id_coleccion_fk, id_tipo_fk, slug) VALUES(?, ?, ?, ?, ?, ?)");
        $sentencia->execute(array($precio,$nombre,$descripcion,$coleccion,$categoria,$slug));
        return $this->db->lastInsertId();
    }

    public function searchProduct($search) {
        $sentencia = $this->db->prepare("SELECT * FROM ropa WHERE nombre LIKE '%$search%'");
        $sentencia->execute([]);
        $productsSearch = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $productsSearch;
    }

    public function deleteProduct($id) {
        $sentencia = $this->db->prepare("DELETE  FROM ropa WHERE id = ?");
        $sentencia->execute([$id]);
    }

    public function updateProduct($id,$precio,$nombre,$descripcion,$coleccion,$categoria,$img) {
        $sentencia = $this->db->prepare("UPDATE ropa SET precio = ?, nombre = ?, descripcion = ?, id_coleccion_fk = ?, id_tipo_fk = ?, img = ? WHERE id = ?");
        $sentencia->execute(array($precio,$nombre,$descripcion,$coleccion,$categoria,$img,$id));
    }

    public function getAttributes() {
        $sentencia = $this->db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'ropa'");
        $sentencia->execute([]);
        $attributes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $attributes;
    }

    function getAll($sort, $order, $limit = null, $offset = null) {
        $query = "SELECT * FROM ropa ORDER BY $sort $order";
        if($limit !== null && $offset !== null) {
            $query = $this->addPaginado($query, $limit, $offset);
        }
        $querydb = $this->db->prepare($query);
        $querydb->execute();
        $products = $querydb->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    private function addPaginado(string $query,int $limit, int $offset) {
        return $query . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
    }

    function getFilteredAndSorted($filterColumn, $filterValue, $sort, $order) {
        $query = "SELECT * FROM ropa WHERE $filterColumn =? ORDER BY $sort $order";
        $querydb = $this->db->prepare($query);
        $querydb->execute(array($filterValue));
        $products = $querydb->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }


}
