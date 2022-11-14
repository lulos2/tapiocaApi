<?php
require_once "controllers/BaseController.php";
require_once "models/CategoriaModel.php";
require_once "models/ColeccionModel.php";
require_once "models/RopaModel.php";
require_once "views/ApiView.php";

class ApiProductController extends BaseController {

    private $categoriaModel;
    private $ropaModel;
    private $view;
    private $max_size;
    private $coleccionModel;

    function __construct($max_size = 1000000) {
        $this->categoriaModel = new CategoriaModel();
        $this->ropaModel = new RopaModel();
        $this->view = new ApiView();
        $this->coleccionModel = new ColeccionModel();
        $this->max_size = $max_size;
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
            $this->view->response("No hay producctos", 404);
    }

    public function deleteProduct($params = null) {
        $id = $params[':ID'];
        $product = $this->ropaModel->getProduct($id);
        if($product) {
            $this->ropaModel->deleteProduct($id);
            $this->view->response("El producto con id = $id fue borrado", 200);
        }
        else
            $this->view->response("El producto no existe", 404);
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


    public function deleteCategory($params = null) {
        $id = $params[':ID'];
        $product = $this->ropaModel->getProduct($id);
        if($product) {
            $this->ropaModel->deleteProduct($id);
            $this->view->response("El producto con id = $id fue borrado", 200);
        }
        else
            $this->view->response("El producto no existe", 404);
    }
    public function modifyCategoryAction($id, $newCategory) {
        $this->categoriaModel->updateCategoy($id , $newCategory);
        $this->redirectRoute("admin");
    }

    public function insertCollectionAction($nameCollection,$yearCollection,$authorCollection,$stationCollection) {
        if(is_int($yearCollection)) {
            $this->coleccionModel->insertCollection($nameCollection, $yearCollection, $authorCollection, $stationCollection);
            $this->redirectRoute("admin");
        }
        else $this->redirectRoute("admin");
    }

    public function updateCollectionAction($collectionId,$nameCollection,$yearCollection,$authorCollection,$stationCollection) {
        $this->coleccionModel->updateCollection($collectionId,$nameCollection,$yearCollection,$authorCollection,$stationCollection);
        $this->redirectRoute("admin");
    }

    public function deleteCollectionAction($collectionId) {
        $this->coleccionModel->deleteCollection($collectionId);
        $this->redirectRoute("admin");
    }

}