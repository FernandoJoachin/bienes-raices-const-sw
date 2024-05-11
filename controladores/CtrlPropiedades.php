<?php
namespace Controlador;

use MVC\Router;
use Modelo\Propiedad;
use Modelo\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;
use Utilidades\Paginacion;

class CtrlPropiedades
{
    /**
     * Muestra la vista de la tabla de propiedades paginada.
     *
     * @param Router $router El objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaTablaPropiedades(Router $router){
        estaAutenticado();

        $pagina_actual = filter_var($_GET["page"] ?? "", FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){
            header("Location: /admin/propiedades?page=1");
        }

        $registros_por_pagina = 5;
        $total_registros = Propiedad::total();
        $paginacion = new Paginacion($pagina_actual,  $registros_por_pagina, $total_registros);

        if($paginacion->total_paginas() < $pagina_actual){
            header("Location: /admin/propiedades?page=1");
            return;
        }

        $propiedades = Propiedad::paginar($registros_por_pagina, $paginacion->offset());
        $router->render("propiedades/tablaPropiedades",[
            "titulo" => "Tabla de Propiedades",
            "propiedades" => $propiedades,
            "paginacion" => $paginacion->paginacion()
        ]);
    }
    /**
     * Muestra la vista para crear una nueva propiedad.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     */
    public static function vistaCrearPropiedad(Router $router)
    {
        estaAutenticado();
        $propiedad = new Propiedad();
        $vendedores = Vendedor::obtenerTodosRegistrosEnBD();
        $errores = [];

        if(isset($_SESSION["respuesta"])){
            $propiedad = $_SESSION["respuesta"]["propiedad"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("propiedades/crear", [
            "propiedad" => $propiedad, 
            "vendedores" => $vendedores,
            "errores" =>  $errores
        ]);
    }

    /**
     * Muestra la vista para actualizar una propiedad existente.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     */
    public static function vistaActualizarPropiedad(Router $router)
    {
        estaAutenticado();
        $id = validarORedireccionar("/admin");
        $propiedad = Propiedad::encontrarRegistroPorId($id);
        $vendedores = Vendedor::obtenerTodosRegistrosEnBD();
        $errores = Propiedad::obtenerErrores();

        if(isset($_SESSION["respuesta"])){
            $propiedad = $_SESSION["respuesta"]["propiedad"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render(
            "propiedades/actualizar", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    /**
     * Crea una nueva propiedad utilizando los datos del formulario.
     * 
     * @return void
     */
    public static function crearPropiedad()
    {
        $propiedad = new Propiedad($_POST["propiedad"]);
        $nombreImg = md5(uniqid(rand(), true)) . ".jpg";
        $errores = Propiedad::obtenerErrores();

        if ($_FILES["propiedad"]["tmp_name"]["img"]) {
            $img = Image::make(
                $_FILES["propiedad"]["tmp_name"]["img"]
            )->fit(800, 600);

            $propiedad->establecerImagen($nombreImg);
        }

        $errores = $propiedad->validarErrores();
    
        if (empty($errores)) {
            if (!is_dir(CARPETA_IMG)) {
                mkdir(CARPETA_IMG);
            }
            $img->save(CARPETA_IMG . $nombreImg);
            $resultado = $propiedad->almacenarEnBD();

            if($resultado){
                header("Location: /admin/propiedades?page=1&resultado=1");
                exit;
            }
        } else {
            $_SESSION["respuesta"] = [
                "propiedad" => $propiedad,
                "nombreImg" => $nombreImg,
                "errores" => $errores
            ];

            header("Location: /admin/propiedades/crear");
            exit;
        }
    }

    /**
     * Actualiza una propiedad existente utilizando los datos del formulario.
     * 
     * @return void
     */
    public static function actualizarPropiedad()
    {
        $args = $_POST["propiedad"];
        $idPropiedad = $_GET["id"];

        $propiedad = Propiedad::encontrarRegistroPorId($idPropiedad);
        $propiedad->sincronizarCambiosConObjeto($args);
        
        $nombreImg = md5(uniqid(rand(), true)) . ".jpg";

        if ($_FILES["propiedad"]["tmp_name"]["img"]) {
            $img = Image::make(
                $_FILES["propiedad"]["tmp_name"]["img"])->fit(800, 600
            );
            $propiedad->establecerImagen($nombreImg);
        }

        $errores = $propiedad->validarErrores();

        if (empty($errores)) {
            if ($_FILES["propiedad"]["tmp_name"]["img"]) {
                $img->save(CARPETA_IMG . $nombreImg);
            }

            $resultado = $propiedad->almacenarEnBD();
            if($resultado){
                header("Location: /admin/propiedades?page=1&resultado=2");
                exit;
            }
            
        } else {
            // Guardar datos en sesión para mostrar en el formulario
            $_SESSION["respuesta"] = [
                "propiedad" => $propiedad,
                "nombreImg" => $nombreImg,
                "errores" => $errores
            ];

            header("Location: /admin/propiedades/actualizar?id=" . $idPropiedad);
            exit;
        }
    }

    /**
     * Elimina una propiedad existente.
     * 
     * @return void
     */
    public static function eliminarPropiedad()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $propiedad = Propiedad::encontrarRegistroPorId($id);
                $resultado = $propiedad->borrarRegistroBD();

                if($resultado){
                    $propiedad->borrarArchivoImagen();
                    //Redireccionar al usuario;
                    header("Location: /admin/propiedades?page=1&resultado=3");
                }
            }
        }
    }
}