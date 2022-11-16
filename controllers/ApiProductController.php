<?php
require_once "controllers/BaseController.php";
require_once "models/RopaModel.php";
require_once "views/ApiView.php";
require_once "helpers/AuthHelper.php";


class ApiProductController extends BaseController {

    private $ropaModel;
    private $entityAttributes;
    private $authHelper;

    function __construct() {
        parent::__construct();
        $this->ropaModel = new RopaModel();
        $this->entityAttributes = $this->formatAttributesColumn($this->ropaModel->getAttributes());
        $this->authHelper = new AuthHelper();
    }

    private function formatAttributesColumn(array $attributes) {
        $result = [];
        foreach ($attributes as $attribute) {
            $result[] = $attribute['COLUMN_NAME'];
        }
        return $result;
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
        try{
            $sort = $_GET['sort'] ?? null;
            $order = $_GET['order'] ?? null;
            $filterColumn = $_GET['filterColumn'] ?? null;
            $filterValue = $_GET['filterValue'] ?? null;
            $limit = $_GET['pageSize'] ?? null;
            $page = $_GET['page'] ?? null;
            $offset = ($limit && $page) ? ($limit * ($page - 1)) : null;

            $this->verify($sort, $order, $filterColumn, $filterValue);

            if($filterColumn == null && $filterValue == null && $sort == null && $order == null){
                $products = $this->ropaModel->getAll('id', 'asc', $limit, $offset);
            }
            else if(($sort !=null && $order != null) && ($filterColumn == null && $filterValue == null)){
                $products = $this->ropaModel->getAll($sort, $order, $limit, $offset);
            }
            else if(($filterColumn != null && $filterValue != null) && ($sort == null & $order == null)){
                $products = $this->ropaModel->getFilteredAndSorted($filterColumn, $filterValue, 'id', 'asc');
            }
            else if(($filterColumn != null && $filterValue != null) && ($sort != null && $order != null)){
                $products = $this->ropaModel->getFilteredAndSorted($filterColumn, $filterValue, $sort, $order);
            }
            if(!empty($products)){
                $this->view->response($products, 200);
            }
            else{
                $this->view->response("El producto no existe", 404);
            }
        }catch(Exception $exc){
            $this->view->response("Error interno del servidor", 500);
        }
    }

    private function verify($sort, $order, $filterColumn, $filterValue) {
        $columns = $this->entityAttributes;

        if($sort != null && !in_array(strtolower($sort), $columns)) {
            $this->view->response("Atributo no existente", 400);
        }
        if($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc') {
            $this->view->response("orden invalido", 400);
        }
        if($filterColumn !=null && !in_array(strtolower($filterColumn), $columns) && $filterValue == null) {
            $this->view->response("Atributo no existente", 400);
        }
    }

    public function deleteProduct($params = null) {
        if($this->authHelper->isAuthorized()) {
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
        else {
            $this->view->response("No autorizado", 403);
        }

    }

    public function insertProduct() {
        if($this->authHelper->isAuthorized()) {
            $body = $this->getBody();
            if ($body) {
                $slug = str_replace(" ", "-",trim($body->nombre));
                $id = $this->ropaModel->insertProduct($body->precio, $body->nombre, $body->descripcion, $body->coleccion, $body->tipo, $slug);
                if ($id)
                    $this->view->response("Se inserto la prenda", 200);
                else
                    $this->view->response("Error al insertar", 500);
            }
            else
                $this->view->response("Invalid JSON", 400);
        }
        else{
            $this->view->response("No autorizado", 403);
        }
    }

}