<?php
namespace Controlador;

use MVC\Router;
use Modelo\Propiedad;
use Modelo\Vendedor;
class CtrlPanelAdministracion
{
    /**
     * Muestra la vista del panel de administración.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaPanelAdministracion(Router $router)
    {
        estaAutenticado();
        $propiedades = Propiedad::obtenerTodosRegistrosEnBD();
        $vendedores = Vendedor::obtenerTodosRegistrosEnBD();
        $resultado = $_GET["resultado"] ?? null;
        $router->render("admin/panelAdministracion", [
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }
}