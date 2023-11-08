<?php

namespace Controlador;

use MVC\Router;
use Modelo\Articulo;
use Intervention\Image\ImageManagerStatic as Image;

class CtrlBlog
{
    public static function vistaCrearArticulo(Router $router)
    {
        $articulo = new Articulo();
        $errores = [];

        if (isset($_SESSION["respuesta"])) {
            $articulo = $_SESSION["respuesta"]["articulo"];
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("blog/crear", [
            "articulo" => $articulo,
            "errores" => $errores
        ]);
    }

    public static function CrearArticulo()
    {
        $articulo = new Articulo($_POST["articulo"]);
        $errores = $articulo->validar();
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        if ($_FILES['articulo']['tmp_name']["imagen"]) {
            $imagen = Image::make($_FILES['articulo']['tmp_name']["imagen"])->fit(800, 600);
            $articulo->setImagen($nombreImagen);
        }

        $_SESSION["respuesta"] = [
            "articulo" => $articulo,
            "errores" => $errores
        ];

        if (empty($errores)) {
            if (!is_dir(CARPETA_IMG)) {
                mkdir(CARPETA_IMG);
            }

            $imagen->save(CARPETA_IMG . $nombreImagen);
            $articulo->guardar();
        } else {
            $_SESSION["respuesta"] = [
                "articulo" => $articulo,
                "errores" => $errores
            ];
            
            header("Location: /blog/crear");
        }
    }
}
