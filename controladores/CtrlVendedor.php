<?php
namespace Controlador;

use MVC\Router;
use Modelo\Vendedor;

class CtrlVendedor
{
    /**
     * Muestra la vista para crear un nuevo vendedor.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
    */
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

    /**
     * Muestra la vista para actualizar un vendedor existente.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
    */
    public static function vistaActualizarVendedor(Router $router)
    {
        estaAutenticado();
        $id = validarORedireccionar("/admin");
        $vendedor = Vendedor::encontrarRegistroPorId($id);
        $errores = Vendedor::obtenerErrores();

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

    /**
     * Crea un nuevo vendedor utilizando los datos del formulario.
     *
     * @return void
    */
    public static function crearVendedor()
    {  
        $vendedor = new Vendedor($_POST["vendedor"]);
        $errores = $vendedor->validarErrores();
        $_SESSION["respuesta"] = [
            "vendedor" => $vendedor,
            "errores" => $errores
        ];

        if(empty($errores)) {
            $vendedor->almacenarEnBD();
        } else {
            $_SESSION["respuesta"] = [
                "vendedor" => $vendedor,
                "errores" => $errores
            ];
            header("Location: /vendedores/crear");
        }
    }

    /**
     * Actualiza un vendedor existente con los datos del formulario.
     *
     * @return void
    */
    public static function actualizarVendedor()
    {
        $idVendedor = $_GET["id"];
        $vendedor = Vendedor::encontrarRegistroPorId($idVendedor);
        $args = $_POST["vendedor"];
        $vendedor->sincronizarCambiosConObjeto($args);
        $errores = $vendedor->validarErrores();  

        if(empty($errores)){
            $vendedor->almacenarEnBD();
        } else {
            $_SESSION["respuesta"] = [
                "vendedor" => $vendedor,
                "errores" => $errores
            ];
            header("Location: /vendedores/actualizar?id=". $idVendedor);
        }
    }

    /**
     * Elimina un vendedor existente.
     *
     * @return void
    */
    public static function eliminarVendedor()
    {
        $id = $_POST["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            $tipo = $_POST["tipo"];
            if(validarTipoContenido($tipo)){
                $propiedad = Vendedor::encontrarRegistroPorId($id);
                $propiedad->borrarRegistroBD($tipo);
            }   
        } 
    }
}