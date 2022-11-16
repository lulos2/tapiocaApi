<?php
require_once "models/UserModel.php";
require_once "views/ApiView.php";
require_once "helpers/AuthHelper.php";
require_once "controllers/BaseController.php";

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

class ApiUserController extends BaseController {
    
    private $userModel;
    private $helper;

    public function __construct() {
        parent::__construct();
        $this->userModel = new userModel();
        $this->view = new ApiView();
        $this->helper = new AuthHelper();
    }

    public function getToken() {
        $key = "WebKeyTPE";

        $basic = $this->helper->getAuthHeader();

        $basic = explode(" ",$basic);

        if($basic[0] != "Basic") {
            $this->view->response('La autenticación debe ser Basic', 403);
            return;
        }
        $userpass = base64_decode($basic[1]);
        $userpass = explode(":", $userpass);
        $user = $userpass[0];
        $pass = $userpass[1];
        $userdb = $this->userModel->getUser($user);

        if($user == $userdb->email && $pass == $userdb->passwd){
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            $payload = array(
                'id' => $userdb->id,
                'name' => "$userdb->email",
                'exp' => time()+1800
            );
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));
            $signature = hash_hmac('SHA256', "$header.$payload", $key , true);
            $signature = base64url_encode($signature);
            $token = "$header.$payload.$signature";
            $this->view->response($token, 200);
        }else{
            $this->view->response('No autorizado', 403);
        }
    }
}
?>