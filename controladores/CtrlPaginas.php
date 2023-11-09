<?php
namespace Controlador;

use Utilidades\Email;
use Modelo\Propiedad;
use MVC\Router;

class CtrlPaginas
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

    public static function vistaContacto(Router $router)
    {
        $mensajeResultado = "";
        $enviado = "false";
        if(isset($_SESSION["respuesta"])){
            $mensajeResultado = $_SESSION["respuesta"]["mensajeResultado"];
            $enviado = $_SESSION["respuesta"]["enviado"];
            unset($_SESSION["respuesta"]);
        }
        $router->render("paginas/contacto", [
            "mensajeResultado" => $mensajeResultado,
            "enviado" => $enviado
        ]);
    }

    public static function enviarCorreoContacto(){
        $email = new Email("contacto");
        if($email->enviarCorreoContacto()){
            header("Location: /contacto");
        }
    }
}

