<?php
require_once 'libs/Router.php';
require_once 'controllers/ApiProductController.php';

$router = new Router();

// Manejo de productos
$router->addRoute('productos','GET','ApiProductController','getProducts');
$router->addRoute('productos/:ID','GET' , 'ApiProductController' , 'getProduct');
$router->addRoute('productos','POST' , 'ApiProductController' , 'insertProduct');
$router->addRoute('productos/:ID','DELETE' , 'ApiProductController' , 'deleteProduct');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
