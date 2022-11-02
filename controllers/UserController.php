<?php
require_once "models/UserModel.php";
require_once "views/TapiocaView.php";
require_once "models/CategoriaModel.php";
require_once "models/ColeccionModel.php";
require_once "helpers/Helper.php";
require_once "controllers/BaseController.php";



class UserController extends BaseController{
    
    private $userModel;
    private $userView;
    private $categorias;
    private $helper;
    private $coleccionModel;

    public function __construct(){
        $this->userModel = new UserModel();
        $this->userView = new TapiocaView();
        $this->categorias = new CategoriaModel();
        $this->coleccionModel = new ColeccionModel();
        $this->helper = new Helper();
    }

    public function registerAction($nombre, $inputEmail, $password){
        try{
            $hashPasword = password_hash($password, PASSWORD_BCRYPT);
            $this->userModel->insertUser($nombre,$inputEmail,$hashPasword);
            $this->verifyAction($inputEmail, $password);
            $this->redirectRoute("home");
        }
        catch(Exception $e){
           echo "Error: ".$e->getMessage();
        }
    }

    public function checkInAction($error=null){
            $categorias = $this->categorias->getCategorias();
            $this->userView->showcheckIn($categorias,$error);
    }

    public function loginAction(){
        if($this->helper->isLogged()){
            $this->redirectRoute("home");
        }
        else{
            $categorias = $this->categorias->getCategorias();
            $this->userView->showLogin($categorias);
        }
    }

    public function adminAction(){
        if(Helper::checkAdmin()){
            $categorias = $this->categorias->getCategorias();
            $colecciones = $this->coleccionModel->getColecciones();
            $users = $this->userModel->getUsers();
            $this->userView->showAdmin($categorias,$colecciones,$users);
        }
        else{
            $this->redirectRoute("home");
        }
    }

    public function updateAdminAction($id,$rol){
        $this->userModel->updateRol($id,$rol);
        $this->redirectRoute("admin");
    }

    public function verifyAction($email,$password){
        $user = $this->userModel->getUser($email);
        $hash =  $user->passwd;
        $route = "login";
        $passwordVerify = password_verify($password,$hash);
        if(($user == false)||(!$passwordVerify)){
            $this->redirectRoute("login");
            die();
        }
        else if($passwordVerify){
            $this->setSessionTrue($user);
            $route = $this->helper->checkAdmin() ? "admin" : "home";
        }
        $this->setCookies();
        $this->redirectRoute($route);
    }

    private function setSessionTrue($user){
        if(!session_id()) session_start();
        $_SESSION['name'] = $user->nombre;
        $_SESSION['rol'] = $user->rol;
        $_SESSION['logged'] = true;
        session_commit();
    }

    private function setCookies(){
        if(!session_id()) session_start(['read_and_close' => 'true']);
        setcookie("logged",$_SESSION['logged'],time()+60*60*4,"/");
        setcookie("name",$_SESSION['name'],time()+60*60*4,"/");
        setcookie("rol",$_SESSION['rol'],time()+60*60*4,"/");
    }

    public function checkTimeOut(){
        if(!session_id()) session_start();
        if ( isset($_SESSION['LAST_ACTIVITY']) && ( (time() - $_SESSION['LAST_ACTIVITY']) > 1500)) {
            $this->logoutAction();
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    public function logoutAction(){
        if(!session_id()) session_start();
        foreach($_SESSION as $key => $val) unset($_SESSION[$key]);
        //for each para borrar las cookies desde el indice(key)
        foreach($_COOKIE as $key => $cookie){
            setcookie($key, null, time() - 3600, "/");
        }
        session_commit();
        $this->redirectRoute("home");
    }

    public function deleteUserAction($id){
        $this->userModel->deleteUser($id);
        $this->redirectRoute("admin");
    }
}
?>