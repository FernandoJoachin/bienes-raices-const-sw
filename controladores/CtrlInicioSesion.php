<?php
namespace Controlador;

use Modelo\Usuario;
use MVC\Router;
class CtrlInicioSesion
{
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

    public static function vistaRestablecerContraseña(Router $router)
    {
        $router->render("login/restablecerContraseña");
    }
  
    public static function vistaOlvideContraseña(Router $router)
    {
        $router->render("login/olvideContraseña");
    }

    public static function iniciarSesion()
    {
        $auth = new Usuario($_POST);
        $errores = $auth->validar();

        if(empty($errores)){
            $resultado = $auth->comprobarUsuario();
            if(!$resultado){
                $errores = Usuario::getErrores();
            }else{
                $autenticado = $auth->comprobarPassWord($resultado);
                if($autenticado){
                    $auth->autenticar();
                }else{
                    $errores = Usuario::getErrores();
                }
            }
        }

        $_SESSION["respuesta"] = [
            "errores" => $errores
        ];
        header("Location: /iniciar-sesion");
    }

    public static function cerrarSesion()
    {
        $_SESSION = [];
        header("Location: /");
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

