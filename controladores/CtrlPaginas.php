<?php
namespace Controlador;

use Utilidades\Email;
use Modelo\Propiedad;
use MVC\Router;

class CtrlPaginas
{
    /**
     * Muestra la página de inicio con un límite de 3 propiedades.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function index(Router $router)
    {
        $propiedades = Propiedad::obtenerRegistrosConLimite(3);
        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "esInicio" => true
        ]);
    }

    /**
     * Muestra la página "Nosotros".
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaNosotros(Router $router)
    {
        $router->render("paginas/nosotros");
    }

    /**
     * Muestra la página de todas las propiedades.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaPropiedades(Router $router)
    {
        $propiedades = Propiedad::obtenerTodosRegistrosEnBD();
        $router->render("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }

    /**
     * Muestra la página de una propiedad específica.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaPropiedad(Router $router)
    {
        $id = validarORedireccionar("/propiedades");
        $propiedad = Propiedad::encontrarRegistroPorId($id);
        $router->render("paginas/propiedad", [
            "propiedad" => $propiedad
        ]);
    }

    /**
     * Muestra la página de blogs.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaBlogs(Router $router)
    {
        $router->render("paginas/blogs");
    }

    /**
     * Muestra la página de una entrada específica de blog.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
    public static function vistaEntrada(Router $router)
    {
        $router->render("paginas/entrada");
    }

    /**
     * Muestra la página formulario de contacto.
     *
     * @param Router $router Objeto Router para renderizar la vista.
     * @return void
     */
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

    /**
     * Envía el correo de contacto y redirige a la página de contacto.
     *
     * @return void
     */
    public static function enviarCorreoContacto()
    {
        $email = new Email("contacto");

        if ($email->enviarCorreoContacto()) {
            header("Location: /contacto");
        }
    }
}