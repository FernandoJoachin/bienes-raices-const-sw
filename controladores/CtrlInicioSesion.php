<?php
namespace Controlador;

use MVC\Router;
class CtrlInicioSesion
{
    public static function vistaRestablecerContraseña(Router $router)
    {
        $router->render("login/restablecerContraseña");
    }

    public static function restablecerContraseña()
    {
        echo "restableciendo contraseña...";
    }
}

