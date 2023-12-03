<?php
namespace Controlador;

use Modelo\Usuario;
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
        estaAutenticado();
        $usuario = new Usuario();

        $errores = [];

        if(isset($_SESSION["respuesta"])){
            $usuario = $_SESSION["respuesta"]["usuario"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("usuarios/crear", [
            "usuario" => $usuario,
            "errores" =>  $errores
        ]);

    }

    /**
     * Crea un nuevo usuario.
     *
     * @return void
    */
    public static function crearUsuario()
    {
        $usuario = new Usuario($_POST);

        $usuario->validarConfirmacionDeContraseña($_POST["c-password"]);

        $usuario->buscarPorColumna("email", $_POST["email"]);

        $errores = $usuario->validarErrores();

        if (empty($errores)) {
            $usuario->hashearContraseña();
            $usuario->almacenarEnBD();
        } else {
            $_SESSION["respuesta"] = [
                "usuario" => $usuario,
                "errores" => $errores
            ];
            header("Location: /usuarios/crear");
            exit;
        }
        
    }

    
}