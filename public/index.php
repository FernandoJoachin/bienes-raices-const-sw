<?php
require_once __DIR__ . "/../includes/app.php";

use MVC\Router;
use Controlador\PaginasController;
use Controlador\CtrlPropiedades;

$router = New Router();

$router->get("/",[PaginasController::class, "index"]);
$router->get("/nosotros",[PaginasController::class, "vistaNosotros"]);
$router->get("/propiedades",[PaginasController::class, "vistaPropiedades"]);
$router->get("/propiedad",[PaginasController::class, "vistaPropiedad"]);
$router->get("/blog",[PaginasController::class, "vistaBlogs"]);
$router->get("/entrada",[PaginasController::class, "vistaEntrada"]);

$router->get("/propiedades/crear", [CtrlPropiedades::class, "vistaCrearPropiedad"]);
$router->post("/propiedades/crear", [CtrlPropiedades::class, "crearPropiedad"]);
$router->get("/propiedades/actualizar", [CtrlPropiedades::class, "vistaActualizarPropiedad"]);
$router->post("/propiedades/actualizar", [CtrlPropiedades::class, "actualizarPropiedad"]);
$router->post("/propiedades/eliminar", [CtrlPropiedades::class, "eliminarPropiedad"]);

$router->comprobarRutas();
