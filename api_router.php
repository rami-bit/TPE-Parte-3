<?php 

require_once 'libs/router/router.php';
require_once './libs/jwt/jwt.middleware.php';   


require_once 'app/controllers/noticias-api.controller.php';
require_once 'app/controllers/auth-api.controller.php';
require_once 'app/middlewares/guard-api.middleware.php';

$router = new Router();
$router->addMiddleware(new JWTMiddleware());
//Endpoints Sin requerir Token

$router->addRoute('auth/login','GET','AuthApiController','login');

$router->addRoute('noticias', 'GET', 'NoticiaController', 'getAll');
$router->addRoute('noticias/:id','GET','NoticiaController', 'get');



$router->addMiddleware(new GuardMiddleware());


$router->addRoute('noticias','POST','NoticiaController','crearNoticia');
$router->addRoute('noticias/:id', 'PUT', 'NoticiaController', 'editarNoticia');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
?>