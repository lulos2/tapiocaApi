<?php 
class UserModel {
    
    private $db;
    
    function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=tapioca;charset=utf8', 'root', '');
    }

    public function getUser($email) {
        $template = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $template->execute(array($email));
        return $template->fetch(PDO::FETCH_OBJ);
    }

}
