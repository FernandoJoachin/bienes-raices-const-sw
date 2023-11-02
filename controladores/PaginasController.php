<?php
namespace Controlador;
use Modelo\Propiedad;
use MVC\Router;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades =  Propiedad::get(3);
        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "esInicio" => true
        ]);
    }

    public static function vistaNosotros(Router $router)
    {
        $router->render("paginas/nosotros");
    }

    public static function vistaPropiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render("paginas/propiedades",[
            "propiedades" => $propiedades
        ]);
    }

    public static function vistaPropiedad(Router $router)
    {
        $id = validarORedireccionar("/anuncios");
        $propiedad = Propiedad::find($id);
        $router->render("paginas/propiedad",[
            "propiedad" => $propiedad
        ]);
    }

    public static function vistaBlogs(Router $router)
    {
        $router->render("paginas/blogs",);
    }

    public static function vistaEntrada(Router $router)
    {
        $router->render("paginas/entrada");
    }
}

