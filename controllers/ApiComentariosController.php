<?php
require_once './views/ApiView.php';
require_once './models/ComentariosModel.php';

class ApiComentariosController extends BaseController{

    private $model;
    private $view;

    public function __construct() {
        $this->model = new ComentarioModel();
        $this->view = new ApiView();
    }


}