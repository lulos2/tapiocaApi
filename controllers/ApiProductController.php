<?php
require_once "controllers/BaseController.php";
require_once "models/CategoriaModel.php";
require_once "models/ColeccionModel.php";
require_once "models/RopaModel.php";
require_once "views/TapiocaView.php";
require_once "helpers/Helper.php";

class ProductController extends BaseController{

    private $categoriaModel;
    private $ropaModel;
    private $view;
    private $max_size;
    private $helper;
    private $coleccionModel;

    function __construct($max_size = 1000000){
        $this->categoriaModel = new CategoriaModel();
        $this->ropaModel = new RopaModel();
        $this->view = new TapiocaView();
        $this->helper = new Helper();
        $this->coleccionModel = new ColeccionModel();
        $this->max_size = $max_size;
    }

    public function homeAction($categoria = null){
        $categorias = $this->categoriaModel->getCategorias();
        $products = (!$categoria) ? $this->ropaModel->getProductos() : $this->ropaModel->getProductsByCategory($categoria);
        $this->view->showHome($products,$categorias);
    }

    public function updateAction($id){
        if(Helper::checkAdmin()){
            $categories = $this->categoriaModel->getCategorias();
            $product = $this->ropaModel->getproduct($id);
            $colections = $this->coleccionModel->getColecciones();
            $this->view->showUpdateProduct($product, $categories, $colections);
        }
        else{
            return false;
        }
    }

    public function pdpAction($id){
        $product = $this->ropaModel->getProductWhitCollection($id);
        $categories = $this->categoriaModel->getCategorias();
        $this->view->showPdp($product , $categories);
    }

    public function deleteProductAction($id){
        if(Helper::checkAdmin()){
            $this->ropaModel->deleteProduct($id);
            $this->redirectRoute("home");
        }
        else{
            return false;
        }
    }

    public function insertAction($price,$name,$description,$collection,$category){
        $img = $this->getFilePath();
        $slug = str_replace(" ", "-",$name);
        $this->ropaModel->insertProduct($price,$name,$description,$img,$collection,$category,$slug);
        $this->redirectRoute("home");
    }

    public function updateProductAction($id,$precio,$nombre,$descripcion,$coleccion,$categoria){
        if(Helper::checkAdmin()){
            $img = $this->getFilePath();
            $this->ropaModel->updateProduct($id,$precio,$nombre,$descripcion,$coleccion,$categoria,$img);
            $this->redirectRoute("admin");
        }
        else{
            return false;
        }
    }

    public function getFilePath(){
        if ($this->helper->checkAdmin() && $this->valid_file()){
            $filePath = "images/" . uniqid("", false) . "."
            . strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
            move_uploaded_file($_FILES['img']['tmp_name'], $filePath);
            return $filePath;
        }
    }

    public function valid_file(){
        $file = $_FILES['img'];
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_parts));
        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($file_ext, $allowed))
            if ($file_error === 0)
                if ($file_size <= $this->max_size)
                    return true;
                else{
                    echo "El archivo es demasiado grande";
                }
            else{
                echo "Error al subir el archivo";
            }
        else{
            echo "Extension invalida";
        }
    return false;
    }

    public function searchAction($search = null){
        if ($search != ""){
            $products = $this->ropaModel->searchProduct($search);
            $this->view->showHome($products, null);
        }
        else{
            $this->redirectRoute("home");
        }
    }

    public function insertCategoryAction($category){
        $this->categoriaModel->insertCategory($category);
        $this->redirectRoute('admin');
    }

    public function deleteCategoryAction($id){
        if(Helper::checkAdmin()){
            $this->categoriaModel->deleteCategory($id);
            $this->redirectRoute("admin");
        }
    }

    public function modifyCategoryAction($id, $newCategory){
        $this->categoriaModel->updateCategoy($id , $newCategory);
        $this->redirectRoute("admin");
    }

    public function insertCollectionAction($nameCollection,$yearCollection,$authorCollection,$stationCollection){
        if(is_int($yearCollection)) {
            $this->coleccionModel->insertCollection($nameCollection, $yearCollection, $authorCollection, $stationCollection);
            $this->redirectRoute("admin");
        }
        else $this->redirectRoute("admin");
    }

    public function updateCollectionAction($collectionId,$nameCollection,$yearCollection,$authorCollection,$stationCollection){
        $this->coleccionModel->updateCollection($collectionId,$nameCollection,$yearCollection,$authorCollection,$stationCollection);
        $this->redirectRoute("admin");
    }

    public function deleteCollectionAction($collectionId){
        $this->coleccionModel->deleteCollection($collectionId);
        $this->redirectRoute("admin");
    }

}