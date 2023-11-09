<?php
namespace Controlador;

use MVC\Router;
use Modelo\Vendedor;

class CtrlVendedor
{

    public static function vistaCrearVendedor(Router $router)
    {
        estaAutenticado();
        $vendedor = new Vendedor();
        $errores = [];
        if(isset($_SESSION["respuesta"])){
            $vendedor = $_SESSION["respuesta"]["vendedor"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("vendedores/crear", [
            "vendedor" => $vendedor, 
            "errores" =>  $errores
        ]);
    }

    public static function vistaActualizarVendedor(Router $router)
    {
        estaAutenticado();
        $id = validarORedireccionar("/admin");
        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();

        if(isset($_SESSION["respuesta"])){
            $vendedor = $_SESSION["respuesta"]["vendedor"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("vendedores/actualizar", [
            "vendedor" => $vendedor, 
            "errores" =>  $errores
        ]);      
    }

    public static function crearVendedor()
    {  
        $vendedor = new Vendedor($_POST["vendedor"]);
        $errores = $vendedor->validar();
        $_SESSION["respuesta"] = [
            "vendedor" => $vendedor,
            "errores" => $errores
        ];
        //Actualizar en la base de datos
        if(empty($errores)) {
            $vendedor->guardar();
        } else {
            $_SESSION["respuesta"] = [
                "vendedor" => $vendedor,
                "errores" => $errores
            ];
            header("Location: /vendedores/crear");
        }
    }


    public static function actualizarVendedor()
    {
        $idUsuario = $_GET["id"];
        $vendedor = Vendedor::find($idUsuario);
        $args = $_POST["vendedor"];
        $vendedor->sincronizar($args);
        $errores = $vendedor->validar();  

          
        if(empty($errores)){
            $vendedor->guardar();
        } else {
            $_SESSION["respuesta"] = [
                "vendedor" => $vendedor,
                "errores" => $errores
            ];
            header("Location: /vendedores/actualizar?id=". $vendedor->id);
        }
    }

    public static function eliminarVendedor()
    {
        $id = $_POST["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            $tipo = $_POST["tipo"];
            if(validarTipoContenido($tipo)){
                $propiedad = Vendedor::find($id);
                $propiedad->eliminar($tipo);
            }   
        } 
    }
}