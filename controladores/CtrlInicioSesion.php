<?php
namespace Controlador;

use Modelo\Usuario;
use MVC\Router;
use Utilidades\Email;

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
    public static function vistaRecuperarContraseña(Router $router)
    {
        $errores = [];

        $mensajeResultado = "";
        $enviado = "false";

        if(isset($_SESSION["respuesta"])){
            $mensajeResultado = $_SESSION["respuesta"]["mensajeResultado"];
            $enviado = $_SESSION["respuesta"]["enviado"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("login/olvideContraseña", [
            "mensajeResultado" => $mensajeResultado,
            "enviado" => $enviado,
            "errores" => $errores
        ]);
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
     * Muestra la vista de olvidé mi contraseña.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaOlvideContraseña(Router $router)
    public static function recuperarContraseña()
    {

        $mensajeResultado = "";
        $enviado = false;
        $correcto = false;

        if(isset($_SESSION["respuesta"])){
            $mensajeResultado = $_SESSION["respuesta"]["mensajeResultado"];
            $enviado = $_SESSION["respuesta"]["enviado"];
            $correcto = $_SESSION["respuesta"]["correcto"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("login/olvideContraseña",[
            "mensajeResultado" => $mensajeResultado,
            "enviado" => $enviado,
            "correcto" => $correcto
        ]);
        $usuario = new Usuario($_POST);
        $usuario->validarEmail();
        $errores = Usuario::obtenerErrores();

        if (empty($errores)) {
            $usuario = Usuario::buscarPorColumna('email', $usuario->email);

            if($usuario && $usuario->estaConfirmado) {
                $usuario->crearToken();

                $usuario->almacenarEnBD();
                
                $datosUsuario = [
                    "email" => $usuario->email,
                    "nombre" => $usuario->nombre,
                    "token" => $usuario->token
                ];
                
                $email = new Email( $datosUsuario );
                $email->enviarInstrucciones();

            } 

            $_SESSION["respuesta"] = [
                "errores" => $errores
            ];
        }
    }

    /**
     * Envia instrucciones al usuario para que restablezca su contraseña .
     *
     * @return void
     */

     public static function olvideContraseña(Router $router) {
        $errores = [];
        $usuario = new Usuario($_POST["email"]);
        $errores = $usuario->validarCorreo();

        if(empty($errores)) {
            // Buscar el usuario
            $usuario = Usuario::encontrarRegistroPorEmail('email', $usuario->email);

            if($usuario) {
                // Enviar el email
                $email = new Email( "email" );

                $email->enviarCorreoReestablecerContraseña();
                header("Location: /olvide-contraseña");
                exit;
            }
        }
        $_SESSION["respuesta"] = [
            "mensajeResultado" => "Ingrese un correo válido",
            "correcto" => false,
            "enviado" => false
        ];
        header("Location: /olvide-contraseña");

    }
}