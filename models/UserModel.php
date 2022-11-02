<?php 
class UserModel {
    
    private $db;
    
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }

    public function insertUser($nombre, $email, $passwd, $rol = 'user'){
        $template = $this->db->prepare("INSERT INTO user (nombre, email, passwd, rol) VALUES(?, ?, ?, ?)");
        $template->execute(array($nombre,$email, $passwd, $rol));
    }

    public function getUser($email){
        $template = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $template->execute(array($email));
        return $template->fetch(PDO::FETCH_OBJ);
    }

    public function getUsers(){
        $template = $this->db->prepare("SELECT * FROM user");
        $template->execute();
        return $template->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function updateRol($id, $nuevoRol){
        $template = $this->db->prepare("UPDATE user SET rol = ? WHERE id = ?");
        $template->execute(array($nuevoRol, $id));
    }
    
    public function deleteUser($id){
        $template = $this->db->prepare("DELETE FROM user WHERE id = ?");
        $template->execute(array($id));
    }
}
