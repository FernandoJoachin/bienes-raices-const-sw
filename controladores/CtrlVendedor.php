<?php
namespace Controlador;

use MVC\Router;
use Modelo\Vendedor;
use Utilidades\Paginacion;

class CtrlVendedor
{

    public static function vistaTablaVendedores(Router $router){
        estaAutenticado();

        $pagina_actual = filter_var($_GET["page"] ?? "", FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){
            header("Location: /admin/vendedores?page=1");
        }

        $registros_por_pagina = 5;
        $total_registros = Vendedor::total();
        $paginacion = new Paginacion($pagina_actual,  $registros_por_pagina, $total_registros);

        if($paginacion->total_paginas() < $pagina_actual){
            header("Location: /admin/vendedores?page=1");
            return;
        }

        $vendedores = Vendedor::paginar($registros_por_pagina, $paginacion->offset());
        $router->render("vendedores/tablaVendedores",[
            "titulo" => "Tabla de Vendedores",
            "vendedores" => $vendedores,
            "paginacion" => $paginacion->paginacion()
        ]);
    }

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
            $resultado = $vendedor->almacenarEnBD();
            if($resultado){
                header("Location: /admin/vendedores?page=1&resultado=1");
                exit;
            }
        } else {
            $_SESSION["respuesta"] = [
                "vendedor" => $vendedor,
                "errores" => $errores
            ];
            header("Location: /admin/vendedores/crear");
            exit;
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
            $resultado = $vendedor->almacenarEnBD();
            if($resultado){
                header("Location: /admin/vendedores?page=1&resultado=2");
                exit;
            }
        } else {
            $_SESSION["respuesta"] = [
                "vendedor" => $vendedor,
                "errores" => $errores
            ];
            header("Location: /admin/vendedores/actualizar?id=". $idVendedor);
            exit;
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
            $propiedad = Vendedor::encontrarRegistroPorId($id);
            $resultado = $propiedad->borrarRegistroBD();  
            if($resultado){
                header("Location: /admin/vendedores?page=1&resultado=3");
            }
        } 
    }
}