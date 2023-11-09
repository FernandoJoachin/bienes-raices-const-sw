<?php
namespace Controlador;

use MVC\Router;
class CtrlUsuario
{
    public static function vistaCrearUsuario(Router $router)
    {
        $router->render("usuarios/crear");
    }

    public static function crearUsuario()
    {
        echo "creando usuario...";
    }
}