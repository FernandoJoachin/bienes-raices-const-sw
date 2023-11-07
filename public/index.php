<?php
require_once __DIR__ . "/../includes/app.php";
use MVC\Router;
use Controlador\PaginasController;
use Controlador\CtrlVendedor;

$router = New Router();

$router->get("/",[PaginasController::class, "index"]);
$router->get("/nosotros",[PaginasController::class, "vistaNosotros"]);
$router->get("/propiedades",[PaginasController::class, "vistaPropiedades"]);
$router->get("/propiedad",[PaginasController::class, "vistaPropiedad"]);
$router->get("/blog",[PaginasController::class, "vistaBlogs"]);
$router->get("/entrada",[PaginasController::class, "vistaEntrada"]);

$router->get("/vendedores/crear", [CtrlVendedor::class, "vistaCrearVendedor"]);
$router->get("/vendedores/actualizar", [CtrlVendedor::class, "vistaActualizarVendedor"]);
$router->post("/vendedores/crear", [CtrlVendedor::class, "crearVendedor"]);
$router->post("/vendedores/actualizar", [CtrlVendedor::class, "actualizarVendedor"]);
$router->post("/vendedores/eliminar", [CtrlVendedor::class, "eliminarVendedor"]);

$router->comprobarRutas();
