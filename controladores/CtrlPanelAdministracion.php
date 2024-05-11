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
        
        $router->render("admin/panelAdministracion", [

        ]);
    }
}