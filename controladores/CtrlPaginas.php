<?php
namespace Controlador;

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
        $router->render("paginas/contacto");
    }

    public static function enviarCorreoContacto(Router $router){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $respuestasFormulario = $_POST["contacto"]; 
   
            include __DIR__ . "/../includes/template/credenciales_correo.php";
            
            $contenidoCorreo = "<html>";
            $contenidoCorreo .= "<p>Tienes un nuevo mensaje </p>";
            $contenidoCorreo .= "<p>Nombre: ". $respuestasFormulario["nombre"] . " </p>";
            $contenidoCorreo .= "<p>Mensaje: ". $respuestasFormulario["mensaje"] . " </p>";

            $contenidoCorreo .= "<p>Compra o Vende: ". $respuestasFormulario["tipo"] . " </p>";
            $contenidoCorreo .= "<p>Presupuesto o Precio: $". $respuestasFormulario["precio"] . " </p>";

            if($respuestasFormulario["contacto"] === "teléfono"){
                $contenidoCorreo .= "<p>Eligio ser contactado por teléfono:</p>";
                $contenidoCorreo .= "<p>Telefono: ". $respuestasFormulario["telefono"] . " </p>";
                $contenidoCorreo .= "<p>Fecha de contacto: ". $respuestasFormulario["fecha"] . " </p>";
                $contenidoCorreo .= "<p>Hora: ". $respuestasFormulario["hora"] . " </p>";
            }else{
                $contenidoCorreo .= "<p>Eligió ser contactado por email:</p>";
                $contenidoCorreo .= "<p>Email: ". $respuestasFormulario["email"] . " </p>";
            }
            $contenidoCorreo .= "</html>";
            $mail->Subject = "Mensaje del formulario de contacto";
            $mail->Body = $contenidoCorreo;
            if( $mail->send()){
                $enviado = true;
                $mensajeResultado = "El mensaje se envio correctamente";
            }else{
                $enviado = false;
                $mensajeResultado = "Sucedio un error, el mensaje no se pudo enviar";
            }
        }
        $router->render("paginas/contacto", [
            "mensajeResultado" => $mensajeResultado,
            "enviado" => $enviado
        ]);
    }
}

