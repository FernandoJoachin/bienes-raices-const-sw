<?php
namespace Controlador;

use Modelo\Usuario;
use MVC\Router;
use Utilidades\Paginacion;

class CtrlUsuario
{

    public static function vistaTablaUsuarios(Router $router){
        estaAutenticado();

        $pagina_actual = filter_var($_GET["page"] ?? "", FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){
            header("Location: /admin/usuarios?page=1");
        }

        $registros_por_pagina = 5;
        $total_registros = Usuario::total();
        $paginacion = new Paginacion($pagina_actual,  $registros_por_pagina, $total_registros);

        if($paginacion->total_paginas() < $pagina_actual){
            header("Location: /admin/usuarios?page=1");
            return;
        }

        $usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset());
        $router->render("usuarios/tablaUsuarios",[
            "titulo" => "Tabla de Usuarios",
            "usuarios" => $usuarios,
            "paginacion" => $paginacion->paginacion()
        ]);
    }

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
            $resultado = $usuario->almacenarEnBD();
            if($resultado){
                header("Location: /admin/usuarios?page=1&resultado=3");
            }
        } else {
            $_SESSION["respuesta"] = [
                "usuario" => $usuario,
                "errores" => $errores
            ];
            header("Location: /admin/usuarios/crear");
            exit;
        }
        
    }

    
}