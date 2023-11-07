<?php
require_once __DIR__ . "/../includes/app.php";
use MVC\Router;
use Controlador\PaginasController;
use Controlador\CtrlUsuario;

$router = New Router();

$router->get("/",[PaginasController::class, "index"]);
$router->get("/nosotros",[PaginasController::class, "vistaNosotros"]);
$router->get("/propiedades",[PaginasController::class, "vistaPropiedades"]);
$router->get("/propiedad",[PaginasController::class, "vistaPropiedad"]);
$router->get("/blog",[PaginasController::class, "vistaBlogs"]);
$router->get("/entrada",[PaginasController::class, "vistaEntrada"]);

$router->get("/usuarios/crear",[CtrlUsuario::class, "vistaCrearUsuario"]);
$router->post("/usuarios/crear",[CtrlUsuario::class, "crearUsuario"]);

$router->comprobarRutas();
