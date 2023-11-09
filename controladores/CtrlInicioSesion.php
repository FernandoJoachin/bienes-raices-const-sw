<?php
namespace Controlador;

use MVC\Router;
class CtrlInicioSesion
{
    public static function vistaRestablecerContraseña(Router $router)
    {
        $router->render("login/restablecerContraseña");
    }

    public static function vistaOlvideContraseña(Router $router)
    {
        $router->render("login/olvideContraseña");
    }

    public static function restablecerContraseña()
    {
        echo "restableciendo contraseña...";
    }

    public static function olvideContraseña()
    {
        echo "enviando instrucciones...";
    }
}

