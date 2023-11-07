<?php
require_once __DIR__ . "/../includes/app.php";

use MVC\Router;

use Controlador\CtrlPanelAdministracion;
use Controlador\CtrlPaginas;
use Controlador\CtrlInicioSesion;
use Controlador\CtrlVendedor;


$router = New Router();

$router->get("/",[CtrlPaginas::class, "index"]);
$router->get("/nosotros",[CtrlPaginas::class, "vistaNosotros"]);
$router->get("/propiedades",[CtrlPaginas::class, "vistaPropiedades"]);
$router->get("/propiedad",[CtrlPaginas::class, "vistaPropiedad"]);
$router->get("/blog",[CtrlPaginas::class, "vistaBlogs"]);
$router->get("/entrada",[CtrlPaginas::class, "vistaEntrada"]);

$router->get("/restablecer-contraseña",[CtrlInicioSesion::class, "vistaRestablecerContraseña"]);
$router->post("/restablecer-contraseña",[CtrlInicioSesion::class, "restablecerContraseña"]);

$router->get("/vendedores/crear", [CtrlVendedor::class, "vistaCrearVendedor"]);
$router->get("/vendedores/actualizar", [CtrlVendedor::class, "vistaActualizarVendedor"]);
$router->post("/vendedores/crear", [CtrlVendedor::class, "crearVendedor"]);
$router->post("/vendedores/actualizar", [CtrlVendedor::class, "actualizarVendedor"]);
$router->post("/vendedores/eliminar", [CtrlVendedor::class, "eliminarVendedor"]);

$router->get("/admin", [CtrlPanelAdministracion::class, "vistaPanelAdministracion"]);

$router->comprobarRutas();
