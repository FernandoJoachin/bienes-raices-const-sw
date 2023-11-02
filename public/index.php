<?php
require_once __DIR__ . "/../includes/app.php";
use MVC\Router;
use Controlador\PaginasController;

$router = New Router();

$router->get("/",[PaginasController::class, "index"]);
$router->get("/nosotros",[PaginasController::class, "vistaNosotros"]);
$router->get("/propiedades",[PaginasController::class, "vistaPropiedades"]);
$router->get("/propiedad",[PaginasController::class, "vistaPropiedad"]);
$router->get("/blog",[PaginasController::class, "vistaBlogs"]);
$router->get("/entrada",[PaginasController::class, "vistaEntrada"]);

$router->comprobarRutas();
