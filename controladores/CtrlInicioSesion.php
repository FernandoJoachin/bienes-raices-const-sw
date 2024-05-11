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
     * Muestra la vista de olvidé mi contraseña.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaOlvideContraseña(Router $router)
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
    }

    /**
     * Muestra la vista de restablecer mi contraseña.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaRestablecerContraseña(Router $router)
    {
        $token = $_GET["token"] ?? null;
        existeToken($token);
        $usuario = Usuario::buscarPorColumna('token', $token);
        existeUsuario($usuario);

        $errores = [];
        if(isset($_SESSION["respuesta"])){
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("login/restablecerContraseña",[
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
                    $usuarioBD = Usuario::buscarPorColumna('email', $_POST["email"]);
                    $usuarioBD->autenticarUsuario();
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
        exit;
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

        $usuario = Usuario::buscarPorColumna('token', $_GET["token"]);
        $usuario->sincronizarCambiosConObjeto($_POST);

        $usuario->validarPassword();
        $errores = Usuario::obtenerErrores();
        if(empty($errores)){
            $usuario->hashearContraseña();
            $usuario->token = null;
            $resultado = $usuario->almacenarEnBD();
            if($resultado){
                header("Location: /iniciar-sesion");
                exit;
            }
        }else{
            $_SESSION["respuesta"] = [
                "errores" => $errores
            ];
            header("Location: /restablecer-contraseña?token=$usuario->token");
            exit;
        }

    }

    /**
     * Envia instrucciones al usuario para que restablezca su contraseña .
     *
     * @return void
     */

     public static function olvideContraseña() {
        $errores = [];
        $usuario = new Usuario($_POST["email"]);
        $errores = $usuario->validarCorreo();

        if(empty($errores)) {
            // Buscar el usuario
            $usuario = Usuario::buscarPorColumna('email', $usuario->email);

            if($usuario) {
                $usuario->crearToken();
                $usuario->almacenarEnBD();

                // Enviar el email
                $email = new Email( "email" );
                $email->enviarCorreoReestablecerContraseña($usuario->token);
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