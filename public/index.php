<?php
require_once __DIR__ . "/../includes/app.php";

use MVC\Router;

use Controlador\CtrlPaginas;
use Controlador\CtrlPanelAdministracion;
use Controlador\CtrlInicioSesion;
use Controlador\CtrlPropiedades;
use Controlador\CtrlVendedor;
use Controlador\CtrlArticulo;
use Controlador\CtrlUsuario;

$router = New Router();

$router->get("/",[CtrlPaginas::class, "index"]);
$router->get("/nosotros",[CtrlPaginas::class, "vistaNosotros"]);
$router->get("/propiedades",[CtrlPaginas::class, "vistaPropiedades"]);
$router->get("/propiedad",[CtrlPaginas::class, "vistaPropiedad"]);
$router->get("/blog",[CtrlPaginas::class, "vistaBlogs"]);
$router->get("/entrada",[CtrlPaginas::class, "vistaEntrada"]);

$router->get("/contacto",[CtrlPaginas::class, "vistaContacto"]);
$router->post("/contacto",[CtrlPaginas::class, "enviarCorreoContacto"]);

$router->get("/admin", [CtrlPanelAdministracion::class, "vistaPanelAdministracion"]);

$router->get("/iniciar-sesion",[CtrlInicioSesion::class, "vistaIniciarSesion"]);
$router->get("/cerrar-sesion",[CtrlInicioSesion::class, "cerrarSesion"]);
$router->get("/restablecer-contraseña",[CtrlInicioSesion::class, "vistaRestablecerContraseña"]);
$router->get("/olvide-contraseña",[CtrlInicioSesion::class, "vistaOlvideContraseña"]);
$router->post("/iniciar-sesion",[CtrlInicioSesion::class, "iniciarSesion"]);
$router->post("/restablecer-contraseña",[CtrlInicioSesion::class, "restablecerContraseña"]);
$router->post("/olvide-contraseña",[CtrlInicioSesion::class, "olvideContraseña"]);

$router->get("/propiedades/crear", [CtrlPropiedades::class, "vistaCrearPropiedad"]);
$router->post("/propiedades/crear", [CtrlPropiedades::class, "crearPropiedad"]);
$router->get("/propiedades/actualizar", [CtrlPropiedades::class, "vistaActualizarPropiedad"]);
$router->post("/propiedades/actualizar", [CtrlPropiedades::class, "actualizarPropiedad"]);
$router->post("/propiedades/eliminar", [CtrlPropiedades::class, "eliminarPropiedad"]);

$router->get("/vendedores/crear", [CtrlVendedor::class, "vistaCrearVendedor"]);
$router->get("/vendedores/actualizar", [CtrlVendedor::class, "vistaActualizarVendedor"]);
$router->post("/vendedores/crear", [CtrlVendedor::class, "crearVendedor"]);
$router->post("/vendedores/actualizar", [CtrlVendedor::class, "actualizarVendedor"]);
$router->post("/vendedores/eliminar", [CtrlVendedor::class, "eliminarVendedor"]);

$router->get("/articulos/crear",[CtrlArticulo::class, "vistaCrearArticulo"]);
$router->get("/articulos/actualizar",[CtrlArticulo::class, "vistaActualizarArticulo"]);
$router->post("/articulos/crear",[CtrlArticulo::class, "crearArticulo"]);
$router->post("/articulos/crear",[CtrlArticulo::class, "actualizarArticulo"]);

$router->get("/usuarios/crear",[CtrlUsuario::class, "vistaCrearUsuario"]);
$router->post("/usuarios/crear",[CtrlUsuario::class, "crearUsuario"]);

$router->comprobarRutas();
