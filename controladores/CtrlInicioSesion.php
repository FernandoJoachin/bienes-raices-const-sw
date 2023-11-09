<?php
namespace Controlador;

use Modelo\Usuario;
use MVC\Router;

class CtrlInicioSesion
{
    /**
     * Muestra la vista para iniciar sesión.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaIniciarSesion(Router $router)
    {
        $errores = [];

        if(isset($_SESSION["respuesta"])){
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("login/iniciarSesion", [
            "errores" => $errores
        ]);
    }

    /**
     * Muestra la vista de restablecer mi contraseña.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaRestablecerContraseña(Router $router)
    {
        $router->render("login/restablecerContraseña");
    }
  
    /**
     * Muestra la vista de olvidé mi contraseña.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaOlvideContraseña(Router $router)
    {
        $router->render("login/olvideContraseña");
    }

    /**
     * Inicia la sesión del usuario.
     *
     * @return void
     */
    public static function iniciarSesion()
    {
        $usuario = new Usuario($_POST);
        $errores = $usuario->validarErrores();

        if (empty($errores)) {
            $existeUsuarioBD = $usuario->comprobarUsuario();

            if ($existeUsuarioBD) {
                $contraseñaCorrecta = $usuario->comprobarContraseña($existeUsuarioBD);

                if ($contraseñaCorrecta) {
                    $usuario->autenticarUsuario();
                } else {
                    $errores = Usuario::obtenerErrores();
                }
            } else {
                $errores = Usuario::obtenerErrores();
            }
        }

        $_SESSION["respuesta"] = [
            "errores" => $errores
        ];
        header("Location: /iniciar-sesion");
    }

    /**
     * Cierra la sesión y redirige a la página principal.
     *
     * @return void
     */
    public static function cerrarSesion()
    {
        $_SESSION = [];
        header("Location: /");
    }    
  
    /**
     * Restablece la contraseña del usuario.
     *
     * @return void
     */
    public static function restablecerContraseña()
    {
        echo "restableciendo contraseña...";
    }

    /**
     * Envia instrucciones al usuario para que restablezca su contraseña .
     *
     * @return void
     */
    public static function olvideContraseña()
    {
        echo "enviando instrucciones...";
    }
}