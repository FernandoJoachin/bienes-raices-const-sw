<?php
namespace Controlador;

use MVC\Router;
use Modelo\Propiedad;
use Modelo\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class CtrlPropiedades
{
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
            $carpetaImg = "../../imagenes/";
            if (!is_dir($carpetaImg)) {
                mkdir($carpetaImg);
            }
            $img->save($carpetaImg . $nombreImg);
            $propiedad->almacenarEnBD();
        } else {
            $_SESSION["respuesta"] = [
                "propiedad" => $propiedad,
                "nombreImg" => $nombreImg,
                "errores" => $errores
            ];

            header("Location: /propiedades/crear");
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

            $propiedad->almacenarEnBD();
            
        } else {
            // Guardar datos en sesión para mostrar en el formulario
            $_SESSION["respuesta"] = [
                "propiedad" => $propiedad,
                "nombreImg" => $nombreImg,
                "errores" => $errores
            ];

            header("Location: /propiedades/actualizar?id=" . $idPropiedad);
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
                $tipo = $_POST["tipo"];
                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::encontrarRegistroPorId($id);
                    $propiedad->borrarRegistroBD($tipo);
                }
            }
        }
    }
}