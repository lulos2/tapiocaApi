<?php
require_once './libs/Router.php';
require_once './controllers/ApiProductController.php';

// crea el router
$router = new Router();

// Manejo de productos
$router->addRoute('productos','GET','ApiProductController','getProducts');
$router->addRoute('productos/:ID','GET' , 'ApiProductController' , 'getProduct');
$router->addRoute('productos','POST' , 'ApiProductController' , 'insertProduct');
$router->addRoute('productos/:ID','DELETE' , 'ApiProductController' , 'deleteProduct');

// Manejo de Telefonos
$router->addRoute('telefonos','GET','apiTelefonosController','traerTelefonos');
$router->addRoute('telefonos/:DNI','GET','apiTelefonosController','traerTelefonos');
$router->addRoute('telefonos/:DNI/:ID','GET','apiTelefonosController','traerTelefono');
$router->addRoute('telefonos/:DNI','POST','apiTelefonosController','crearTelefono');
$router->addRoute('telefonos/:DNI/:ID','DELETE','apiTelefonosController','borrarTelefono');

// Manejo de Comentarios
$router->addRoute('comentarios','GET','ApiComentariosController','traerComentarios');
$router->addRoute('comentarios/:DNI','GET','ApiComentariosController','comentariosXPersona');
$router->addRoute('comentarios/:DNI/:orden','GET','ApiComentariosController','ComentariosOrdenados');
$router->addRoute('comentarios','POST','ApiComentariosController','crearComentario');
$router->addRoute('comentarios/:ID','DELETE','ApiComentariosController','eliminarComentario');


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
