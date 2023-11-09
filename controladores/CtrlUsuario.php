<?php
namespace Controlador;

use MVC\Router;
class CtrlUsuario
{
    /**
     * Muestra la vista para crear un nuevo usuario.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
    */
    public static function vistaCrearUsuario(Router $router)
    {
        $router->render("usuarios/crear");
    }

    /**
     * Crea un nuevo usuario.
     *
     * @return void
    */
    public static function crearUsuario()
    {
        echo "creando usuario...";
    }
}