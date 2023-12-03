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

$router->get("/admin/propiedades", [CtrlPropiedades::class, "vistaTablaPropiedades"]);
$router->get("/admin/propiedades/crear", [CtrlPropiedades::class, "vistaCrearPropiedad"]);
$router->post("/admin/propiedades/crear", [CtrlPropiedades::class, "crearPropiedad"]);
$router->get("/admin/propiedades/actualizar", [CtrlPropiedades::class, "vistaActualizarPropiedad"]);
$router->post("/admin/propiedades/actualizar", [CtrlPropiedades::class, "actualizarPropiedad"]);
$router->post("/admin/propiedades/eliminar", [CtrlPropiedades::class, "eliminarPropiedad"]);

$router->get("/admin/vendedores", [CtrlVendedor::class, "vistaTablaVendedores"]);
$router->get("/admin/vendedores/crear", [CtrlVendedor::class, "vistaCrearVendedor"]);
$router->get("/admin/vendedores/actualizar", [CtrlVendedor::class, "vistaActualizarVendedor"]);
$router->post("/admin/vendedores/crear", [CtrlVendedor::class, "crearVendedor"]);
$router->post("/admin/vendedores/actualizar", [CtrlVendedor::class, "actualizarVendedor"]);
$router->post("/admin/vendedores/eliminar", [CtrlVendedor::class, "eliminarVendedor"]);

$router->get("/admin/articulos/crear",[CtrlArticulo::class, "vistaCrearArticulo"]);
$router->get("/admin/articulos/actualizar",[CtrlArticulo::class, "vistaActualizarArticulo"]);
$router->post("/admin/articulos/crear",[CtrlArticulo::class, "crearArticulo"]);
$router->post("/admin/articulos/crear",[CtrlArticulo::class, "actualizarArticulo"]);

$router->get("/usuarios/crear",[CtrlUsuario::class, "vistaCrearUsuario"]);
$router->post("/usuarios/crear",[CtrlUsuario::class, "crearUsuario"]);

$router->comprobarRutas();
