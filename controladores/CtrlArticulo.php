<?php
namespace Controlador;

use MVC\Router;
use Modelo\Articulo;
use Intervention\Image\ImageManagerStatic as Image;
use Utilidades\Paginacion;

class CtrlArticulo
{
    /**
     * Muestra la vista de la tabla de artículos paginada.
     *
     * @param Router $router El objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaTablaArticulos(Router $router){
        estaAutenticado();

        $pagina_actual = filter_var($_GET["page"] ?? "", FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){
            header("Location: /admin/articulos?page=1");
        }

        $registros_por_pagina = 5;
        $total_registros = Articulo::total();
        $paginacion = new Paginacion($pagina_actual,  $registros_por_pagina, $total_registros);

        if($paginacion->total_paginas() < $pagina_actual){
            header("Location: /admin/articulos?page=1");
            return;
        }

        $articulos = Articulo::paginar($registros_por_pagina, $paginacion->offset());
        $router->render("articulos/tablaArticulos",[
            "titulo" => "Tabla de Articulos",
            "articulos" => $articulos,
            "paginacion" => $paginacion->paginacion()
        ]);
    }
    /**
     * Muestra la vista para crear un nuevo artículo.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaCrearArticulo(Router $router)
    {
        estaAutenticado();
    
        $articulo = new Articulo();
        $errores = [];
    
        if (isset($_SESSION["respuesta"])) {
            $respuesta = $_SESSION["respuesta"];
            $articulo = $respuesta["articulo"];
            $errores = $respuesta["errores"];
            unset($respuesta);
        }
    
        $router->render("articulos/crear", [
            "articulo" => $articulo,
            "errores" => $errores
        ]);
    }

    /**
     * Muestra la vista para actualizar un artículo existente.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaActualizarArticulo(Router $router)
    {        
        estaAutenticado();
        $id = validarORedireccionar("/admin");
        $articulo = Articulo::encontrarRegistroPorId($id);
        $errores = Articulo::obtenerErrores();

        if(isset($_SESSION["respuesta"])){
            $articulo = $_SESSION["respuesta"]["articulo"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("articulos/actualizar", [
            "articulo" => $articulo,
            "errores" => $errores
        ]);
    }

    /**
     * Crea un nuevo artículo utilizando los datos del formulario.
     *
     * @return void
     */
    public static function crearArticulo()
    {
        $datosArticulo = $_POST["articulo"];
        $articulo = new Articulo($datosArticulo);

        if ($_FILES['articulo']['tmp_name']["imagen"]) {
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            $imagen = Image::make($_FILES['articulo']['tmp_name']["imagen"])->fit(800, 600);
            $articulo->establecerImagen($nombreImagen);
        }

        $errores = $articulo->validarErrores();

        if (empty($errores)) {
            if (!is_dir(CARPETA_IMG)) {
                mkdir(CARPETA_IMG);
            }

            $imagen->save(CARPETA_IMG . $nombreImagen);
            $resultado = $articulo->almacenarEnBD();
            if($resultado){
                header("Location: /admin/articulos?page=1&resultado=1");
                exit;
            }
        } else {
            $_SESSION["respuesta"] = [
                "articulo" => $articulo,
                "errores" => $errores
            ];
            
            header("Location: /admin/articulos/crear");
        }
    }

    /**
     * Actualiza un artículo existente utilizando los datos del formulario.
     *
     * @return void
     */
    public static function actualizarArticulo()
    {
        $idArticulo = $_GET["id"];
        $articulo = Articulo::encontrarRegistroPorId($idArticulo);
        $args = $_POST["articulo"];
        $articulo->sincronizarCambiosConObjeto($args);
        $errores = $articulo->validarErrores(); 
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        if ($_FILES['articulo']['tmp_name']["imagen"]) {
            $imagen = Image::make($_FILES['articulo']['tmp_name']["imagen"])->fit(800, 600);
            $articulo->establecerImagen($nombreImagen);
        }

        if (empty($errores)) {
            if ($_FILES['articulo']['tmp_name']["imagen"]) {
               $imagen->save(CARPETA_IMG . $nombreImagen);
            }
            $resultado = $articulo->almacenarEnBD();
            if($resultado){
                header("Location: /admin/articulos?page=1&resultado=2");
                exit;
            }
        } else {
            $_SESSION["respuesta"] = [
                "articulo" => $articulo,
                "errores" => $errores
            ];
            header("Location: /admin/articulos/actualizar?id=". $idArticulo);
        }
    }

    /**
     * Elimina un artículo existente.
     *
     * @return void
     */
    public static function eliminarArticulo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $idArticulo = $_POST['id'];
            $idArticulo = filter_var($idArticulo, FILTER_VALIDATE_INT);
    
            if ($idArticulo) {
                $articulo = Articulo::encontrarRegistroPorId($idArticulo);
                $resultado = $articulo->borrarRegistroBD();
                if($resultado){
                    $articulo->borrarArchivoImagen();
                    //Redireccionar al usuario;
                    header("Location: /admin/articulos?page=1&resultado=3");
                }
            }
        }
    }
}
