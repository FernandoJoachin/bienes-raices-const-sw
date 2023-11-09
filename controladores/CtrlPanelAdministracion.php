<?php
namespace Controlador;

use MVC\Router;
use Modelo\Propiedad;
use Modelo\Vendedor;
class CtrlPanelAdministracion
{
    public static function vistaPanelAdministracion(Router $router)
    {
        estaAutenticado();
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET["resultado"] ?? null;
        $router->render("admin/panelAdministracion", [
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }
}