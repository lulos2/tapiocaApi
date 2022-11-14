<?php
require_once 'libs/Router.php';
require_once 'controllers/ApiProductController.php';

$router = new Router();

// Manejo de productos
$router->addRoute('productos','GET','ApiProductController','getProducts');
$router->addRoute('productos/:ID','GET' , 'ApiProductController' , 'getProduct');
$router->addRoute('productos','POST' , 'ApiProductController' , 'insertProduct');
$router->addRoute('productos/:ID','DELETE' , 'ApiProductController' , 'deleteProduct');

// Manejo de categorias
$router->addRoute('categorias','GET','ApiProductController','getCategories');
$router->addRoute('categorias/:ID','GET','ApiProductController','getCategory');
$router->addRoute('categorias','POST','ApiProductController','insertCategory');
$router->addRoute('categorias/:ID','DELETE','ApiProductController','deleteCategory');

// Manejo de Comentarios
$router->addRoute('comentarios','GET','ApiComentariosController','traerComentarios');
$router->addRoute('comentarios/:DNI','GET','ApiComentariosController','comentariosXPersona');
$router->addRoute('comentarios/:DNI/:orden','GET','ApiComentariosController','ComentariosOrdenados');
$router->addRoute('comentarios','POST','ApiComentariosController','crearComentario');
$router->addRoute('comentarios/:ID','DELETE','ApiComentariosController','eliminarComentario');


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
