<?php
require_once "controllers/BaseController.php";
require_once "models/CategoriaModel.php";
require_once "models/ColeccionModel.php";
require_once "models/RopaModel.php";
require_once "views/ApiView.php";

class ApiProductController extends BaseController {

    private $categoriaModel;
    private $ropaModel;
    private $coleccionModel;
    private $entityAttributes;

    function __construct() {
        parent::__construct();
        $this->ropaModel = new RopaModel();
        $this->entityAttributes = $this->ropaModel->getAttributes();
    }

    public function getProduct($params = null) {
        $id = $params[':ID'];
        $product = $this->ropaModel->getProduct($id);
        if($product)
            $this->view->response($product, 200);
        else
            $this->view->response("El producto no existe", 404);
    }

    public function getProducts() {
        $products = $this->ropaModel->getProducts();
        if($products)
            $this->view->response($products, 200);
        else
            $this->view->response("No hay productos", 404);
    }

    public function getFilterProducts($attribute) {
        if (in_array($attribute, $this->entityAttributes)) {
            $products = $this->ropaModel->getProductsByAttribute($attribute);
            if($products)
                $this->view->response($products, 200);
            else
                $this->view->response("No hay productos", 404);
        }
        else {
            $this->view->response("Atributo no existente", 404);
        }
    }

    public function deleteProduct($params = null) {
        $id = $params[':ID'];
        $product = $this->ropaModel->getProduct($id);
        if($product) {
            $this->ropaModel->deleteProduct($id);
            $this->view->response("El producto con id = $id fue borrado", 200);
        }
        else {
            $this->view->response("El producto no existe", 404);
        }
    }

    public function insertProduct() {
        $body = $this->getBody();
        $slug = str_replace(" ", "-",trim($body->nombre));
        if ($body) {
            $id = $this->ropaModel->insertProduct($body->precio, $body->nombre, $body->descripcion, $body->id_coleccion_fk, $body->id_tipo_fk, $slug);
            if ($id)
                $this->view->response("Se inserto la tarea", 200);
            else
                $this->view->response("Error al insertar", 500);
        }
        else
            $this->view->response("Invalid JSON", 400);
    }


}